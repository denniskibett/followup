@extends('layouts.app')

@section('title', 'User Details - ' . $user->name)

@section('content')
<div class="container-fluid py-6">
    <div class="row">
        <div class="col-12">
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6">
                <!-- Header -->
                <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                            User Details
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            View and manage user information
                        </p>
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('admin.users.index') }}" 
                           class="inline-flex items-center rounded-lg bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-500 shadow-theme-xs ring-1 ring-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Users
                        </a>
                        
                        @if($user->id !== auth()->id())
                        <form action="#" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center rounded-lg bg-red-50 px-4 py-2.5 text-theme-sm font-medium text-red-600 shadow-theme-xs ring-1 ring-red-200 hover:bg-red-100 dark:bg-red-900/20 dark:text-red-400 dark:ring-red-800/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete User
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

                <!-- User Profile -->
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <!-- Left Column - Profile Info -->
                    <div class="lg:col-span-1">
                        <div class="rounded-xl bg-white p-6 shadow-theme-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                            <!-- Avatar -->
                            <div class="text-center mb-6">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" 
                                         alt="{{ $user->name }}" 
                                         class="mx-auto h-32 w-32 rounded-full object-cover ring-4 ring-white dark:ring-gray-800 shadow-lg">
                                @else
                                    <div class="mx-auto h-32 w-32 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center ring-4 ring-white dark:ring-gray-800 shadow-lg">
                                        <span class="text-5xl font-bold text-white">
                                            {{ substr($user->name, 0, 1) }}
                                        </span>
                                    </div>
                                @endif
                                
                                <h2 class="mt-4 text-xl font-semibold text-gray-800 dark:text-white">
                                    {{ $user->name }}
                                    @if($user->id === auth()->id())
                                        <span class="ml-2 inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            You
                                        </span>
                                    @endif
                                </h2>
                                
                                <!-- Role Badge -->
                                @php
                                    $roleColors = [
                                        'admin' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                        'dg' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                        'ps' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'
                                    ];
                                @endphp
                                <div class="mt-2">
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200' }}">
                                        {{ $user->roleName }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Contact Info -->
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <div class="rounded-lg bg-gray-50 p-2 dark:bg-gray-700/50">
                                        <svg class="h-5 w-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                                        <p class="font-medium text-gray-800 dark:text-white">{{ $user->email }}</p>
                                    </div>
                                </div>
                                
                                @if($user->phone)
                                <div class="flex items-center">
                                    <div class="rounded-lg bg-gray-50 p-2 dark:bg-gray-700/50">
                                        <svg class="h-5 w-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Phone</p>
                                        <p class="font-medium text-gray-800 dark:text-white">{{ $user->phone }}</p>
                                    </div>
                                </div>
                                @endif
                                
                                <div class="flex items-center">
                                    <div class="rounded-lg bg-gray-50 p-2 dark:bg-gray-700/50">
                                        <svg class="h-5 w-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Joined</p>
                                        <p class="font-medium text-gray-800 dark:text-white">
                                            {{ $user->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center">
                                    <div class="rounded-lg bg-gray-50 p-2 dark:bg-gray-700/50">
                                        <svg class="h-5 w-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                                        @if($user->email_verified_at)
                                            <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-200">
                                                Verified
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                Pending Verification
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Social Links -->
                            @if($user->social && count(array_filter($user->social)))
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Social Links</h4>
                                <div class="flex space-x-2">
                                    @foreach($user->getSocialLinksAttribute() as $platform => $link)
                                        @if($link)
                                        <a href="{{ $link }}" target="_blank" 
                                           class="inline-flex items-center justify-center rounded-lg bg-gray-100 p-2 text-gray-600 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600">
                                            @if($platform === 'facebook')
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                            </svg>
                                            @elseif($platform === 'twitter')
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.213c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                            </svg>
                                            @elseif($platform === 'linkedin')
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                            </svg>
                                            @elseif($platform === 'instagram')
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                            </svg>
                                            @endif
                                        </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Right Column - Details -->
                    <div class="lg:col-span-2">
                        <div class="space-y-6">
                            <!-- Personal Information Card -->
                            <div class="rounded-xl bg-white p-6 shadow-theme-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Personal Information</h4>
                                    <a href="#" class="inline-flex items-center rounded-lg bg-gray-50 px-3 py-1.5 text-sm font-medium text-gray-600 hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                        Edit
                                    </a>
                                </div>
                                
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="text-sm text-gray-500 dark:text-gray-400">Full Name</label>
                                        <p class="mt-1 font-medium text-gray-800 dark:text-white">{{ $user->name }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="text-sm text-gray-500 dark:text-gray-400">Email Address</label>
                                        <p class="mt-1 font-medium text-gray-800 dark:text-white">{{ $user->email }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="text-sm text-gray-500 dark:text-gray-400">Bio</label>
                                        <p class="mt-1 text-gray-800 dark:text-white">
                                            {{ $user->bio ?? 'No bio provided' }}
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <label class="text-sm text-gray-500 dark:text-gray-400">Phone Number</label>
                                        <p class="mt-1 font-medium text-gray-800 dark:text-white">
                                            {{ $user->phone ?? 'Not provided' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Address Information Card -->
                            <div class="rounded-xl bg-white p-6 shadow-theme-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Address Information</h4>
                                
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="text-sm text-gray-500 dark:text-gray-400">Country</label>
                                        <p class="mt-1 font-medium text-gray-800 dark:text-white">
                                            {{ $user->country ?? 'Not provided' }}
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <label class="text-sm text-gray-500 dark:text-gray-400">City</label>
                                        <p class="mt-1 font-medium text-gray-800 dark:text-white">
                                            {{ $user->city ?? 'Not provided' }}
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <label class="text-sm text-gray-500 dark:text-gray-400">Postal Code</label>
                                        <p class="mt-1 font-medium text-gray-800 dark:text-white">
                                            {{ $user->postal_code ?? 'Not provided' }}
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <label class="text-sm text-gray-500 dark:text-gray-400">Tax ID</label>
                                        <p class="mt-1 font-medium text-gray-800 dark:text-white">
                                            {{ $user->tax_id ?? 'Not provided' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Activity Stats -->
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <!-- Reports Card -->
                                <div class="rounded-xl bg-white p-6 shadow-theme-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Reports</h4>
                                        <span class="rounded-full bg-blue-100 px-2.5 py-0.5 text-sm font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            {{ $user->reports->count() }}
                                        </span>
                                    </div>
                                    @if($user->reports->count() > 0)
                                        <div class="space-y-3">
                                            @foreach($user->reports->take(3) as $report)
                                            <div class="rounded-lg bg-gray-50 p-3 dark:bg-gray-700/50">
                                                <div class="flex items-center justify-between">
                                                    <p class="font-medium text-gray-800 dark:text-white text-sm">
                                                        {{ Str::limit($report->name, 30) }}
                                                    </p>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ $report->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        @if($user->reports->count() > 3)
                                        <div class="mt-4 text-center">
                                            <a href="#" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                                View all {{ $user->reports->count() }} reports →
                                            </a>
                                        </div>
                                        @endif
                                    @else
                                        <div class="text-center py-4">
                                            <p class="text-gray-500 dark:text-gray-400">No reports submitted yet</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Remarks Card -->
                                <div class="rounded-xl bg-white p-6 shadow-theme-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Remarks</h4>
                                        <span class="rounded-full bg-green-100 px-2.5 py-0.5 text-sm font-medium text-green-800 dark:bg-green-900 dark:text-green-200">
                                            {{ $user->remarks->count() }}
                                        </span>
                                    </div>
                                    @if($user->remarks->count() > 0)
                                        <div class="space-y-3">
                                            @foreach($user->remarks->take(3) as $remark)
                                            <div class="rounded-lg bg-gray-50 p-3 dark:bg-gray-700/50">
                                                <div class="flex items-center justify-between">
                                                    <p class="font-medium text-gray-800 dark:text-white text-sm">
                                                        {{ Str::limit($remark->content, 30) }}
                                                    </p>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ $remark->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        @if($user->remarks->count() > 3)
                                        <div class="mt-4 text-center">
                                            <a href="#" class="text-sm text-green-600 hover:text-green-800 dark:text-green-400">
                                                View all {{ $user->remarks->count() }} remarks →
                                            </a>
                                        </div>
                                        @endif
                                    @else
                                        <div class="text-center py-4">
                                            <p class="text-gray-500 dark:text-gray-400">No remarks given yet</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection