@extends('layouts.app')

@section('title', 'Edit User - ' . $user->name)

@section('content')
<div class="container-fluid py-6">
    <div class="row">
        <div class="col-12">
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6">
                <!-- Header -->
                <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                            Edit User
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Update user information and permissions
                        </p>
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('admin.users.index') }}" 
                           class="inline-flex items-center rounded-lg bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-500 shadow-theme-xs ring-1 ring-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:ring-gray-700 dark:hover:bg-white/[0.03]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Cancel
                        </a>
                        
                        <button type="submit" form="editUserForm" 
                                class="inline-flex items-center rounded-lg bg-primary px-4 py-2.5 text-theme-sm font-medium text-white shadow-theme-xs hover:bg-primary-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Save Changes
                        </button>
                    </div>
                </div>

                <!-- Edit Form -->
                <form id="editUserForm" action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                        <!-- Left Column - Profile Picture -->
                        <div class="lg:col-span-1">
                            <div class="rounded-xl bg-white p-6 shadow-theme-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Profile Picture</h4>
                                
                                <div class="text-center">
                                    <!-- Current Avatar -->
                                    <div class="relative mx-auto mb-4" style="width: 150px; height: 150px;">
                                        @if($user->avatar)
                                            <img id="avatarPreview" src="{{ asset('storage/' . $user->avatar) }}" 
                                                 alt="{{ $user->name }}" 
                                                 class="h-full w-full rounded-full object-cover ring-4 ring-white dark:ring-gray-800 shadow-lg">
                                        @else
                                            <div id="avatarPreview" class="h-full w-full rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center ring-4 ring-white dark:ring-gray-800 shadow-lg">
                                                <span class="text-4xl font-bold text-white">
                                                    {{ substr($user->name, 0, 1) }}
                                                </span>
                                            </div>
                                        @endif
                                        
                                        <!-- Upload Overlay -->
                                        <label for="avatar" class="absolute inset-0 flex cursor-pointer items-center justify-center rounded-full bg-black/50 opacity-0 transition-opacity hover:opacity-100">
                                            <div class="text-center text-white">
                                                <svg class="mx-auto h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <span class="mt-1 text-xs">Change Photo</span>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <!-- File Input -->
                                    <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*" onchange="previewAvatar(event)">
                                    
                                    <!-- Actions -->
                                    <div class="mt-4 space-x-2">
                                        <label for="avatar" class="inline-flex cursor-pointer items-center rounded-lg bg-gray-100 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                                            <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                            </svg>
                                            Upload New
                                        </label>
                                        
                                        @if($user->avatar)
                                        <button type="button" onclick="removeAvatar()" class="inline-flex items-center rounded-lg bg-red-50 px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-100 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/30">
                                            <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Remove
                                        </button>
                                        @endif
                                    </div>
                                    
                                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                        JPG, PNG, or GIF. Max size 2MB.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Column - Form Fields -->
                        <div class="lg:col-span-2">
                            <div class="space-y-6">
                                <!-- Basic Information -->
                                <div class="rounded-xl bg-white p-6 shadow-theme-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Basic Information</h4>
                                    
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <!-- Name -->
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Full Name *
                                            </label>
                                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 @error('name') border-red-500 @enderror"
                                                   required>
                                            @error('name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <!-- Email -->
                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Email Address *
                                            </label>
                                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 @error('email') border-red-500 @enderror"
                                                   required>
                                            @error('email')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <!-- Role -->
                                        <div>
                                            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Role *
                                            </label>
                                            <select id="role" name="role"
                                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 @error('role') border-red-500 @enderror"
                                                    required>
                                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                                                <option value="dg" {{ old('role', $user->role) == 'dg' ? 'selected' : '' }}>Director General</option>
                                                <option value="ps" {{ old('role', $user->role) == 'ps' ? 'selected' : '' }}>Permanent Secretary</option>
                                            </select>
                                            @error('role')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <!-- Phone -->
                                        <div>
                                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Phone Number
                                            </label>
                                            <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 @error('phone') border-red-500 @enderror">
                                            @error('phone')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <!-- Bio -->
                                        <div class="sm:col-span-2">
                                            <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Bio
                                            </label>
                                            <textarea id="bio" name="bio" rows="3"
                                                      class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 @error('bio') border-red-500 @enderror">{{ old('bio', $user->bio) }}</textarea>
                                            @error('bio')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Address Information -->
                                <div class="rounded-xl bg-white p-6 shadow-theme-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Address Information</h4>
                                    
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <!-- Country -->
                                        <div>
                                            <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Country
                                            </label>
                                            <input type="text" id="country" name="country" value="{{ old('country', $user->country) }}"
                                                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                                        </div>
                                        
                                        <!-- City -->
                                        <div>
                                            <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                City
                                            </label>
                                            <input type="text" id="city" name="city" value="{{ old('city', $user->city) }}"
                                                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                                        </div>
                                        
                                        <!-- Postal Code -->
                                        <div>
                                            <label for="postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Postal Code
                                            </label>
                                            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}"
                                                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                                        </div>
                                        
                                        <!-- Tax ID -->
                                        <div>
                                            <label for="tax_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Tax ID
                                            </label>
                                            <input type="text" id="tax_id" name="tax_id" value="{{ old('tax_id', $user->tax_id) }}"
                                                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Social Links -->
                                <div class="rounded-xl bg-white p-6 shadow-theme-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Social Links</h4>
                                    
                                    <div class="space-y-4">
                                        @php
                                            $social = json_decode($user->social, true) ?? [];
                                        @endphp
                                        
                                        <!-- Facebook -->
                                        <div>
                                            <label for="social_facebook" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Facebook
                                            </label>
                                            <div class="flex">
                                                <span class="inline-flex items-center rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                                    facebook.com/
                                                </span>
                                                <input type="text" id="social_facebook" name="social[facebook]" 
                                                       value="{{ old('social.facebook', $social['facebook'] ?? '') }}"
                                                       class="w-full rounded-r-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                                                       placeholder="username">
                                            </div>
                                        </div>
                                        
                                        <!-- Twitter -->
                                        <div>
                                            <label for="social_twitter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Twitter
                                            </label>
                                            <div class="flex">
                                                <span class="inline-flex items-center rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                                    twitter.com/
                                                </span>
                                                <input type="text" id="social_twitter" name="social[twitter]" 
                                                       value="{{ old('social.twitter', $social['twitter'] ?? '') }}"
                                                       class="w-full rounded-r-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                                                       placeholder="username">
                                            </div>
                                        </div>
                                        
                                        <!-- LinkedIn -->
                                        <div>
                                            <label for="social_linkedin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                LinkedIn
                                            </label>
                                            <div class="flex">
                                                <span class="inline-flex items-center rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                                    linkedin.com/in/
                                                </span>
                                                <input type="text" id="social_linkedin" name="social[linkedin]" 
                                                       value="{{ old('social.linkedin', $social['linkedin'] ?? '') }}"
                                                       class="w-full rounded-r-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                                                       placeholder="username">
                                            </div>
                                        </div>
                                        
                                        <!-- Instagram -->
                                        <div>
                                            <label for="social_instagram" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Instagram
                                            </label>
                                            <div class="flex">
                                                <span class="inline-flex items-center rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                                    instagram.com/
                                                </span>
                                                <input type="text" id="social_instagram" name="social[instagram]" 
                                                       value="{{ old('social.instagram', $social['instagram'] ?? '') }}"
                                                       class="w-full rounded-r-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                                                       placeholder="username">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Status -->
                                <div class="rounded-xl bg-white p-6 shadow-theme-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Account Status</h4>
                                    
                                    <div class="space-y-3">
                                        <!-- Email Verification -->
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                    Email Verification
                                                </label>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    @if($user->email_verified_at)
                                                        Verified on {{ $user->email_verified_at->format('M d, Y') }}
                                                    @else
                                                        Email not verified
                                                    @endif
                                                </p>
                                            </div>
                                            @if(!$user->email_verified_at)
                                            <button type="button" onclick="resendVerification()" class="inline-flex items-center rounded-lg bg-blue-50 px-3 py-1.5 text-sm font-medium text-blue-600 hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/30">
                                                Resend Verification
                                            </button>
                                            @endif
                                        </div>
                                        
                                        <!-- Last Login -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Last Login
                                            </label>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never logged in' }}
                                            </p>
                                        </div>
                                        
                                        <!-- Account Created -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Account Created
                                            </label>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $user->created_at->format('F d, Y \a\t h:i A') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Avatar Preview
