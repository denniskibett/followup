@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6">
    <!-- Breadcrumb Start -->
    <div class="flex flex-wrap items-center justify-between gap-3 pb-6">
        <div>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-white/90">Create New Report</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Submit your weekly activity report
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
                <li class="text-sm text-gray-800 dark:text-white/90">
                    Create Report
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
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">
                        Report Information
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Please fill in all required fields below
                    </p>
                </div>

                <!-- Form Content -->
                <form method="POST" action="{{ route('reports.store') }}" class="p-6">
                    @csrf

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
                                value="{{ old('name', $defaultName) }}"
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                placeholder="Enter report name"
                                required
                                oninput="autoFormatName(this)"
                            >
                            <div class="mt-1 flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Format: {{ $defaultName }}<span class="font-medium text-blue-600">your activity name</span></span>
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
                                value="{{ old('date', now()->toDateString()) }}"
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                required
                            >
                            <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
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
                            <span class="text-xs text-gray-500 dark:text-gray-400" id="detailCount">1 detail</span>
                        </div>
                        
                        <!-- Details Container -->
                        <div id="details-container" class="space-y-3">
                            <div class="detail-item group">
                                <div class="flex items-start gap-3">
                                    <span class="mt-2 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-medium text-blue-600 dark:bg-blue-900 dark:text-blue-400">
                                        1
                                    </span>
                                    <div class="flex-1">
                                        <textarea
                                            name="details[]"
                                            rows="2"
                                            placeholder="Describe your activity detail..."
                                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                            required
                                        >{{ old('details.0') }}</textarea>
                                    </div>
                                    <button type="button" onclick="removeDetail(this)" 
                                        class="mt-2 hidden text-red-500 hover:text-red-700 group-hover:block">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
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
                        <a href="{{ route('reports.index') }}" 
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-900">
                            Cancel
                        </a>
                        <button type="submit" 
                            class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-medium text-white hover:bg-blue-700">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            Submit Report
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Column - Guidelines -->
        <div class="xl:col-span-4 2xl:col-span-3">
            <!-- Guidelines Card -->
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] mb-5">
                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">
                        Report Guidelines
                    </h3>
                </div>
                <div class="p-6">
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2">
                            <div class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-green-100 dark:bg-green-900">
                                <svg class="h-3 w-3 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                Use clear, concise language for each activity
                            </span>
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-green-100 dark:bg-green-900">
                                <svg class="h-3 w-3 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                Include specific achievements or outcomes
                            </span>
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-green-100 dark:bg-green-900">
                                <svg class="h-3 w-3 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                Add multiple details for comprehensive reporting
                            </span>
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-green-100 dark:bg-green-900">
                                <svg class="h-3 w-3 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                Report name format is automatically suggested
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Format Example Card -->
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">
                        Example Format
                    </h3>
                </div>
                <div class="p-6">
                    <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-800">
                        <p class="text-sm font-medium text-gray-800 dark:text-white/90 mb-2">
                            Report Name:
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <span class="text-gray-500">{{ $defaultName }}</span>
                            <span class="font-medium text-blue-600">Client Meeting & Documentation</span>
                        </p>
                        
                        <div class="mt-4">
                            <p class="text-sm font-medium text-gray-800 dark:text-white/90 mb-2">
                                Details:
                            </p>
                            <ul class="space-y-2">
                                <li class="flex items-start gap-2">
                                    <span class="mt-0.5 flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-medium text-blue-600 dark:bg-blue-900 dark:text-blue-400">
                                        1
                                    </span>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        Attended weekly client progress meeting
                                    </span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="mt-0.5 flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-medium text-blue-600 dark:bg-blue-900 dark:text-blue-400">
                                        2
                                    </span>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        Updated project documentation
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let detailCounter = 1;

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

function autoFormatName(input) {
    const value = input.value;
    const prefix = "{{ $defaultName }}";
    
    // If user starts typing without the prefix, don't auto-format
    // Only format if they haven't modified the prefix part
    if (!value.startsWith(prefix) && !value.includes(' - ')) {
        // Allow user to type freely
        return;
    }
}

function enableAutoExpand(textarea) {
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
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

/* Remove button styling */
.remove-btn {
    opacity: 0;
    transition: opacity 0.2s ease-in-out;
}

.detail-item:hover .remove-btn {
    opacity: 1;
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
</style>
@endsection