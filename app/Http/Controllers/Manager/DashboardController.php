<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        return view('manager.dashboard', [
            'title' => 'Manager Dashboard',
            'user' => $user,
            'role' => 'Manager'
        ]);
    }
}