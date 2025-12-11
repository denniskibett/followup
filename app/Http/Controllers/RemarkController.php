<?php

namespace App\Http\Controllers;

use App\Models\Remark;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RemarkController extends Controller
{
    public function __construct()
    {
        // NO MIDDLEWARE AT ALL
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        // DG sees only remarks on their reports
        if ($user->isDg()) {
            $remarks = Remark::whereHas('report', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with('report', 'ps')->orderByDesc('created_at')->paginate(12);
        } 
        // PS sees only their own remarks
        elseif ($user->isPs()) {
            $remarks = Remark::where('ps_id', $user->id)
                ->with('report', 'ps')
                ->orderByDesc('created_at')
                ->paginate(12);
        }
        // Admin sees all remarks
        else {
            $remarks = Remark::with('report', 'ps')->orderByDesc('created_at')->paginate(12);
        }
        
        return view('remarks.dashboard', compact('remarks'));
    }   

    public function create(Report $report)
    {
        $user = Auth::user();
        
        if (!$user->isPs() && !$user->isAdmin()) {
            abort(403, 'Only PS or Admin users can add remarks.');
        }

        // PS can only remark on reports not their own
        if ($user->isPs() && $report->user_id === $user->id) {
            abort(403, 'You cannot add remarks to your own reports.');
        }

        return view('remarks.create', compact('report'));
    }

    public function store(Request $request, Report $report)
    {
        $user = Auth::user();
        
        // Allow DG to add notes to their own reports, PS/Admin to add remarks
        if ($user->isDg() && $report->user_id === $user->id) {
            // DG can add notes to their own reports
            $validated = $request->validate([
                'remark' => 'required|string|max:1000',
                'status' => 'sometimes|string|in:reviewed,approved,needs_revision,note'
            ]);

            $remark = Remark::create([
                'report_id' => $report->id,
                'ps_id' => $user->id,
                'remark' => $validated['remark'],
                'status' => 'note', // DG remarks are always notes
            ]);
            
        } elseif ($user->isPs() || $user->isAdmin()) {
            // PS/Admin can add remarks
            
            // PS can only remark on reports not their own
            if ($user->isPs() && $report->user_id === $user->id) {
                abort(403, 'You cannot add remarks to your own reports.');
            }

            $validated = $request->validate([
                'remark' => 'required|string|max:1000',
                'status' => 'required|string|in:reviewed,approved,needs_revision'
            ]);

            $remark = Remark::create([
                'report_id' => $report->id,
                'ps_id' => $user->id,
                'remark' => $validated['remark'],
                'status' => $validated['status'],
            ]);
        } else {
            abort(403, 'Unauthorized to add remarks.');
        }

        return redirect()
            ->route('reports.show', $report->id)
            ->with('success', $user->isDg() ? 'Note added successfully.' : 'Remark added successfully.');
    }

    public function update(Request $request, Remark $remark)
    {
        $user = Auth::user();
        
        // Check if user is authorized to edit this remark
        if (!(
            ($user->isPs() && $remark->ps_id === $user->id) ||
            $user->isAdmin() ||
            ($user->isDg() && $remark->report->user_id === $user->id && $remark->ps_id === $user->id)
        )) {
            abort(403, 'Unauthorized to edit this remark.');
        }

        // Validate based on user role
        if ($user->isPs() || $user->isAdmin()) {
            $validated = $request->validate([
                'remark' => 'required|string|max:1000',
                'status' => 'required|string|in:reviewed,approved,needs_revision'
            ]);
            
            $remark->update([
                'remark' => $validated['remark'],
                'status' => $validated['status'],
            ]);
        } else {
            // DG can only edit their own notes
            $validated = $request->validate([
                'remark' => 'required|string|max:1000',
            ]);
            
            $remark->update([
                'remark' => $validated['remark'],
                // DG notes remain as 'note' status
            ]);
        }

        return redirect()
            ->route('reports.show', $remark->report_id)
            ->with('success', 'Remark updated successfully.');
    }

    public function destroy(Remark $remark)
    {
        $user = Auth::user();
        
        // Only PS who created the remark, Admin, or DG who created their own note can delete
        if (!(
            $user->isAdmin() || 
            ($user->isPs() && $remark->ps_id === $user->id) ||
            ($user->isDg() && $remark->report->user_id === $user->id && $remark->ps_id === $user->id)
        )) {
            abort(403, 'Unauthorized to delete this remark.');
        }

        $remark->delete();

        return back()->with('success', 'Remark deleted successfully.');
    }
}