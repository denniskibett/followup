@extends('layouts.app')

@section('content')
<div class="p-6">
    <!-- Breadcrumb Start -->
    <div class="flex flex-wrap items-center justify-between gap-3 pb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
            Add Remark
        </h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li>
                    <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300" href="{{ route('reports.index') }}">
                        <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Reports
                    </a>
                </li>
                <li>
                    <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300" href="{{ route('reports.show', $report->id) }}">
                        <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Report #{{ $report->id }}
                    </a>
                </li>
                <li class="text-sm text-gray-800 dark:text-white/90">
                    Add Remark
                </li>
            </ol>
        </nav>
    </div>
    <!-- Breadcrumb End -->

    <div class="grid grid-cols-1 gap-5 xl:grid-cols-12">
        <!-- Left Column: Report Details -->
        <div class="xl:col-span-8 2xl:col-span-9">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <!-- Header -->
                <div class="flex flex-col justify-between gap-5 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center dark:border-gray-800">
                    <div>
                        <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">
                            Report: {{ $report->name }}
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Submitted: {{ $report->date->format('M d, Y') }} by {{ $report->user->name }}
                        </p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $report->remarks->count() }} {{ Str::plural('remark', $report->remarks->count()) }}
                            </span>
                            @if($report->remarks->count() > 0)
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded-full dark:bg-green-900 dark:text-green-200">
                                    {{ $report->remarks->where('status', 'approved')->count() }} Approved
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Report Content -->
                <div class="px-6 py-7">
                    <div class="mb-6 rounded-lg bg-gray-50 p-4 dark:bg-gray-800">
                        <h4 class="mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">Report Details</h4>
                        <div class="space-y-2">
                            @foreach($report->details as $index => $detail)
                            <div class="flex items-start gap-3">
                                <span class="mt-0.5 flex h-5 w-5 items-center justify-center rounded-full bg-blue-100 text-xs font-medium text-blue-600 dark:bg-blue-900 dark:text-blue-400">
                                    {{ $index + 1 }}
                                </span>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $detail }}
                                </p>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Existing Remarks -->
                    @if($report->remarks->count() > 0)
                    <div class="mb-6">
                        <h4 class="mb-4 text-sm font-medium text-gray-700 dark:text-gray-300">Previous Remarks</h4>
                        <div class="space-y-4">
                            @foreach($report->remarks->sortByDesc('created_at') as $remark)
                            <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-800">
                                <div class="mb-3 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center dark:bg-blue-900">
                                            <span class="text-xs font-medium text-blue-600 dark:text-blue-400">
                                                {{ ucfirst(substr($remark->ps->name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                                {{ $remark->ps->name }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $remark->created_at->format('M d, Y h:i A') }}
                                            </p>
                                        </div>
                                    </div>
                                    <span class="text-xs font-medium {{ $remark->status === 'approved' ? 'text-green-600' : ($remark->status === 'needs_revision' ? 'text-yellow-600' : 'text-blue-600') }}">
                                        {{ ucfirst(str_replace('_', ' ', $remark->status)) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $remark->remark }}
                                </p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Remark Form -->
                    <form action="{{ route('remarks.store', $report->id) }}" method="POST">
                        @csrf
                        
                        <div class="rounded-2xl border border-gray-200 shadow-xs dark:border-gray-800 dark:bg-gray-800">
                            <!-- Textarea -->
                            <div class="p-5">
                                <label for="remark" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Your Remark
                                </label>
                                <textarea
                                    id="remark"
                                    name="remark"
                                    rows="4"
                                    placeholder="Provide your feedback, suggestions, or approval comments..."
                                    class="w-full resize-none border-none bg-transparent p-0 font-normal text-gray-800 outline-none placeholder:text-gray-400 focus:ring-0 dark:text-white"
                                    required
                                ></textarea>
                            </div>

                            <!-- Bottom Section -->
                            <div class="flex flex-col gap-4 border-t border-gray-200 p-5 dark:border-gray-800 sm:flex-row sm:items-center sm:justify-between">
                                <!-- Status Selection -->
                                <div class="flex flex-wrap items-center gap-4">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Status:</span>
                                    <div class="flex items-center gap-4">
                                        @php
                                            $statuses = [
                                                'reviewed' => 'Reviewed',
                                                'approved' => 'Approved', 
                                                'needs_revision' => 'Needs Revision'
                                            ];
                                        @endphp
                                        
                                        @foreach($statuses as $value => $label)
                                        <label class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                            <div class="relative mr-2">
                                                <input
                                                    type="radio"
                                                    id="status_{{ $value }}"
                                                    name="status"
                                                    value="{{ $value }}"
                                                    {{ $loop->first ? 'checked' : '' }}
                                                    class="sr-only"
                                                />
                                                <div class="flex h-4 w-4 items-center justify-center rounded-full border-[1.25px] border-gray-300 bg-transparent hover:border-blue-500 dark:border-gray-700 dark:hover:border-blue-500 peer-checked:border-blue-500 peer-checked:bg-blue-500">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-white dark:bg-[#171f2e] peer-checked:bg-white"></span>
                                                </div>
                                            </div>
                                            {{ $label }}
                                        </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('reports.show', $report->id) }}" 
                                        class="inline-flex h-9 items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-900">
                                        Cancel
                                    </a>
                                    <button type="submit"
                                        class="inline-flex h-9 items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                                        Submit Remark
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column: Report Info -->
        <div class="xl:col-span-4 2xl:col-span-3">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">
                        Report Details
                    </h3>
                </div>
                <ul class="divide-y divide-gray-100 px-6 py-3 dark:divide-gray-800">
                    <li class="grid grid-cols-2 gap-5 py-2.5">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Submitted By</span>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-400">
                            {{ $report->user->name }}
                        </span>
                    </li>
                    <li class="grid grid-cols-2 gap-5 py-2.5">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Email</span>
                        <span class="text-sm break-words text-gray-700 dark:text-gray-400">
                            {{ $report->user->email }}
                        </span>
                    </li>
                    <li class="grid grid-cols-2 gap-5 py-2.5">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Report ID</span>
                        <span class="text-sm text-gray-700 dark:text-gray-400">
                            #{{ str_pad($report->id, 6, '0', STR_PAD_LEFT) }}
                        </span>
                    </li>
                    <li class="grid grid-cols-2 gap-5 py-2.5">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Date</span>
                        <span class="text-sm text-gray-700 dark:text-gray-400">
                            {{ $report->date->format('M d, Y') }}
                        </span>
                    </li>
                    <li class="grid grid-cols-2 gap-5 py-2.5">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Created</span>
                        <span class="text-sm text-gray-700 dark:text-gray-400">
                            {{ $report->created_at->format('M d, Y') }}
                        </span>
                    </li>
                    <li class="grid grid-cols-2 gap-5 py-2.5">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Status</span>
                        <div>
                            @if($report->remarks->count() > 0)
                                @php
                                    $latestRemark = $report->remarks->sortByDesc('created_at')->first();
                                    $statusColors = [
                                        'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                        'needs_revision' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                        'reviewed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'
                                    ];
                                @endphp
                                <span class="text-theme-xs inline-block rounded-full px-2 py-0.5 font-medium {{ $statusColors[$latestRemark->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                                    {{ ucfirst(str_replace('_', ' ', $latestRemark->status)) }}
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 text-theme-xs inline-block rounded-full px-2 py-0.5 font-medium">
                                    Pending Review
                                </span>
                            @endif
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Guidelines Card -->
            <div class="mt-5 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">
                        Remark Guidelines
                    </h3>
                </div>
                <div class="px-6 py-4">
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <li class="flex items-start gap-2">
                            <svg class="mt-0.5 h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Be specific and constructive
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="mt-0.5 h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Reference specific sections when possible
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="mt-0.5 h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Suggest improvements rather than just criticism
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="mt-0.5 h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Use appropriate status to reflect report condition
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-resize textarea
    const textarea = document.getElementById('remark');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }

    // Radio button styling
    const radios = document.querySelectorAll('input[type="radio"][name="status"]');
    radios.forEach(radio => {
        radio.addEventListener('change', function() {
            // Update visual styling
            document.querySelectorAll('input[type="radio"][name="status"]').forEach(r => {
                const parent = r.closest('label');
                const indicator = parent.querySelector('.flex.h-4.w-4');
                if (r.checked) {
                    indicator.classList.add('border-blue-500', 'bg-blue-500');
                    indicator.classList.remove('border-gray-300', 'dark:border-gray-700');
                } else {
                    indicator.classList.remove('border-blue-500', 'bg-blue-500');
                    indicator.classList.add('border-gray-300', 'dark:border-gray-700');
                }
            });
        });
    });
});
</script>

<style>
/* Custom scrollbar for remarks section */
.custom-scrollbar {
    scrollbar-width: thin;
    scrollbar-color: #d1d5db transparent;
}

.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: #d1d5db;
    border-radius: 20px;
}

.dark .custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: #4b5563;
}
</style>
@endsection