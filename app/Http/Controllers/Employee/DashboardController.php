<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        return view('employee.dashboard', [
            'title' => 'My Dashboard',
            'user' => $user,
            'role' => 'Employee'
        ]);
    }
}