<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\HR\DashboardController as HRDashboardController;
use App\Http\Controllers\Manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Controllers\Admin\LeaveController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Role-based dashboard routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Admin Dashboard - Super Admin only
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->middleware('role:Super Admin')
        ->name('admin.dashboard');

    // HR Dashboard - HR Manager only
    Route::get('/hr/dashboard', [HRDashboardController::class, 'index'])
        ->middleware('role:HR Manager')
        ->name('hr.dashboard');

    // Manager Dashboard - Manager only
    Route::get('/manager/dashboard', [ManagerDashboardController::class, 'index'])
        ->middleware('role:Manager')
        ->name('manager.dashboard');

    // Employee Dashboard - Accessible by all authenticated users
    Route::get('/employee/dashboard', [EmployeeDashboardController::class, 'index'])
        ->name('employee.dashboard');

    // Main dashboard route - redirects based on user role
    Route::get('/dashboard', function () {
        $user = Auth::user();

        $userHasRole = function ($role) use ($user) {
            if (!$user) {
                return false;
            }

            if (is_callable([$user, 'hasRole'])) {
                return call_user_func([$user, 'hasRole'], $role);
            }

            if (is_callable([$user, 'roles'])) {
                try {
                    $rolesRelation = call_user_func([$user, 'roles']);
                    if ($rolesRelation instanceof \Illuminate\Database\Eloquent\Relations\Relation) {
                        $names = $rolesRelation->get()->pluck('name');
                    } else {
                        $names = collect($rolesRelation)->pluck('name');
                    }
                    return $names->contains($role);
                } catch (\Throwable $e) {
                    // ignore and fallback to attribute check
                }
            }

            return isset($user->role) && $user->role === $role;
        };
        
        if ($userHasRole('Super Admin')) {
            return redirect()->route('admin.dashboard');
        }
        
        if ($userHasRole('HR Manager')) {
            return redirect()->route('hr.dashboard');
        }
        
        if ($userHasRole('Manager')) {
            return redirect()->route('manager.dashboard');
        }
        
        // Default fallback for Employees and any other roles
        return redirect()->route('employee.dashboard');
    })->name('dashboard');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:Super Admin'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Employees routes
    Route::prefix('employees')->name('employees.')->group(function () {
        // Generate employee ID for a department - MUST come before /{employee} catch-all
        Route::get('/generate-id/{departmentName}', [EmployeeController::class, 'generateEmployeeId'])->name('generate-id');
        
        Route::get('/', [EmployeeController::class, 'index'])->name('index');
        Route::get('/create', [EmployeeController::class, 'create'])->name('create');
        Route::post('/', [EmployeeController::class, 'store'])->name('store');
        
        // Profile routes
        Route::get('/{employee}/profile', [EmployeeController::class, 'profile'])->name('profile');
        Route::put('/{employee}/profile', [EmployeeController::class, 'updateProfile'])->name('profile.update');
        
        // Document routes
        Route::post('/{employee}/upload-document', [EmployeeController::class, 'uploadDocument'])->name('upload-document');
        Route::post('/{employee}/remove-document', [EmployeeController::class, 'removeDocument'])->name('remove-document');
        Route::get('/{employee}/documents/{documentId}', [EmployeeController::class, 'viewDocument'])->name('documents.view');
        
        // KPI routes
        Route::post('/{employee}/add-kpi', [EmployeeController::class, 'addKpi'])->name('add-kpi');
        Route::post('/{employee}/remove-kpi', [EmployeeController::class, 'removeKpi'])->name('remove-kpi');
        
        // Status route
        Route::post('/{employee}/toggle-status', [EmployeeController::class, 'toggleStatus'])->name('toggle-status');
        
        // Export routes - MOVED INSIDE employees prefix
        Route::get('/{employee}/export/pdf', [EmployeeController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/{employee}/export/excel', [EmployeeController::class, 'exportExcel'])->name('export.excel');
        Route::get('/{employee}/generate-report', [EmployeeController::class, 'generateReport'])->name('generate-report');
        
        // Generic routes at the end
        Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])->name('edit');
        Route::get('/{employee}', [EmployeeController::class, 'show'])->name('show');
        Route::put('/{employee}', [EmployeeController::class, 'update'])->name('update');
        Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('destroy');
    });


    // Departments routes
 Route::prefix('departments')->name('departments.')->group(function () {
    Route::get('/', [DepartmentController::class, 'index'])->name('index');
    Route::get('/create', [DepartmentController::class, 'create'])->name('create');
    Route::post('/', [DepartmentController::class, 'store'])->name('store');
    Route::get('/{department}', [DepartmentController::class, 'show'])->name('show');
    Route::get('/{department}/edit', [DepartmentController::class, 'edit'])->name('edit');
    Route::put('/{department}', [DepartmentController::class, 'update'])->name('update');
    Route::delete('/{department}', [DepartmentController::class, 'destroy'])->name('destroy');
    
    // Profession management routes
    Route::post('/{department}/professions', [DepartmentController::class, 'addProfession'])->name('professions.add');
    Route::put('/{department}/professions/{profession}', [DepartmentController::class, 'updateProfession'])->name('professions.update');
    Route::delete('/{department}/professions/{profession}', [DepartmentController::class, 'removeProfession'])->name('professions.remove');
});



    
    // Attendance routes
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    
    // Payroll routes
    Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');

    // Leave routes
    Route::get('/leave', [LeaveController::class, 'index'])->name('leave.index');
});

// Global employees route for HR Manager and Manager roles
Route::middleware(['auth', 'role:Super Admin'])->group(function () {
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
});

// Profile routes (accessible by all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Include authentication routes (login, register, password reset, etc.)
require __DIR__.'/auth.php';