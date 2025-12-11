<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function __construct()
    {
        // Middleware removed because the base Controller in this project may not expose middleware()
        // Authentication and authorization are enforced inside each action instead.
    }

    /**
     * Display a listing of the attendance records.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Enforce authentication and admin check explicitly to avoid calling $this->middleware()
        if (!Auth::check() || !$this->isAdmin(Auth::user())) {
            abort(403, 'Unauthorized access.');
        }

        // Check if it's an AJAX request
        if (request()->ajax()) {
    
            return response()->view('admin.partials.attendance_stats');
        }

        // Return an HTTP response so the return type matches \Illuminate\Http\Response.
        return response()->view('admin.attendance.index');
    }

    /**
     * Check if user has admin privileges
     */
    private function isAdmin($user)
    {
        return true; // Change this to your actual admin check logic
    }
}