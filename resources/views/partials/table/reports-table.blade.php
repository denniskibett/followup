@php
    // Set default values if not provided
    $showUserColumn = $showUserColumn ?? true;
    $showCreateButton = $showCreateButton ?? true;
    $reports = $reports ?? [];
    $context = $context ?? 'reports-index';
@endphp

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6">
    <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                {{ $context === 'reports-index' ? 'Reports Overview' : 'Report History' }}
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Showing <span id="showingStart">1</span> to <span id="showingEnd">10</span> of <span id="totalCount">{{ count($reports) }}</span> entries
            </p>
        </div>
        
        <div class="flex flex-wrap items-center gap-3">
            <div class="flex items-center">
                <label for="entriesPerPage" class="text-sm text-gray-500 dark:text-gray-400 mr-2 hidden sm:inline">Show:</label>
                <div class="relative">
                    <select id="entriesPerPage" class="appearance-none rounded-lg border border-gray-300 bg-white px-3 py-2 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 pr-8">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <div class="absolute right-2 top-1/2 transform -translate-y-1/2 pointer-events-none text-gray-400 dark:text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="relative flex-1 min-w-[150px]">
                <input type="text" id="reportSearch" placeholder="Search reports..." class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 pl-10">
                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            @if($showCreateButton && auth()->user()->isDg())
                <a href="{{ route('reports.create') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-white px-5 py-2.5 text-theme-sm font-medium text-gray-500 shadow-theme-xs ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Create Report
                </a>
            @endif
        </div>
    </div>

    <div class="w-full overflow-x-auto">
        <table class="min-w-full" id="reportsTable">
            <!-- Desktop table header -->
            <thead class="hidden sm:table-header-group">
                <tr class="border-gray-100 border-y dark:border-gray-800">
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortTable(0)">
                        <div class="flex items-center justify-between">
                            <span>Date</span>
                            <span class="sort-icon text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </span>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortTable(1)">
                        <div class="flex items-center justify-between">
                            <span>Report Name</span>
                            <span class="sort-icon text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </span>
                        </div>
                    </th>
                    @if($showUserColumn && (auth()->user()->isPs() || auth()->user()->isAdmin()))
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortTable(2)">
                            <div class="flex items-center justify-between">
                                <span>Submitted By</span>
                                <span class="sort-icon text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                    </svg>
                                </span>
                            </div>
                        </th>
                    @endif
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortTable({{ $showUserColumn && (auth()->user()->isPs() || auth()->user()->isAdmin()) ? 3 : 2 }})">
                        <div class="flex items-center justify-between">
                            <span>Status</span>
                            <span class="sort-icon text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </span>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <div class="flex items-center justify-between">
                            <span>Remarks Count</span>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            
            <!-- Mobile table header -->
            <thead class="sm:hidden">
                <tr class="border-gray-100 border-y dark:border-gray-800">
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Report
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 dark:divide-gray-800" id="reportsTableBody">
                @forelse($reports as $report)
                <tr class="report-row hover:bg-gray-50 transition duration-150">
                    <!-- Desktop cells -->
                    <td class="py-3 hidden sm:table-cell">
                        <div>
                            <p class="text-gray-800 text-theme-sm dark:text-white/90 report-date">
                                {{ \Carbon\Carbon::parse($report->date)->format('M d, Y') }}
                            </p>
                            <span class="text-gray-500 text-theme-xs dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($report->date)->format('h:i A') }}
                            </span>
                        </div>
                    </td>
                    
                    <td class="py-3 hidden sm:table-cell">
                        <div>
                            <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90 report-name">
                                {{ $report->name }}
                            </p>
                            <span class="text-gray-500 text-theme-xs dark:text-gray-400">
                                {{ Str::limit($report->details[0] ?? 'No details', 50) }}
                            </span>
                        </div>
                    </td>
                    
                    @if($showUserColumn && (auth()->user()->isPs() || auth()->user()->isAdmin()))
                        <td class="py-3 hidden sm:table-cell">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-blue-600 text-xs font-medium">
                                        {{ ucfirst(substr($report->user->name ?? 'N/A', 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                        {{ $report->user->name ?? 'N/A' }}
                                    </p>
                                    <span class="text-gray-500 text-theme-xs dark:text-gray-400">
                                        {{ $report->user->email ?? '' }}
                                    </span>
                                </div>
                            </div>
                        </td>
                    @endif
                    
                    <td class="py-3">
                        <span class="rounded-full px-2 py-0.5 text-theme-xs font-medium report-status">
                            @if($report->remarks->count() > 0)
                                <span class="text-green-800 bg-green-100 dark:bg-green-900 dark:text-green-200 px-2 py-1 rounded-full">
                                    Remarked
                                </span>
                            @else
                                <span class="text-yellow-800 bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-200 px-2 py-1 rounded-full">
                                    Pending
                                </span>
                            @endif
                        </span>
                    </td>
                    
                    <td class="py-3 hidden sm:table-cell">
                        <div class="text-sm text-gray-500">
                            <span class="font-medium {{ $report->remarks->count() > 0 ? 'text-green-600' : 'text-gray-400' }}">
                                {{ $report->remarks->count() }} {{ Str::plural('remark', $report->remarks->count()) }}
                            </span>
                        </div>
                    </td>
                    
                    <td class="py-3 text-right">
                        <div class="flex justify-end space-x-3">
                            <!-- View -->
                            <a href="{{ route('reports.show', $report->id) }}" class="text-blue-600 hover:text-blue-900" title="View">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </a>

                            <!-- Edit - Only DG can edit their own reports -->
                            @if(auth()->user()->isDg() && $report->user_id === auth()->user()->id)
                                <a href="{{ route('reports.edit', $report->id) }}" class="text-green-600 hover:text-green-900" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                    </svg>
                                </a>
                            @endif

                            <!-- Remark - Only PS/Admin can add remarks -->
                            @if((auth()->user()->isPs() || auth()->user()->isAdmin()) && $report->user_id !== auth()->user()->id)
                                <a href="{{ route('reports.show', $report->id) }}#add-remark" class="text-purple-600 hover:text-purple-900" title="Add Remark">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </td>
                    
                    <!-- Mobile cells (simplified view) -->
                    <td class="py-3 sm:hidden">
                        <div class="flex items-center gap-3">
                            <div class="h-[40px] w-[40px] overflow-hidden rounded-md bg-blue-100 flex items-center justify-center">
                                <span class="text-blue-600 font-medium text-xs">
                                    {{ ucfirst(substr($report->name, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                    {{ Str::limit($report->name, 20) }}
                                </p>
                                <span class="text-gray-500 text-theme-xs dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($report->date)->format('M d') }}
                                </span>
                            </div>
                        </div>
                    </td>
                    
                    <td class="py-3 sm:hidden">
                        <span class="rounded-full px-2 py-0.5 text-theme-xs font-medium">
                            @if($report->remarks->count() > 0)
                                <span class="text-green-800 bg-green-100 dark:bg-green-900 dark:text-green-200">
                                    Remarked
                                </span>
                            @else
                                <span class="text-yellow-800 bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-200">
                                    Pending
                                </span>
                            @endif
                        </span>
                    </td>
                    
                    <td class="py-3 sm:hidden text-right">
                        <a href="{{ route('reports.show', $report->id) }}" class="text-blue-600 hover:text-blue-900 inline-block mr-2" title="View">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </a>
                        
                        @if(auth()->user()->isDg() && $report->user_id === auth()->user()->id)
                            <a href="{{ route('reports.edit', $report->id) }}" class="text-green-600 hover:text-green-900 inline-block mr-2" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                </svg>
                            </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ ($showUserColumn && (auth()->user()->isPs() || auth()->user()->isAdmin())) ? 6 : 5 }}" class="py-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No reports found</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            @if(auth()->user()->isDg())
                                Start by creating your first report
                            @else
                                No reports have been submitted yet
                            @endif
                        </p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Pagination -->
        <div class="flex flex-col items-center justify-between px-2 py-4 sm:flex-row sm:px-0">
            <div class="hidden sm:flex">
                <p class="text-sm text-gray-700 dark:text-gray-400">
                    Showing <span id="paginationStart">1</span> to <span id="paginationEnd">10</span> of <span id="paginationTotal">{{ count($reports) }}</span> results
                </p>
            </div>
            <div class="flex-1 flex justify-between sm:justify-end">
                <button id="prevPage" class="relative inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    Previous
                </button>
                <div id="paginationNumbers" class="hidden sm:flex">
                    <!-- Page numbers will be inserted here -->
                </div>
                <button id="nextPage" class="relative ml-3 inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed">
                    Next
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Table data and state
    let currentPage = 1;
    let entriesPerPage = parseInt(document.getElementById('entriesPerPage').value);
    let currentSortColumn = null;
    let sortDirection = 1; // 1 for ascending, -1 for descending
    let allReports = Array.from(document.querySelectorAll('.report-row'));
    let filteredReports = [...allReports];
    
    // DOM elements
    const searchInput = document.getElementById('reportSearch');
    const entriesPerPageSelect = document.getElementById('entriesPerPage');
    const showingStart = document.getElementById('showingStart');
    const showingEnd = document.getElementById('showingEnd');
    const totalCount = document.getElementById('totalCount');
    const prevPageBtn = document.getElementById('prevPage');
    const nextPageBtn = document.getElementById('nextPage');
    const paginationNumbers = document.getElementById('paginationNumbers');
    const paginationStart = document.getElementById('paginationStart');
    const paginationEnd = document.getElementById('paginationEnd');
    const paginationTotal = document.getElementById('paginationTotal');
    
    // Initialize with the total count
    const initialTotalCount = parseInt(document.getElementById('totalCount').textContent);
    totalCount.textContent = initialTotalCount;
    paginationTotal.textContent = initialTotalCount;
    
    // Initialize table
    updateTable();
    
    // Event listeners
    searchInput.addEventListener('input', function() {
        currentPage = 1;
        filterReports();
        updateTable();
    });
    
    entriesPerPageSelect.addEventListener('change', function() {
        entriesPerPage = parseInt(this.value);
        currentPage = 1;
        updateTable();
    });
    
    prevPageBtn.addEventListener('click', function() {
        if (currentPage > 1) {
            currentPage--;
            updateTable();
        }
    });
    
    nextPageBtn.addEventListener('click', function() {
        const totalPages = Math.ceil(filteredReports.length / entriesPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            updateTable();
        }
    });
    
    // Functions
    function filterReports() {
        const searchTerm = searchInput.value.toLowerCase();
        
        if (searchTerm === '') {
            filteredReports = [...allReports];
        } else {
            filteredReports = allReports.filter(row => {
                const reportName = row.querySelector('.report-name')?.textContent.toLowerCase() || '';
                const reportDate = row.querySelector('.report-date')?.textContent.toLowerCase() || '';
                const reportStatus = row.querySelector('.report-status')?.textContent.toLowerCase() || '';
                
                return reportName.includes(searchTerm) || 
                       reportDate.includes(searchTerm) || 
                       reportStatus.includes(searchTerm);
            });
        }
        
        // Update total count display
        totalCount.textContent = filteredReports.length;
        paginationTotal.textContent = filteredReports.length;
        
        // Apply sorting if any column is sorted
        if (currentSortColumn !== null) {
            sortTable(currentSortColumn, true);
        }
    }
    
    function updateTable() {
        const startIndex = (currentPage - 1) * entriesPerPage;
        const endIndex = startIndex + entriesPerPage;
        const paginatedReports = filteredReports.slice(startIndex, endIndex);
        
        // Hide all rows first
        allReports.forEach(row => row.style.display = 'none');
        
        // Show only paginated rows
        paginatedReports.forEach(row => row.style.display = '');
        
        // Update counters
        const total = filteredReports.length;
        const showing = paginatedReports.length;
        
        showingStart.textContent = startIndex + 1;
        showingEnd.textContent = Math.min(endIndex, total);
        
        paginationStart.textContent = startIndex + 1;
        paginationEnd.textContent = Math.min(endIndex, total);
        
        // Update pagination buttons
        prevPageBtn.disabled = currentPage === 1;
        nextPageBtn.disabled = currentPage === Math.ceil(total / entriesPerPage);
        
        // Update pagination numbers
        updatePaginationNumbers();
    }
    
    function updatePaginationNumbers() {
        const totalPages = Math.ceil(filteredReports.length / entriesPerPage);
        paginationNumbers.innerHTML = '';
        
        if (totalPages <= 1) return;
        
        // Always show first page
        addPageNumber(1);
        
        // Show ellipsis if needed
        if (currentPage > 3) {
            addEllipsis();
        }
        
        // Show current page and neighbors
        const startPage = Math.max(2, currentPage - 1);
        const endPage = Math.min(totalPages - 1, currentPage + 1);
        
        for (let i = startPage; i <= endPage; i++) {
            addPageNumber(i);
        }
        
        // Show ellipsis if needed
        if (currentPage < totalPages - 2) {
            addEllipsis();
        }
        
        // Always show last page if there's more than one page
        if (totalPages > 1) {
            addPageNumber(totalPages);
        }
    }
    
    function addPageNumber(page) {
        const pageBtn = document.createElement('button');
        pageBtn.className = `relative inline-flex items-center px-4 py-2 text-sm font-medium ${
            currentPage === page ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-700'
        }`;
        pageBtn.textContent = page;
        pageBtn.addEventListener('click', () => {
            currentPage = page;
            updateTable();
        });
        paginationNumbers.appendChild(pageBtn);
    }
    
    function addEllipsis() {
        const ellipsis = document.createElement('span');
        ellipsis.className = 'relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-400';
        ellipsis.textContent = '...';
        paginationNumbers.appendChild(ellipsis);
    }
    
    window.sortTable = function(columnIndex, preserveFilter = false) {
        // Update sort direction if clicking the same column
        if (currentSortColumn === columnIndex) {
            sortDirection *= -1;
        } else {
            currentSortColumn = columnIndex;
            sortDirection = 1;
        }
        
        // Update sort icons
        document.querySelectorAll('.sort-icon').forEach(icon => {
            icon.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                </svg>
            `;
        });
        
        const currentIcon = document.querySelectorAll('th')[columnIndex].querySelector('.sort-icon');
        if (currentIcon) {
            currentIcon.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M${sortDirection === 1 ? '19 9l-7 7-7-7' : '19 15l-7-7-7 7'}" />
                </svg>
            `;
        }
        
        // Sort the filtered reports
        filteredReports.sort((a, b) => {
            const cellA = a.querySelectorAll('td')[columnIndex];
            const cellB = b.querySelectorAll('td')[columnIndex];
            
            let valueA = '';
            let valueB = '';
            
            // Get sort values based on column
            if (columnIndex === 0) { // Date column
                const dateTextA = cellA?.querySelector('.report-date')?.textContent || '';
                const dateTextB = cellB?.querySelector('.report-date')?.textContent || '';
                valueA = new Date(dateTextA).getTime();
                valueB = new Date(dateTextB).getTime();
            } else if (columnIndex === 3) { // Status column
                const statusA = cellA?.querySelector('.report-status')?.textContent.toLowerCase() || '';
                const statusB = cellB?.querySelector('.report-status')?.textContent.toLowerCase() || '';
                valueA = statusA === 'remarked' ? 1 : 0;
                valueB = statusB === 'remarked' ? 1 : 0;
            } else {
                // For text columns
                valueA = cellA?.textContent.trim().toLowerCase() || '';
                valueB = cellB?.textContent.trim().toLowerCase() || '';
            }
            
            if (valueA < valueB) return -1 * sortDirection;
            if (valueA > valueB) return 1 * sortDirection;
            return 0;
        });
        
        // Update the table
        if (!preserveFilter) {
            currentPage = 1;
        }
        updateTable();
    };
});

// Fix double arrow issue in select
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('entriesPerPage');
    if (select) {
        select.classList.add('appearance-none');
        select.style.backgroundImage = 'none';
    }
});
</script>