function previewAvatar(event) {
    const input = event.target;
    const preview = document.getElementById('avatarPreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="h-full w-full rounded-full object-cover ring-4 ring-white dark:ring-gray-800 shadow-lg">`;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Remove Avatar
function removeAvatar() {
    const preview = document.getElementById('avatarPreview');
    const initial = '{{ substr($user->name, 0, 1) }}';
    
    preview.innerHTML = `
        <div class="h-full w-full rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center ring-4 ring-white dark:ring-gray-800 shadow-lg">
            <span class="text-4xl font-bold text-white">${initial}</span>
        </div>
    `;
    
    // Add a hidden input to indicate avatar removal
    const form = document.getElementById('editUserForm');
    let removeInput = document.getElementById('remove_avatar');
    
    if (!removeInput) {
        removeInput = document.createElement('input');
        removeInput.type = 'hidden';
        removeInput.id = 'remove_avatar';
        removeInput.name = 'remove_avatar';
        removeInput.value = '1';
        form.appendChild(removeInput);
    }
}

// Resend Verification Email
function resendVerification() {
    if (confirm('Send verification email to {{ $user->email }}?')) {
        // Add AJAX call here
        alert('Verification email sent!');
    }
}

// Form submission
document.getElementById('editUserForm').addEventListener('submit', function(e) {
    const role = document.getElementById('role').value;
    const currentUserId = '{{ auth()->id() }}';
    const editingUserId = '{{ $user->id }}';
    
    // Prevent admin from changing their own role
    if (currentUserId === editingUserId && role !== 'admin') {
        e.preventDefault();
        alert('You cannot change your own role from Administrator.');
        document.getElementById('role').value = 'admin';
    }
});
</script>
@endsection