@extends('layouts.app')

@section('title', 'Create New User')

@section('content')
<div class="container-fluid py-6">
    <div class="row">
        <div class="col-12">
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6">
                <!-- Header -->
                <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                            Create New User
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Add a new user to the system
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
                        
                        <button type="submit" form="createUserForm" 
                                class="inline-flex items-center rounded-lg bg-primary px-4 py-2.5 text-theme-sm font-medium text-white shadow-theme-xs hover:bg-primary-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Create User
                        </button>
                    </div>
                </div>

                <!-- Create Form -->
                <form id="createUserForm" action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                        <!-- Left Column - Profile Picture -->
                        <div class="lg:col-span-1">
                            <div class="rounded-xl bg-white p-6 shadow-theme-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Profile Picture</h4>
                                
                                <div class="text-center">
                                    <!-- Avatar Preview -->
                                    <div class="relative mx-auto mb-4" style="width: 150px; height: 150px;">
                                        <div id="avatarPreview" class="h-full w-full rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center ring-4 ring-white dark:ring-gray-800 shadow-lg">
                                            <span class="text-4xl font-bold text-white">?</span>
                                        </div>
                                        
                                        <!-- Upload Overlay -->
                                        <label for="avatar" class="absolute inset-0 flex cursor-pointer items-center justify-center rounded-full bg-black/50 opacity-0 transition-opacity hover:opacity-100">
                                            <div class="text-center text-white">
                                                <svg class="mx-auto h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <span class="mt-1 text-xs">Upload Photo</span>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <!-- File Input -->
                                    <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*" onchange="previewAvatar(event)">
                                    
                                    <!-- Upload Button -->
                                    <div class="mt-4">
                                        <label for="avatar" class="inline-flex cursor-pointer items-center rounded-lg bg-gray-100 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                                            <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                            </svg>
                                            Upload Photo
                                        </label>
                                    </div>
                                    
                                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                        Optional. JPG, PNG, or GIF. Max size 2MB.
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
                                            <input type="text" id="name" name="name" value="{{ old('name') }}"
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
                                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 @error('email') border-red-500 @enderror"
                                                   required>
                                            @error('email')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <!-- Password -->
                                        <div>
                                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Password *
                                            </label>
                                            <input type="password" id="password" name="password"
                                                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 @error('password') border-red-500 @enderror"
                                                   required>
                                            @error('password')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <!-- Password Confirmation -->
                                        <div>
                                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Confirm Password *
                                            </label>
                                            <input type="password" id="password_confirmation" name="password_confirmation"
                                                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                                                   required>
                                        </div>
                                        
                                        <!-- Role -->
                                        <div>
                                            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Role *
                                            </label>
                                            <select id="role" name="role"
                                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 @error('role') border-red-500 @enderror"
                                                    required>
                                                <option value="">Select Role</option>
                                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                                                <option value="dg" {{ old('role') == 'dg' ? 'selected' : '' }}>Director General</option>
                                                <option value="ps" {{ old('role') == 'ps' ? 'selected' : '' }}>Permanent Secretary</option>
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
                                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
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
                                                      class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 @error('bio') border-red-500 @enderror">{{ old('bio') }}</textarea>
                                            @error('bio')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Additional Information -->
                                <div class="rounded-xl bg-white p-6 shadow-theme-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Additional Information</h4>
                                    
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <!-- Country -->
                                        <div>
                                            <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Country
                                            </label>
                                            <input type="text" id="country" name="country" value="{{ old('country') }}"
                                                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                                        </div>
                                        
                                        <!-- City -->
                                        <div>
                                            <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                City
                                            </label>
                                            <input type="text" id="city" name="city" value="{{ old('city') }}"
                                                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                                        </div>
                                        
                                        <!-- Postal Code -->
                                        <div>
                                            <label for="postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Postal Code
                                            </label>
                                            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}"
                                                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                                        </div>
                                        
                                        <!-- Tax ID -->
                                        <div>
                                            <label for="tax_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Tax ID
                                            </label>
                                            <input type="text" id="tax_id" name="tax_id" value="{{ old('tax_id') }}"
                                                   class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Email Settings -->
                                <div class="rounded-xl bg-white p-6 shadow-theme-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Email Settings</h4>
                                    
                                    <div class="space-y-3">
                                        <!-- Send Welcome Email -->
                                        <div class="flex items-center">
                                            <input type="checkbox" id="send_welcome_email" name="send_welcome_email" value="1" 
                                                   class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary/20 dark:border-gray-600 dark:bg-gray-700">
                                            <label for="send_welcome_email" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                                Send welcome email with login instructions
                                            </label>
                                        </div>
                                        
                                        <!-- Require Password Reset -->
                                        <div class="flex items-center">
                                            <input type="checkbox" id="require_password_reset" name="require_password_reset" value="1" 
                                                   class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary/20 dark:border-gray-600 dark:bg-gray-700">
                                            <label for="require_password_reset" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                                Require password reset on first login
                                            </label>
                                        </div>
                                        
                                        <!-- Email Verification -->
                                        <div class="flex items-center">
                                            <input type="checkbox" id="send_verification_email" name="send_verification_email" value="1" checked
                                                   class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary/20 dark:border-gray-600 dark:bg-gray-700">
                                            <label for="send_verification_email" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                                Send email verification link
                                            </label>
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

// Form validation
document.getElementById('createUserForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Passwords do not match!');
        document.getElementById('password_confirmation').focus();
    }
    
    if (password.length < 8) {
        e.preventDefault();
        alert('Password must be at least 8 characters long!');
        document.getElementById('password').focus();
    }
});
</script>
@endsection