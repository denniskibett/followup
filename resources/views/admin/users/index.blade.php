@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
     <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-4 mt-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-xl bg-white p-4 shadow-theme-sm dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Users</p>
                    <p class="mt-1 text-2xl font-semibold text-gray-800 dark:text-white">{{ $users->total() }}</p>
                </div>
                <div class="rounded-full bg-blue-100 p-3 dark:bg-blue-900">
                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="rounded-xl bg-white p-4 shadow-theme-sm dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Admins</p>
                    <p class="mt-1 text-2xl font-semibold text-gray-800 dark:text-white">{{ $users->where('role', 'admin')->count() }}</p>
                </div>
                <div class="rounded-full bg-red-100 p-3 dark:bg-red-900">
                    <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="rounded-xl bg-white p-4 shadow-theme-sm dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Director Generals</p>
                    <p class="mt-1 text-2xl font-semibold text-gray-800 dark:text-white">{{ $users->where('role', 'dg')->count() }}</p>
                </div>
                <div class="rounded-full bg-yellow-100 p-3 dark:bg-yellow-900">
                    <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="rounded-xl bg-white p-4 shadow-theme-sm dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Permanent Secretaries</p>
                    <p class="mt-1 text-2xl font-semibold text-gray-800 dark:text-white">{{ $users->where('role', 'ps')->count() }}</p>
                </div>
                <div class="rounded-full bg-blue-100 p-3 dark:bg-blue-900">
                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>   

    <div class="container-fluid py-6">
        <div class="row">
            <div class="col-12">
                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6">
                    <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                Users Management
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Showing <span id="showingStart">1</span> to <span id="showingEnd">10</span> of <span id="totalCount">{{ $users->total() }}</span> entries
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
                                <form action="{{ route('admin.users.index') }}" method="GET" class="flex gap-2">
                                    <div class="relative flex-1">
                                        <input type="text" name="search" placeholder="Search users..." 
                                            value="{{ $search ?? '' }}"
                                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 pl-10">
                                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <button type="submit" class="rounded-lg bg-primary px-4 py-2.5 text-theme-sm font-medium text-white shadow-theme-xs hover:bg-primary-dark">
                                        Search
                                    </button>
                                    @if($search)
                                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center rounded-lg bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-500 shadow-theme-xs ring-1 ring-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">
                                        Clear
                                    </a>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="w-full overflow-x-auto">
                        <table class="min-w-full" id="usersTable">
                            <!-- Desktop table header -->
                            <thead class="hidden sm:table-header-group">
                                <tr class="border-gray-100 border-y dark:border-gray-800">
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortTable(0)">
                                        <div class="flex items-center justify-between">
                                            <span>User</span>
                                            <span class="sort-icon text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                                </svg>
                                            </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortTable(1)">
                                        <div class="flex items-center justify-between">
                                            <span>Email</span>
                                            <span class="sort-icon text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                                </svg>
                                            </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortTable(2)">
                                        <div class="flex items-center justify-between">
                                            <span>Role</span>
                                            <span class="sort-icon text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                                </svg>
                                            </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortTable(3)">
                                        <div class="flex items-center justify-between">
                                            <span>Phone</span>
                                            <span class="sort-icon text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                                </svg>
                                            </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortTable(4)">
                                        <div class="flex items-center justify-between">
                                            <span>Joined Date</span>
                                            <span class="sort-icon text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                                </svg>
                                            </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <div class="flex items-center justify-between">
                                            <span>Status</span>
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
                                        User
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800" id="usersTableBody">
                                @forelse($users as $userItem)
                                <tr class="user-row hover:bg-gray-50 transition duration-150">
                                    <!-- Desktop cells -->
                                    <td class="py-3 hidden sm:table-cell">
                                        <div class="flex items-center gap-3">
                                            @if($userItem->avatar)
                                                <img src="{{ asset('storage/' . $userItem->avatar) }}" 
                                                    alt="{{ $userItem->name }}" 
                                                    class="rounded-full h-10 w-10 object-cover">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                    <span class="text-blue-600 text-sm font-medium user-initial">
                                                        {{ substr($userItem->name, 0, 1) }}
                                                    </span>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90 user-name">
                                                    {{ $userItem->name }}
                                                    @if($userItem->id === auth()->id())
                                                        <span class="ml-2 inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-200">You</span>
                                                    @endif
                                                </p>
                                                <span class="text-gray-500 text-theme-xs dark:text-gray-400">
                                                    ID: {{ $userItem->id }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="py-3 hidden sm:table-cell">
                                        <div>
                                            <p class="text-gray-800 text-theme-sm dark:text-white/90 user-email">
                                                {{ $userItem->email }}
                                            </p>
                                        </div>
                                    </td>
                                    
                                    <td class="py-3 hidden sm:table-cell">
                                        @php
                                            $roleColors = [
                                                'admin' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                                'dg' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                                'ps' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium user-role {{ $roleColors[$userItem->role] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200' }}">
                                            {{ $userItem->roleName }}
                                        </span>
                                    </td>
                                    
                                    <td class="py-3 hidden sm:table-cell">
                                        <div class="text-gray-800 text-theme-sm dark:text-white/90 user-phone">
                                            {{ $userItem->phone ?? '-' }}
                                        </div>
                                    </td>
                                    
                                    <td class="py-3 hidden sm:table-cell">
                                        <div>
                                            <p class="text-gray-800 text-theme-sm dark:text-white/90 user-joined">
                                                {{ $userItem->created_at->format('M d, Y') }}
                                            </p>
                                            <span class="text-gray-500 text-theme-xs dark:text-gray-400">
                                                {{ $userItem->created_at->format('h:i A') }}
                                            </span>
                                        </div>
                                    </td>
                                    
                                    <td class="py-3">
                                        @if($userItem->email_verified_at)
                                            <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-200 user-status">
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 user-status">
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <td class="py-3 text-right">
                                        <div class="flex justify-end space-x-3">
                                            <!-- View -->
                                            <a href="{{ route('admin.users.show', $userItem->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="View">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                            </a>

                                            <!-- Edit -->
                                            <a href="#" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                                </svg>
                                            </a>

                                            <!-- Delete - Only if not current user -->
                                            @if($userItem->id !== auth()->id())
                                            <form action="#" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="Delete">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    <!-- Mobile cells (simplified view) -->
                                    <td class="py-3 sm:hidden">
                                        <div class="flex items-center gap-3">
                                            @if($userItem->avatar)
                                                <img src="{{ asset('storage/' . $userItem->avatar) }}" 
                                                    alt="{{ $userItem->name }}" 
                                                    class="rounded-full h-8 w-8 object-cover">
                                            @else
                                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                    <span class="text-blue-600 text-xs font-medium">
                                                        {{ substr($userItem->name, 0, 1) }}
                                                    </span>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                                    {{ Str::limit($userItem->name, 15) }}
                                                    @if($userItem->id === auth()->id())
                                                        <span class="ml-1 inline-flex items-center rounded-full bg-blue-100 px-1.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-200">You</span>
                                                    @endif
                                                </p>
                                                <span class="text-gray-500 text-theme-xs dark:text-gray-400">
                                                    {{ Str::limit($userItem->email, 20) }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="py-3 sm:hidden">
                                        @if($userItem->email_verified_at)
                                            <span class="inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-200">
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-yellow-100 px-2 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <td class="py-3 sm:hidden text-right">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('admin.users.show', $userItem->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="View">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                            </a>
                                            
                                            <a href="#" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-8 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No users found</h3>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            No users are currently registered in the system.
                                        </p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                    
                        <!-- Laravel Pagination -->
                        @if($users->hasPages())
                        <div class="flex flex-col items-center justify-between px-2 py-4 sm:flex-row sm:px-0">
                            <div class="hidden sm:flex">
                                <p class="text-sm text-gray-700 dark:text-gray-400">
                                    Showing <span>{{ $users->firstItem() }}</span> to <span>{{ $users->lastItem() }}</span> of <span>{{ $users->total() }}</span> results
                                </p>
                            </div>
                            <div class="flex-1 flex justify-between sm:justify-end">
                                @if($users->onFirstPage())
                                <button class="relative inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 opacity-50 cursor-not-allowed dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400" disabled>
                                    Previous
                                </button>
                                @else
                                <a href="{{ $users->previousPageUrl() }}" class="relative inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">
                                    Previous
                                </a>
                                @endif
                                
                                <div class="hidden sm:flex">
                                    @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                        @if($page == $users->currentPage())
                                        <span class="relative inline-flex items-center bg-blue-600 px-4 py-2 text-sm font-medium text-white">
                                            {{ $page }}
                                        </span>
                                        @else
                                        <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-700">
                                            {{ $page }}
                                        </a>
                                        @endif
                                    @endforeach
                                </div>
                                
                                @if($users->hasMorePages())
                                <a href="{{ $users->nextPageUrl() }}" class="relative ml-3 inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">
                                    Next
                                </a>
                                @else
                                <button class="relative ml-3 inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 opacity-50 cursor-not-allowed dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400" disabled>
                                    Next
                                </button>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
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
    let allUsers = Array.from(document.querySelectorAll('.user-row'));
    let filteredUsers = [...allUsers];
    
    // DOM elements
    const searchInput = document.querySelector('input[name="search"]');
    const entriesPerPageSelect = document.getElementById('entriesPerPage');
    const showingStart = document.getElementById('showingStart');
    const showingEnd = document.getElementById('showingEnd');
    const totalCount = document.getElementById('totalCount');
    
    // Initialize with the total count
    const initialTotalCount = parseInt(totalCount.textContent);
    totalCount.textContent = initialTotalCount;
    
    // Event listeners for client-side filtering (optional)
    if (searchInput) {
        // If you want to add client-side search without page reload
        searchInput.addEventListener('input', function() {
            // This is just for visual feedback, actual filtering is server-side
            // You can implement client-side filtering here if needed
        });
    }
    
    // Fix double arrow issue in select
    if (entriesPerPageSelect) {
        entriesPerPageSelect.classList.add('appearance-none');
        entriesPerPageSelect.style.backgroundImage = 'none';
    }
    
    // Sorting function for client-side sorting (optional)
    window.sortTable = function(columnIndex) {
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
        
        // Sort the users
        filteredUsers.sort((a, b) => {
            const cellA = a.querySelectorAll('td')[columnIndex];
            const cellB = b.querySelectorAll('td')[columnIndex];
            
            let valueA = '';
            let valueB = '';
            
            // Get sort values based on column
            if (columnIndex === 0) { // User name column
                const nameA = cellA?.querySelector('.user-name')?.textContent.toLowerCase() || '';
                const nameB = cellB?.querySelector('.user-name')?.textContent.toLowerCase() || '';
                valueA = nameA;
                valueB = nameB;
            } else if (columnIndex === 1) { // Email column
                valueA = cellA?.querySelector('.user-email')?.textContent.toLowerCase() || '';
                valueB = cellB?.querySelector('.user-email')?.textContent.toLowerCase() || '';
            } else if (columnIndex === 2) { // Role column
                valueA = cellA?.querySelector('.user-role')?.textContent.toLowerCase() || '';
                valueB = cellB?.querySelector('.user-role')?.textContent.toLowerCase() || '';
            } else if (columnIndex === 4) { // Date column
                const dateTextA = cellA?.querySelector('.user-joined')?.textContent || '';
                const dateTextB = cellB?.querySelector('.user-joined')?.textContent || '';
                valueA = new Date(dateTextA).getTime();
                valueB = new Date(dateTextB).getTime();
            } else {
                // For other columns
                valueA = cellA?.textContent.trim().toLowerCase() || '';
                valueB = cellB?.textContent.trim().toLowerCase() || '';
            }
            
            if (valueA < valueB) return -1 * sortDirection;
            if (valueA > valueB) return 1 * sortDirection;
            return 0;
        });
        
        // Update the table DOM
        const tbody = document.getElementById('usersTableBody');
        tbody.innerHTML = '';
        filteredUsers.forEach(user => tbody.appendChild(user));
    };
});

// Confirm delete function
function confirmDelete(event) {
    if (!confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        event.preventDefault();
        return false;
    }
    return true;
}
</script>
@endsection