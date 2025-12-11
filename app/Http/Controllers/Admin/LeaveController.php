<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends BaseController
{
    public function index()
    {
        // Check if user is admin
        if (!Auth::user() || !$this->isAdmin(Auth::user())) {
            abort(403, 'Unauthorized access.');
        }

        // Check if it's an AJAX request
        if (request()->ajax()) {
            return response()->view('admin.partials.leave_stats');
        }
        
        return response()->view('admin.leave.index');
    }

    /**
     * Check if user has admin privileges
     */
    private function isAdmin($user)
    {
        // Adjust this based on your user role system
        // For now, return true to test, then implement your actual logic
        return true;
        
        
        // If using Spatie Laravel Permission:
        // return $user->hasRole('Super Admin');

    }
}