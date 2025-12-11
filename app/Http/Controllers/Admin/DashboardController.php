<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Check if it's an AJAX request
        if (request()->ajax()) {
            // Return only the content for AJAX requests
            return view('admin.partials.stats', [
                'title' => 'Admin Dashboard',
                'user' => $user,
                'role' => 'Super Admin'
            ]);
        }
        
        // Return full layout for normal requests
        return view('admin.dashboard.index', [
            'title' => 'Admin Dashboard',
            'user' => $user,
            'role' => 'Super Admin'
        ]);
    }
}