@extends('layouts.app')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800 dark:text-white/90">Reports</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">
                @if(auth()->user()->isDg())
                    Manage and track your weekly reports
                @elseif(auth()->user()->isPs())
                    Review and remark on DG reports
                @else
                    Overview of all reports
                @endif
            </p>
        </div>
        
        @if(auth()->user()->isPs() || auth()->user()->isAdmin())
        <div class="flex items-center gap-3">
            <!-- Filter Button for PS/Admin -->
            <button id="filterToggle" class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filters
            </button>
            
            <!-- Export Button -->
            <button class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export
            </button>
        </div>
        @endif
    </div>

    <!-- Analytics Cards -->
    @include('partials.cards.reports-analytics')

    <!-- Filters Section (Visible for PS/Admin) -->
    @if(auth()->user()->isPs() || auth()->user()->isAdmin())
    <div id="filterSection" class="mb-6 hidden rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Filter Reports</h3>
        <form action="{{ route('reports.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- DG Filter -->
            <div>
                <label for="dg" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select DG</label>
                <select name="dg" id="dg" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                    <option value="">All DGs</option>
                    @foreach(\App\Models\User::where('role', 'dg')->get() as $dg)
                        <option value="{{ $dg->id }}" {{ request('dg') == $dg->id ? 'selected' : '' }}>
                            {{ $dg->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Date From -->
            <div>
                <label for="from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">From Date</label>
                <input type="date" name="from" id="from" 
                    value="{{ request('from') }}" 
                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
            </div>
            
            <!-- Date To -->
            <div>
                <label for="to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">To Date</label>
                <input type="date" name="to" id="to" 
                    value="{{ request('to') }}" 
                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
            </div>
            
            <!-- Status Filter -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                <select name="status" id="status" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                    <option value="">All Status</option>
                    <option value="remarked" {{ request('status') == 'remarked' ? 'selected' : '' }}>Remarked</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>
            
            <!-- Action Buttons -->
            <div class="md:col-span-4 flex items-center justify-end gap-3 mt-2">
                <a href="{{ route('reports.index') }}" 
                    class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                    Clear Filters
                </a>
                <button type="submit" 
                    class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Reports Table -->
    @include('partials.table.reports-table', [
        'reports' => $reports,
        'showUserColumn' => auth()->user()->isPs() || auth()->user()->isAdmin(),
        'showCreateButton' => auth()->user()->isDg(),
        'context' => 'reports-index'
    ])
</div>

@if(auth()->user()->isPs() || auth()->user()->isAdmin())
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterToggle = document.getElementById('filterToggle');
    const filterSection = document.getElementById('filterSection');
    
    if (filterToggle && filterSection) {
        filterToggle.addEventListener('click', function() {
            filterSection.classList.toggle('hidden');
            
            // Update button text/icon
            if (filterSection.classList.contains('hidden')) {
                filterToggle.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filters
                `;
            } else {
                filterToggle.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Close Filters
                `;
            }
        });
        
        // Show filters if any filter is active
        if (window.location.search.includes('dg=') || 
            window.location.search.includes('from=') || 
            window.location.search.includes('to=') || 
            window.location.search.includes('status=')) {
            filterSection.classList.remove('hidden');
            filterToggle.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Close Filters
            `;
        }
    }
});
</script>
@endif
@endsection