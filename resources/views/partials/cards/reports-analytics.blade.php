<div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4 mb-8">
    <!-- Total Reports Card -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between">
            <div>
                <span class="text-gray-500 text-theme-sm dark:text-gray-400">Total Reports</span>
                <h4 class="text-2xl font-semibold text-gray-800 dark:text-white/90 mt-2">{{ $analytics['totalReports'] }}</h4>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-gray-500 text-theme-sm dark:text-gray-400">
                @if(auth()->user()->isDg())
                    All your submitted reports
                @else
                    Total reports submitted
                @endif
            </span>
        </div>
    </div>

    <!-- Remarked Reports Card -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between">
            <div>
                <span class="text-gray-500 text-theme-sm dark:text-gray-400">Remarked</span>
                <h4 class="text-2xl font-semibold text-gray-800 dark:text-white/90 mt-2">{{ $analytics['remarkedReports'] }}</h4>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 dark:bg-green-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-gray-500 text-theme-sm dark:text-gray-400">
                @if(auth()->user()->isDg())
                    Reviewed by PS
                @else
                    Reports with remarks
                @endif
            </span>
        </div>
    </div>

    <!-- This Week Reports Card -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between">
            <div>
                <span class="text-gray-500 text-theme-sm dark:text-gray-400">This Week</span>
                <h4 class="text-2xl font-semibold text-gray-800 dark:text-white/90 mt-2">{{ $analytics['thisWeekReports'] }}</h4>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <span class="text-gray-500 text-theme-sm dark:text-gray-400">
                @if(auth()->user()->isDg())
                    Submitted this week
                @else
                    This week's submissions
                @endif
            </span>
        </div>
    </div>

    <!-- Pending Review / Unique DGs Card -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between">
            <div>
                @if(auth()->user()->isDg())
                    <span class="text-gray-500 text-theme-sm dark:text-gray-400">Pending Review</span>
                    <h4 class="text-2xl font-semibold text-gray-800 dark:text-white/90 mt-2">{{ $analytics['pendingReview'] }}</h4>
                @else
                    <span class="text-gray-500 text-theme-sm dark:text-gray-400">Active DGs</span>
                    <h4 class="text-2xl font-semibold text-gray-800 dark:text-white/90 mt-2">{{ $analytics['uniqueDgs'] }}</h4>
                @endif
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-orange-100 dark:bg-orange-900">
                @if(auth()->user()->isDg())
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                @endif
            </div>
        </div>
        <div class="mt-4">
            <span class="text-gray-500 text-theme-sm dark:text-gray-400">
                @if(auth()->user()->isDg())
                    Awaiting PS review
                @else
                    Unique DG contributors
                @endif
            </span>
        </div>
    </div>
</div>