<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Models\DepartmentProfession;
use App\Models\Department;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Add route model binding for DepartmentProfession
        Route::model('profession', DepartmentProfession::class);
        
        // Optional: Add explicit binding for Department if needed
        Route::model('department', Department::class);
    }
}