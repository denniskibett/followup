<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $dateFormat = \App\Helpers\SystemHelper::dateFormat();

        // Initialize all variables with defaults
        $myReports = collect();
        $myReportsCount = 0;
        $myReportsToday = 0;
        $allReports = collect();
        $totalReports = 0;
        $totalReportsToday = 0;
        $remarkedReports = 0;
        $pendingRemarks = 0;
        $topDgs = collect();
        $reportsPerDg = collect();

        // DG USERS
        if ($user->isDg()) {
            $myReports = Report::where('user_id', $user->id)
                ->with('remarks')
                ->latest()
                ->take(10)
                ->get();

            $myReportsCount = Report::where('user_id', $user->id)->count();
            $myReportsToday = Report::where('user_id', $user->id)
                ->whereDate('date', today())
                ->count();

            $remarkedReports = Report::where('user_id', $user->id)
                ->has('remarks')
                ->count();

            $pendingRemarks = Report::where('user_id', $user->id)
                ->doesntHave('remarks')
                ->count();

            // REMOVED dd() - this was preventing the view from rendering
        }
        // PS USERS
        elseif ($user->isPs()) {
            $allReports = Report::with('user', 'remarks')
                ->latest()
                ->take(20)
                ->get();

            $totalReports = Report::count();
            $totalReportsToday = Report::whereDate('date', today())->count();
            $remarkedReports = Report::has('remarks')->count();
            $pendingRemarks = Report::doesntHave('remarks')->count();

            // Get top DGs for PS view
            $topDgs = User::where('role', 'dg')
                ->withCount('reports')
                ->orderBy('reports_count', 'desc')
                ->take(5)
                ->get();

            // REMOVED dd()
        }
        // ADMIN USERS
        elseif ($user->isAdmin()) {
            $allReports = Report::with('user', 'remarks')
                ->latest()
                ->take(20)
                ->get();

            $totalReports = Report::count();
            $totalReportsToday = Report::whereDate('date', today())->count();
            $remarkedReports = Report::has('remarks')->count();
            $pendingRemarks = Report::doesntHave('remarks')->count();

            $reportsPerDg = User::where('role', 'dg')
                ->withCount('reports')
                ->orderBy('reports_count', 'desc')
                ->get();

            // REMOVED dd()
        }

        // Debug log instead of dd()
        \Log::debug('Dashboard data', [
            'user_id' => $user->id,
            'role' => $user->role,
            'totalReports' => $totalReports,
            'myReportsCount' => $myReportsCount,
            'remarkedReports' => $remarkedReports,
            'pendingRemarks' => $pendingRemarks,
        ]);

        return view('dashboard', compact(
            'dateFormat',
            'myReports',
            'myReportsCount',
            'myReportsToday',
            'allReports',
            'totalReports',
            'totalReportsToday',
            'remarkedReports',
            'pendingRemarks',
            'topDgs',
            'reportsPerDg'
        ));
    }
}