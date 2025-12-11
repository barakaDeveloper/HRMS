<?php
// app/Http/Controllers/Auth/AuthenticatedSessionController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return response()->view('auth.login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        // Update last login
        $request->user()->update([
            'last_login_at' => now(),
        ]);

        // Redirect based on role
        return $this->redirectToDashboard($request->user());
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function redirectToDashboard($user)
    {
        if ($user->hasRole('Super Admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('HR Manager')) {
            return redirect()->route('hr.dashboard');
        }

        if ($user->hasRole('Manager')) {
            return redirect()->route('manager.dashboard');
        }

        return redirect()->route('employee.dashboard');
    }
}