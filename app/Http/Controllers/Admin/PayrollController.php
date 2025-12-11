<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayrollController extends Controller
{
    /**
     * Display a listing of the payroll records.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check if user is admin
        if (!Auth::user() || !$this->isAdmin(Auth::user())) {
            abort(403, 'Unauthorized access.');
        }

        // Check if it's an AJAX request
        if (request()->ajax()) {
            return response()->view('admin.partials.payroll_stats');
        }
        
        return response()->view('admin.payroll.index');
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