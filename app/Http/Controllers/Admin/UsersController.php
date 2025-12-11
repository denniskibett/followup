<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UsersController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request): View
    {
        // Check if user is admin
        if (!$request->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $search = $request->input('search');
        
        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('role', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();
        
        return view('admin.users.index', compact('users', 'search'));
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): View
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing a user.
     */
    public function edit(User $user): View
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,dg,ps',
            'phone' => 'nullable|string|max:20',
            'status' => 'nullable|in:active,inactive',
        ]);
        
        $user->update($validated);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->back()
                ->with('error', 'You cannot delete your own account.');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}