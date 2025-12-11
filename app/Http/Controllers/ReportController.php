<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
public function index(Request $request)
    {
        $user = $request->user();
        $query = Report::with('user', 'remarks');

        // DG → only their own reports
        if ($user->isDg()) {
            $query->where('user_id', $user->id);
        }

        // PS → can filter
        if ($user->isPs() || $user->isAdmin()) {
            $this->applyFilters($query, $request);
        }

        // Get analytics data
        $analytics = $this->getAnalytics($user, $request);
        
        $reports = $query->orderByDesc('date')->paginate(12);
        
        return view('reports.index', compact('reports', 'analytics'));
    }

    private function getAnalytics($user, Request $request)
    {
        // If DG, only their own analytics
        if ($user->isDg()) {
            $totalReports = Report::where('user_id', $user->id)->count();
            $remarkedReports = Report::where('user_id', $user->id)
                ->whereHas('remarks')
                ->count();
            $thisWeekReports = Report::where('user_id', $user->id)
                ->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->count();
            
            // Get the latest report date
            $latestReport = Report::where('user_id', $user->id)
                ->orderByDesc('date')
                ->first();
            $lastReportDate = $latestReport ? $latestReport->date->format('M d, Y') : 'No reports yet';
            
        } else {
            // For PS/Admin, get filtered analytics
            $query = Report::query();
            
            if ($user->isPs()) {
                // PS sees only reports from their assigned DGs (you might need to adjust this based on your relationship)
                // For now, we'll show all reports
            }
            
            // Apply the same filters as in index
            $this->applyFilters($query, $request);
            
            $totalReports = $query->count();
            $remarkedReports = $query->clone()->whereHas('remarks')->count();
            $thisWeekReports = $query->clone()
                ->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->count();
            
            // Get unique DG count
            $uniqueDgs = $query->clone()->distinct('user_id')->count('user_id');
            
            // Get latest report date
            $latestReport = $query->clone()->orderByDesc('date')->first();
            $lastReportDate = $latestReport ? $latestReport->date->format('M d, Y') : 'No reports yet';
        }

        return [
            'totalReports' => $totalReports,
            'remarkedReports' => $remarkedReports,
            'thisWeekReports' => $thisWeekReports,
            'lastReportDate' => $lastReportDate,
            'uniqueDgs' => $uniqueDgs ?? 0,
            'pendingReview' => $totalReports - $remarkedReports,
        ];
    }

    public function create()
    {
        $user = auth()->user();
        if (!$user->isDg()) {
            abort(403, 'Only DG users can create reports.');
        }

        $today = Carbon::today();
        $monthWeek = 'December Week ' . ceil($today->day / 7); // Week of the month
        $yearWeek = 'Week ' . $today->weekOfYear;             // Week of the year

        $defaultName = "$monthWeek ($yearWeek) - "; // e.g., December Week 2 (Week 50) -

        return view('reports.create', compact('defaultName'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'details' => 'required|array|min:1',
            'details.*' => 'required|string|max:1000',
        ]);

        Report::create([
            'user_id' => $request->user()->id,
            'name' => $validated['name'],
            'date' => $validated['date'],
            'details' => $validated['details'],
        ]);

        return redirect()->route('reports.index')->with('success', 'Report submitted.');
    }


    public function show(Report $report)
    {
        $user = auth()->user();

        // DG can only view their own report
        if ($user->isDg() && $report->user_id !== $user->id) {
            abort(403);
        }

        $report->load('remarks.ps');
        return view('reports.show', compact('report'));
    }

    public function edit(Report $report)
    {
        $user = auth()->user();
        if (!$user->isDg() || $report->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $today = Carbon::today();
        $monthWeek = $today->format('F') . ' Week ' . ceil($today->day / 7);
        $yearWeek = 'Week ' . $today->weekOfYear;

        $defaultPrefix = "$monthWeek ($yearWeek) - ";

        // Remove previous prefix if it exists
        $activityName = str_replace($defaultPrefix, '', $report->name);

        $defaultName = $defaultPrefix . $activityName;

        return view('reports.edit', compact('report', 'defaultName'));
    }

    // Update Report
    public function update(Request $request, Report $report)
    {
        $user = auth()->user();

        // Only DG can update their own reports
        if (!$user->isDg() || $report->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'details' => 'required|array|min:1',
            'details.*' => 'required|string|max:1000',
        ]);

        $report->update([
            'name' => $validated['name'],
            'date' => $validated['date'],
            'details' => $validated['details'],
        ]);

        return redirect()->route('reports.index')->with('success', 'Report updated successfully.');
    }

    private function applyFilters($query, Request $request): void
    {
        if ($request->filled('dg')) {
            $query->where('user_id', $request->input('dg'));
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('date', [$request->from, $request->to]);
        }

        if ($request->filled('status')) {
            if ($request->status === 'remarked') {
                $query->has('remarks');
            } else {
                $query->doesntHave('remarks');
            }
        }
    }
}
