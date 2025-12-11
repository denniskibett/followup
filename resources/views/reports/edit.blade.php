@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6">
    <!-- Breadcrumb Start -->
    <div class="flex flex-wrap items-center justify-between gap-3 pb-6">
        <div>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-white/90">Edit Report</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Update report #{{ str_pad($report->id, 6, '0', STR_PAD_LEFT) }}
            </p>
        </div>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li>
                    <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300" href="{{ route('reports.index') }}">
                        Reports
                        <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </li>
                <li>
                    <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300" href="{{ route('reports.show', $report->id) }}">
                        #{{ str_pad($report->id, 6, '0', STR_PAD_LEFT) }}
                        <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </li>
                <li class="text-sm text-gray-800 dark:text-white/90">
                    Edit
                </li>
            </ol>
        </nav>
    </div>
    <!-- Breadcrumb End -->

    <div class="grid grid-cols-1 gap-5 xl:grid-cols-12">
        <!-- Left Column - Form -->
        <div class="xl:col-span-8 2xl:col-span-9">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <!-- Header -->
                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">
                                Edit Report Information
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Update your report details below
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-600 dark:bg-blue-900 dark:text-blue-400">
                                {{ $report->remarks->count() }} {{ Str::plural('remark', $report->remarks->count()) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form method="POST" action="{{ route('reports.update', $report->id) }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <!-- Report Name -->
                    <div class="mb-6">
                        <label for="name" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Report Name <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name', $report->name) }}"
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                placeholder="Enter report name"
                                required
                            >
                            <div class="mt-1 flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Suggested format: <span class="font-medium text-blue-600">{{ $defaultName }}</span></span>
                            </div>
                        </div>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date -->
                    <div class="mb-6">
                        <label for="date" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Date <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="date"
                                name="date"
                                id="date"
                                value="{{ old('date', $report->date->format('Y-m-d')) }}"
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                required
                            >
                            <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Original submission: {{ $report->date->format('M d, Y') }}
                        </p>
                        @error('date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Details Section -->
                    <div class="mb-6">
                        <div class="mb-4 flex items-center justify-between">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Activity Details <span class="text-red-500">*</span>
                            </label>
                            <span class="text-xs text-gray-500 dark:text-gray-400" id="detailCount">
                                {{ count(old('details', $report->details)) }} detail{{ count(old('details', $report->details)) > 1 ? 's' : '' }}
                            </span>
                        </div>
                        
                        <!-- Details Container -->
                        <div id="details-container" class="space-y-3">
                            @foreach(old('details', $report->details) as $i => $detail)
                            <div class="detail-item group">
                                <div class="flex items-start gap-3">
                                    <span class="mt-2 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-medium text-blue-600 dark:bg-blue-900 dark:text-blue-400">
                                        {{ $i + 1 }}
                                    </span>
                                    <div class="flex-1">
                                        <textarea
                                            name="details[]"
                                            rows="2"
                                            placeholder="Describe your activity detail..."
                                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                            required
                                        >{{ $detail }}</textarea>
                                    </div>
                                    @if($i > 0)
                                    <button type="button" onclick="removeDetail(this)" 
                                        class="mt-2 text-red-500 hover:text-red-700">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Add More Button -->
                        <button type="button" onclick="addDetail()" 
                            class="mt-4 inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-900">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Add Another Detail
                        </button>

                        @error('details')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        @error('details.*')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-between border-t border-gray-200 pt-6 dark:border-gray-800">
                        <a href="{{ route('reports.show', $report->id) }}" 
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-900">
                            Cancel
                        </a>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="window.history.back()" 
                                class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-900">
                                Discard Changes
                            </button>
                            <button type="submit" 
                                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-medium text-white hover:bg-blue-700">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Update Report
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Column - Info -->
        <div class="xl:col-span-4 2xl:col-span-3">
            <!-- Report Status -->
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] mb-5">
                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">
                        Report Status
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Remarks Count -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total Remarks:</span>
                            <span class="text-sm font-medium text-gray-800 dark:text-white/90">
                                {{ $report->remarks->count() }}
                            </span>
                        </div>
                        
                        <!-- Latest Remark -->
                        @if($report->remarks->count() > 0)
                        <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-800">
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Latest Remark</p>
                            <p class="text-sm text-gray-700 dark:text-gray-300 truncate">
                                "{{ Str::limit($report->remarks->last()->remark, 80) }}"
                            </p>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                By {{ $report->remarks->last()->ps->name }}
                            </p>
                        </div>
                        @endif
                        
                        <!-- Created At -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Created:</span>
                            <span class="text-sm text-gray-800 dark:text-white/90">
                                {{ $report->created_at->format('M d, Y') }}
                            </span>
                        </div>
                        
                        <!-- Last Updated -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Last Updated:</span>
                            <span class="text-sm text-gray-800 dark:text-white/90">
                                {{ $report->updated_at->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Editing Guidelines -->
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">
                        Editing Guidelines
                    </h3>
                </div>
                <div class="p-6">
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2">
                            <div class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-900">
                                <svg class="h-3 w-3 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                Any changes will be visible to PS reviewers
                            </span>
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900">
                                <svg class="h-3 w-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                Keep details concise and accurate
                            </span>
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900">
                                <svg class="h-3 w-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                Add new details to clarify or update information
                            </span>
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900">
                                <svg class="h-3 w-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                Review existing remarks before editing
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let detailCounter = {{ count(old('details', $report->details)) }};

function updateDetailCount() {
    const count = document.querySelectorAll('.detail-item').length;
    document.getElementById('detailCount').textContent = `${count} detail${count > 1 ? 's' : ''}`;
}

function addDetail() {
    const container = document.getElementById('details-container');
    const newIndex = container.children.length + 1;
    
    const detailDiv = document.createElement('div');
    detailDiv.className = 'detail-item group';
    detailDiv.innerHTML = `
        <div class="flex items-start gap-3">
            <span class="mt-2 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-medium text-blue-600 dark:bg-blue-900 dark:text-blue-400">
                ${newIndex}
            </span>
            <div class="flex-1">
                <textarea
                    name="details[]"
                    rows="2"
                    placeholder="Describe your activity detail..."
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                    required
                ></textarea>
            </div>
            <button type="button" onclick="removeDetail(this)" 
                class="mt-2 text-red-500 hover:text-red-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    `;
    
    container.appendChild(detailDiv);
    updateDetailCount();
    
    // Auto-focus the new textarea
    const newTextarea = detailDiv.querySelector('textarea');
    newTextarea.focus();
    
    // Enable auto-expand
    enableAutoExpand(newTextarea);
}

function removeDetail(button) {
    const detailItem = button.closest('.detail-item');
    if (document.querySelectorAll('.detail-item').length > 1) {
        detailItem.remove();
        renumberDetails();
        updateDetailCount();
    } else {
        // Don't remove the last one, just clear it
        const textarea = detailItem.querySelector('textarea');
        textarea.value = '';
        textarea.focus();
    }
}

function renumberDetails() {
    const details = document.querySelectorAll('.detail-item');
    details.forEach((detail, index) => {
        const numberSpan = detail.querySelector('span[class*="bg-blue-100"]');
        if (numberSpan) {
            numberSpan.textContent = index + 1;
        }
    });
}

function enableAutoExpand(textarea) {
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
    // Trigger initial resize
    textarea.dispatchEvent(new Event('input'));
}

// Initialize auto-expand for existing textareas
document.addEventListener('DOMContentLoaded', function() {
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => enableAutoExpand(textarea));
    updateDetailCount();
});
</script>

<style>
/* Auto-expand textareas */
textarea {
    min-height: 80px;
    resize: none;
    transition: height 0.2s ease-out;
}

/* Smooth transitions */
.detail-item {
    transition: all 0.2s ease-in-out;
}

/* Focus styles */
input:focus, textarea:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Dark mode adjustments */
@media (prefers-color-scheme: dark) {
    input:focus, textarea:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }
}

/* Warning styling */
.bg-yellow-100 {
    background-color: #fef3c7;
}

.dark .bg-yellow-900 {
    background-color: #78350f;
}
</style>
@endsection