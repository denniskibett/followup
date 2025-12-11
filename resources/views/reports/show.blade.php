@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6">
    <!-- Breadcrumb Start -->
    <div class="flex flex-wrap items-center justify-between gap-3 pb-6">
        <div>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-white/90">Report Review</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Reviewing report #{{ str_pad($report->id, 6, '0', STR_PAD_LEFT) }} from {{ $report->user->name }}
            </p>
        </div>
        <div class="flex items-center gap-3">
            <!-- Quick Actions in Header -->
            @if(auth()->user()->isDg() && $report->user_id === auth()->user()->id)
            <div class="flex items-center gap-2">
                <a href="{{ route('reports.edit', $report->id) }}" 
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-900">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Report
                </a>
                
                <button id="addMoreBtn" onclick="showAddMoreModal()"
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-900">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Details
                </button>
            </div>
            @endif
            
            <!-- Print Button -->
            <button onclick="window.print()" 
                class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-900">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print
            </button>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <div class="overflow-hidden">
        <div class="grid h-full grid-cols-1 gap-5 xl:grid-cols-12">
            <!-- Left Column - Main Content -->
            <div class="xl:col-span-8 2xl:col-span-9">
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <!-- Header -->
                    <div class="flex flex-col justify-between gap-5 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center dark:border-gray-800">
                        <div>
                            <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">
                                Report: {{ $report->name }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Submitted on {{ $report->date->format('M d, Y \a\t h:i A') }}
                            </p>
                        </div>
                        <div class="flex items-center gap-4">
                            <!-- Status Badge -->
                            @php
                                $latestRemark = $report->remarks->sortByDesc('created_at')->first();
                                $currentStatus = $latestRemark ? $latestRemark->status : 'pending_review';
                                $statusConfig = [
                                    'pending_review' => ['label' => 'Pending Review', 'class' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'],
                                    'reviewed' => ['label' => 'Reviewed', 'class' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'],
                                    'approved' => ['label' => 'Approved', 'class' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'],
                                    'needs_revision' => ['label' => 'Needs Revision', 'class' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'],
                                    'note' => ['label' => 'Note', 'class' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200'],
                                ];
                            @endphp
                            <span class="rounded-full px-3 py-1 text-xs font-medium {{ $statusConfig[$currentStatus]['class'] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                                {{ $statusConfig[$currentStatus]['label'] ?? 'Pending Review' }}
                            </span>
                        </div>
                    </div>

                    <!-- Report Content -->
                    <div class="relative px-6 py-7">
                        <!-- Original Report Submission -->
                        <div class="mb-8 rounded-lg border border-gray-200 bg-gray-50 p-5 dark:border-gray-800 dark:bg-gray-800">
                            <div class="mb-4 flex items-center gap-3">
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center dark:bg-blue-900">
                                    <span class="text-sm font-medium text-blue-600 dark:text-blue-400">
                                        {{ ucfirst(substr($report->user->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ $report->user->name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $report->user->email }}
                                    </p>
                                </div>
                                <div class="ml-auto">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $report->date->format('M d, Y \a\t h:i A') }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="space-y-3">
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Report Details:</h4>
                                @foreach($report->details as $index => $detail)
                                <div class="flex items-start gap-3">
                                    <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-medium text-blue-600 dark:bg-blue-900 dark:text-blue-400">
                                        {{ $index + 1 }}
                                    </span>
                                    <div class="flex-1">
                                        <div class="report-detail-content text-sm text-gray-600 dark:text-gray-400">
                                            {!! nl2br(e($detail)) !!}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Remarks Thread -->
                        @if($report->remarks->count() > 0)
                        <div class="custom-scrollbar mb-8 max-h-[400px] space-y-7 divide-y divide-gray-200 overflow-y-auto pr-2 dark:divide-gray-800">
                            @foreach($report->remarks as $remark)
                            <article id="remark-{{ $remark->id }}">
                                <div class="mb-4 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 shrink-0 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                            <span class="text-sm font-medium text-blue-600 dark:text-blue-400">
                                                {{ ucfirst(substr($remark->ps->name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                                {{ $remark->ps->name }}
                                                @if($remark->ps->role === 'admin')
                                                    <span class="ml-2 rounded bg-purple-100 px-1.5 py-0.5 text-xs font-medium text-purple-800 dark:bg-purple-900 dark:text-purple-200">Admin</span>
                                                @endif
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $remark->created_at->format('M d, Y \a\t h:i A') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="rounded-full px-2.5 py-1 text-xs font-medium {{ $statusConfig[$remark->status]['class'] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                                            {{ $statusConfig[$remark->status]['label'] ?? 'Reviewed' }}
                                        </span>
                                        
                                        @if((auth()->user()->isPs() && $remark->ps_id === auth()->user()->id) || auth()->user()->isAdmin() || (auth()->user()->isDg() && $report->user_id === auth()->user()->id))
                                        <div class="flex items-center gap-1">
                                            <!-- Edit Button -->
                                            <button type="button" onclick="editRemark('{{ $remark->id }}', {{ json_encode($remark->remark) }}, '{{ $remark->status }}')"
                                                class="text-blue-500 hover:text-blue-700">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </button>
                                            
                                            <!-- Delete Button -->
                                            <form action="{{ route('remarks.destroy', $remark->id) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="button" 
                                                    onclick="confirmDeleteRemark('{{ $remark->id }}', '{{ $remark->ps->name }}')"
                                                    class="text-red-500 hover:text-red-700">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="pl-13">
                                    <div class="rounded-lg bg-white p-4 dark:bg-gray-800">
                                        <div class="remark-content text-sm text-gray-600 dark:text-gray-400">
                                            {!! $remark->remark !!}
                                        </div>
                                    </div>
                                </div>
                            </article>
                            @endforeach
                        </div>
                        @else
                        <div class="mb-8 rounded-lg border border-dashed border-gray-300 bg-gray-50 p-8 text-center dark:border-gray-700 dark:bg-gray-800">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h4 class="mt-4 text-sm font-medium text-gray-900 dark:text-white">No remarks yet</h4>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Be the first to add feedback
                            </p>
                        </div>
                        @endif

                        <!-- Add Remark Form (Available for PS/Admin AND DG for their own reports) -->
                        @if(
                            (auth()->user()->isPs() && $report->user_id !== auth()->user()->id) || 
                            auth()->user()->isAdmin() || 
                            (auth()->user()->isDg() && $report->user_id === auth()->user()->id)
                        )
                        <div class="pt-6">
                            <div class="rounded-2xl border border-gray-200 shadow-xs dark:border-gray-800 dark:bg-gray-800">
                                <form action="{{ route('remarks.store', $report->id) }}" method="POST" id="remarkForm">
                                    @csrf
                                    
                                    <!-- Rich Text Editor -->
                                    <div class="p-5">
                                        <label for="richRemark" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            @if(auth()->user()->isDg())
                                                Add Your Note (Visible to PS/Admin)
                                            @else
                                                Add Your Feedback
                                            @endif
                                        </label>
                                        <div id="richEditorToolbar" class="mb-3 flex flex-wrap gap-1 border-b border-gray-200 pb-3 dark:border-gray-700">
                                            <button type="button" onclick="formatText('bold')" class="h-8 w-8 rounded hover:bg-gray-100 dark:hover:bg-gray-700" title="Bold">
                                                <svg class="mx-auto h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                </svg>
                                            </button>
                                            <button type="button" onclick="formatText('italic')" class="h-8 w-8 rounded hover:bg-gray-100 dark:hover:bg-gray-700" title="Italic">
                                                <svg class="mx-auto h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l-5-5m0 0l5-5m-5 5h18"/>
                                                </svg>
                                            </button>
                                            <button type="button" onclick="formatText('underline')" class="h-8 w-8 rounded hover:bg-gray-100 dark:hover:bg-gray-700" title="Underline">
                                                <svg class="mx-auto h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                                                </svg>
                                            </button>
                                            <div class="h-8 border-l border-gray-300 dark:border-gray-600"></div>
                                            <button type="button" onclick="insertList('ul')" class="h-8 w-8 rounded hover:bg-gray-100 dark:hover:bg-gray-700" title="Bullet List">
                                                <svg class="mx-auto h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                                </svg>
                                            </button>
                                            <button type="button" onclick="insertList('ol')" class="h-8 w-8 rounded hover:bg-gray-100 dark:hover:bg-gray-700" title="Numbered List">
                                                <svg class="mx-auto h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <div id="richEditor" 
                                            contenteditable="true"
                                            class="min-h-[120px] w-full resize-none border-none bg-transparent p-0 font-normal text-gray-800 outline-none placeholder:text-gray-400 focus:ring-0 dark:text-white"
                                            placeholder="Type your feedback here..."
                                            oninput="updateHiddenTextarea()"
                                        ></div>
                                        <textarea id="remark" name="remark" class="hidden" required></textarea>
                                    </div>

                                    <!-- Bottom Section -->
                                    <div class="flex flex-col gap-4 border-t border-gray-200 p-5 dark:border-gray-800 sm:flex-row sm:items-center sm:justify-between">
                                        <!-- Status Selection (Only for PS/Admin) -->
                                        @if(auth()->user()->isPs() || auth()->user()->isAdmin())
                                        <div class="flex flex-wrap items-center gap-4">
                                            <span class="text-sm text-gray-500 dark:text-gray-400">Status:</span>
                                            <div class="flex flex-wrap items-center gap-3">
                                                @php
                                                    $statuses = [
                                                        'reviewed' => ['label' => 'Reviewed'],
                                                        'approved' => ['label' => 'Approved'],
                                                        'needs_revision' => ['label' => 'Needs Revision'],
                                                    ];
                                                @endphp
                                                
                                                @foreach($statuses as $value => $data)
                                                <label class="flex cursor-pointer items-center gap-2 text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                                    <div class="relative">
                                                        <input
                                                            type="radio"
                                                            id="status_{{ $value }}"
                                                            name="status"
                                                            value="{{ $value }}"
                                                            {{ $value === 'reviewed' ? 'checked' : '' }}
                                                            class="peer sr-only"
                                                        />
                                                        <div class="flex h-4 w-4 items-center justify-center rounded-full border-[1.25px] border-gray-300 bg-transparent peer-checked:border-blue-500 peer-checked:bg-blue-500 dark:border-gray-700">
                                                            <span class="h-1.5 w-1.5 rounded-full bg-white peer-checked:bg-white dark:bg-[#171f2e]"></span>
                                                        </div>
                                                    </div>
                                                    {{ $data['label'] }}
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        @else
                                        <!-- DG sees their remarks as notes -->
                                        <input type="hidden" name="status" value="note">
                                        @endif

                                        <!-- Submit Button -->
                                        <button type="submit"
                                            class="inline-flex h-9 items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                                            @if(auth()->user()->isDg())
                                                Add Note
                                            @else
                                                Submit Feedback
                                            @endif
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column - Sidebar (Ticket Details + Statistics) -->
            <div class="xl:col-span-4 2xl:col-span-3">
                <!-- Ticket Details Card -->
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">
                            Ticket Details
                        </h3>
                    </div>
                    <ul class="divide-y divide-gray-100 px-6 py-3 dark:divide-gray-800">
                        <li class="grid grid-cols-2 gap-5 py-2.5">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Customer</span>
                            <span class="text-gray-700 dark:text-gray-400">{{ $report->user->name }}</span>
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
                            <span class="text-sm text-gray-500 dark:text-gray-400">Category</span>
                            <span class="text-sm text-gray-700 dark:text-gray-400">Weekly Report</span>
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
                                <span class="bg-blue-light-50 dark:bg-blue-light-500/15 dark:text-blue-light-500 text-theme-xs text-blue-light-500 inline-block rounded-full px-2 py-0.5 font-medium {{ $statusConfig[$currentStatus]['class'] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                                    {{ $statusConfig[$currentStatus]['label'] ?? 'Pending Review' }}
                                </span>
                            </div>
                        </li>
                        
                        <!-- Statistics inside the same card -->
                        <li class="pt-4 border-t border-gray-200 dark:border-gray-800">
                            <div class="mb-3">
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Statistics</h4>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="rounded-lg bg-gray-50 p-3 dark:bg-gray-800">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Total Remarks</p>
                                        <p class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                            {{ $report->remarks->count() }}
                                        </p>
                                    </div>
                                    <div class="rounded-lg bg-gray-50 p-3 dark:bg-gray-800">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Details</p>
                                        <p class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                            {{ count($report->details) }}
                                        </p>
                                    </div>
                                    <div class="rounded-lg bg-green-50 p-3 dark:bg-green-900/20">
                                        <p class="text-xs text-green-600 dark:text-green-400">Approved</p>
                                        <p class="text-lg font-semibold text-green-700 dark:text-green-300">
                                            {{ $report->remarks->where('status', 'approved')->count() }}
                                        </p>
                                    </div>
                                    <div class="rounded-lg bg-yellow-50 p-3 dark:bg-yellow-900/20">
                                        <p class="text-xs text-yellow-600 dark:text-yellow-400">Needs Revision</p>
                                        <p class="text-lg font-semibold text-yellow-700 dark:text-yellow-300">
                                            {{ $report->remarks->where('status', 'needs_revision')->count() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Remark Modal -->
<div id="editRemarkModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center p-4">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50 transition-opacity" onclick="closeEditRemarkModal()"></div>
        
        <!-- Modal Content -->
        <div class="relative w-full max-w-lg rounded-2xl bg-white p-6 dark:bg-gray-800">
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">Edit Remark</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Update your remark content
                </p>
            </div>
            
            <form id="editRemarkForm" method="POST">
                @csrf @method('PUT')
                
                <div class="mb-6">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Remark Content
                    </label>
                    <div id="editRichEditorToolbar" class="mb-3 flex flex-wrap gap-1 border-b border-gray-200 pb-3 dark:border-gray-700">
                        <button type="button" onclick="editFormatText('bold')" class="h-8 w-8 rounded hover:bg-gray-100 dark:hover:bg-gray-700" title="Bold">
                            <svg class="mx-auto h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </button>
                        <button type="button" onclick="editFormatText('italic')" class="h-8 w-8 rounded hover:bg-gray-100 dark:hover:bg-gray-700" title="Italic">
                            <svg class="mx-auto h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l-5-5m0 0l5-5m-5 5h18"/>
                            </svg>
                        </button>
                        <button type="button" onclick="editFormatText('underline')" class="h-8 w-8 rounded hover:bg-gray-100 dark:hover:bg-gray-700" title="Underline">
                            <svg class="mx-auto h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                            </svg>
                        </button>
                    </div>
                    <div id="editRichEditor" 
                        contenteditable="true"
                        class="min-h-[120px] w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                    ></div>
                    <textarea id="editRemarkContent" name="remark" class="hidden" required></textarea>
                </div>
                
                <!-- Status Selection for PS/Admin -->
                @if(auth()->user()->isPs() || auth()->user()->isAdmin())
                <div class="mb-6">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Status
                    </label>
                    <div class="flex flex-wrap gap-3">
                        @foreach(['reviewed', 'approved', 'needs_revision'] as $status)
                        <label class="flex cursor-pointer items-center gap-2 text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                            <div class="relative">
                                <input
                                    type="radio"
                                    id="edit_status_{{ $status }}"
                                    name="status"
                                    value="{{ $status }}"
                                    class="peer sr-only"
                                />
                                <div class="flex h-4 w-4 items-center justify-center rounded-full border-[1.25px] border-gray-300 bg-transparent peer-checked:border-blue-500 peer-checked:bg-blue-500 dark:border-gray-700">
                                    <span class="h-1.5 w-1.5 rounded-full bg-white peer-checked:bg-white dark:bg-[#171f2e]"></span>
                                </div>
                            </div>
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <div class="flex justify-end gap-3">
                    <button type="button" 
                        onclick="closeEditRemarkModal()"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-900">
                        Cancel
                    </button>
                    <button type="submit"
                        class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700">
                        Update Remark
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center p-4">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50 transition-opacity" onclick="closeDeleteModal()"></div>
        
        <!-- Modal Content -->
        <div class="relative w-full max-w-md rounded-2xl bg-white p-6 dark:bg-gray-800">
            <div class="mb-4 flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-900">
                    <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">Delete Remark</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Remark by <span id="remarkAuthor"></span></p>
                </div>
            </div>
            
            <p class="mb-6 text-sm text-gray-600 dark:text-gray-400">
                Are you sure you want to delete this remark? This action cannot be undone.
            </p>
            
            <div class="flex justify-end gap-3">
                <button type="button" 
                    onclick="closeDeleteModal()"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-900">
                    Cancel
                </button>
                <form id="deleteForm" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="rounded-lg bg-red-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-red-700">
                        Delete Remark
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add More Details Modal -->
<div id="addMoreModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center p-4">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50 transition-opacity" onclick="closeAddMoreModal()"></div>
        
        <!-- Modal Content -->
        <div class="relative w-full max-w-lg rounded-2xl bg-white p-6 dark:bg-gray-800">
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">Add More Details</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Add additional information to your report
                </p>
            </div>
            
            <form id="addMoreForm" action="{{ route('reports.update', $report->id) }}" method="POST">
                @csrf @method('PUT')
                
                <div id="additionalDetailsContainer">
                    <div class="mb-4">
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Additional Detail #1
                        </label>
                        <textarea
                            name="additional_details[]"
                            rows="3"
                            placeholder="Enter additional detail..."
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                        ></textarea>
                    </div>
                </div>
                
                <button type="button" onclick="addMoreField()"
                    class="mb-6 inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-900">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Another Field
                </button>
                
                <div class="flex justify-end gap-3">
                    <button type="button" 
                        onclick="closeAddMoreModal()"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-900">
                        Cancel
                    </button>
                    <button type="submit"
                        class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700">
                        Save Details
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let remarkToDelete = null;
let remarkToEdit = null;
let fieldCounter = 1;

// Rich Text Editor Functions
function formatText(command) {
    document.execCommand(command, false, null);
    updateHiddenTextarea();
}

function editFormatText(command) {
    document.execCommand(command, false, null);
    updateEditHiddenTextarea();
}

function insertList(type) {
    document.execCommand(type === 'ul' ? 'insertUnorderedList' : 'insertOrderedList', false, null);
    updateHiddenTextarea();
}

function updateHiddenTextarea() {
    const editor = document.getElementById('richEditor');
    const hiddenTextarea = document.getElementById('remark');
    hiddenTextarea.value = editor.innerHTML;
}

function updateEditHiddenTextarea() {
    const editor = document.getElementById('editRichEditor');
    const hiddenTextarea = document.getElementById('editRemarkContent');
    hiddenTextarea.value = editor.innerHTML;
}

// Remark Management Functions
function editRemark(remarkId, content, status) {
    remarkToEdit = remarkId;
    
    // Set up edit form
    const form = document.getElementById('editRemarkForm');
    form.action = `/remarks/${remarkId}`;
    
    // Set content in editor
    const editor = document.getElementById('editRichEditor');
    const hiddenTextarea = document.getElementById('editRemarkContent');
    
    // Directly set the HTML content
    editor.innerHTML = content;
    hiddenTextarea.value = content;
    
    // Clear all status radio buttons first
    document.querySelectorAll('input[name="status"]').forEach(radio => {
        radio.checked = false;
    });
    
    // Set the correct status if available
    const statusInput = document.querySelector(`input[name="status"][value="${status}"]`);
    if (statusInput) {
        statusInput.checked = true;
    }
    
    showModal('editRemarkModal');
}

function confirmDeleteRemark(remarkId, authorName) {
    remarkToDelete = remarkId;
    document.getElementById('remarkAuthor').textContent = authorName;
    const form = document.getElementById('deleteForm');
    form.action = `/remarks/${remarkId}`;
    showModal('deleteModal');
}

// Modal Functions
function showModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeEditRemarkModal() {
    document.getElementById('editRemarkModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
    remarkToEdit = null;
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
    remarkToDelete = null;
}

function showAddMoreModal() {
    fieldCounter = 1;
    showModal('addMoreModal');
}

function addMoreField() {
    fieldCounter++;
    const container = document.getElementById('additionalDetailsContainer');
    const fieldDiv = document.createElement('div');
    fieldDiv.className = 'mb-4';
    fieldDiv.innerHTML = `
        <div class="flex items-center justify-between mb-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Additional Detail #${fieldCounter}
            </label>
            <button type="button" onclick="removeField(this)" class="text-red-500 hover:text-red-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <textarea
            name="additional_details[]"
            rows="3"
            placeholder="Enter additional detail..."
            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
        ></textarea>
    `;
    container.appendChild(fieldDiv);
}

function removeField(button) {
    button.closest('.mb-4').remove();
    // Recalculate field numbers
    const fields = document.querySelectorAll('#additionalDetailsContainer .mb-4');
    fields.forEach((field, index) => {
        const label = field.querySelector('label');
        if (label) {
            label.textContent = `Additional Detail #${index + 1}`;
        }
    });
    fieldCounter = fields.length;
}

function closeAddMoreModal() {
    document.getElementById('addMoreModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

// Close modals with Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        if (!document.getElementById('deleteModal').classList.contains('hidden')) {
            closeDeleteModal();
        }
        if (!document.getElementById('editRemarkModal').classList.contains('hidden')) {
            closeEditRemarkModal();
        }
        if (!document.getElementById('addMoreModal').classList.contains('hidden')) {
            closeAddMoreModal();
        }
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Auto-expand textareas
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        textarea.dispatchEvent(new Event('input'));
    });

    // Initialize rich text editor
    updateHiddenTextarea();
    
    // Scroll to latest remark if URL has hash
    if (window.location.hash) {
        const element = document.querySelector(window.location.hash);
        if (element) {
            setTimeout(() => {
                element.scrollIntoView({ behavior: 'smooth' });
                element.classList.add('highlight-new');
            }, 100);
        }
    }
});

// AJAX form submission for adding more details
document.getElementById('addMoreForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = this;
    const formData = new FormData(form);
    
    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        });
        
        if (response.ok) {
            closeAddMoreModal();
            window.location.reload();
        } else {
            const result = await response.json();
            alert('Error adding details: ' + (result.message || 'Please try again'));
        }
    } catch (error) {
        alert('Network error. Please try again.');
    }
});
</script>

<style>
/* Custom scrollbar */
.custom-scrollbar {
    scrollbar-width: thin;
    scrollbar-color: #d1d5db transparent;
}

.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
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

/* Rich text content styling */
.report-detail-content,
.remark-content {
    line-height: 1.6;
}

.report-detail-content ul,
.remark-content ul {
    list-style-type: disc;
    margin-left: 1.5rem;
    margin-top: 0.5rem;
    margin-bottom: 0.5rem;
}

.report-detail-content ol,
.remark-content ol {
    list-style-type: decimal;
    margin-left: 1.5rem;
    margin-top: 0.5rem;
    margin-bottom: 0.5rem;
}

.report-detail-content li,
.remark-content li {
    margin-bottom: 0.25rem;
}

.report-detail-content strong,
.remark-content strong {
    font-weight: 600;
}

.report-detail-content em,
.remark-content em {
    font-style: italic;
}

.report-detail-content u,
.remark-content u {
    text-decoration: underline;
}

/* Rich editor */
#richEditor:empty:before,
#editRichEditor:empty:before {
    content: attr(placeholder);
    color: #9ca3af;
    pointer-events: none;
}

#richEditorToolbar button.active,
#editRichEditorToolbar button.active {
    background-color: #e5e7eb;
}

.dark #richEditorToolbar button.active,
.dark #editRichEditorToolbar button.active {
    background-color: #374151;
}

/* Highlight animation */
@keyframes highlight {
    0% { 
        background-color: rgba(59, 130, 246, 0.1); 
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
    }
    100% { 
        background-color: transparent; 
        box-shadow: none;
    }
}

.highlight-new {
    animation: highlight 2s ease-in-out;
}

/* Print styles */
@media print {
    .no-print {
        display: none !important;
    }
    
    .rounded-2xl {
        border-radius: 0 !important;
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }
    
    .dark\:bg-gray-800 {
        background-color: white !important;
    }
    
    .dark\:text-white\/90 {
        color: black !important;
    }
}
</style>
@endsection