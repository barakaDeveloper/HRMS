<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Wrap in a transaction to ensure consistency
        DB::transaction(function () {
            // Use the configured user model instead of hardcoding App\Models\User
            $userModel = config('auth.providers.users.model');

            // Create Roles (idempotent)
            $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
            $hrManager = Role::firstOrCreate(['name' => 'HR Manager']);
            $manager = Role::firstOrCreate(['name' => 'Manager']);
            $employee = Role::firstOrCreate(['name' => 'Employee']);

            // Create or update users (idempotent)
            $admin = $userModel::updateOrCreate(
                ['email' => 'admin@hrms.com'],
                [
                    'name' => 'System Admin', 
                    'password' => Hash::make('password'),
                    'email_verified_at' => now()
                ]
            );
            $admin->assignRole($superAdmin);

            $hr = $userModel::updateOrCreate(
                ['email' => 'hr@hrms.com'],
                [
                    'name' => 'HR Manager', 
                    'password' => Hash::make('password'),
                    'email_verified_at' => now()
                ]
            );
            $hr->assignRole($hrManager);

            $managerUser = $userModel::updateOrCreate(
                ['email' => 'manager@hrms.com'],
                [
                    'name' => 'Department Manager', 
                    'password' => Hash::make('password'),
                    'email_verified_at' => now()
                ]
            );
            $managerUser->assignRole($manager);

            $employeeUser = $userModel::updateOrCreate(
                ['email' => 'employee@hrms.com'],
                [
                    'name' => 'John Employee', 
                    'password' => Hash::make('password'),
                    'email_verified_at' => now()
                ]
            );
            $employeeUser->assignRole($employee);
        });

        $this->command->info('Default roles and users created successfully!');
        $this->command->info('Super Admin: admin@hrms.com / password');
        $this->command->info('HR Manager: hr@hrms.com / password');
        $this->command->info('Manager: manager@hrms.com / password');
        $this->command->info('Employee: employee@hrms.com / password');
    }
}