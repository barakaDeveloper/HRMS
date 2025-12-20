<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\DepartmentProfession;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Sales',
                'code' => 'SAL',
                'description' => 'Handles sales and customer acquisition',
                'team_function' => 'Revenue Generation',
                'employee_count' => 12,
                'color_scheme' => 'from-blue-500 to-purple-600',
                'initial' => 'SA',
                'is_active' => true,
                'professions' => ['Sales Manager', 'Sales Executive', 'Sales Coordinator']
            ],
            [
                'name' => 'Reservations',
                'code' => 'RSV',
                'description' => 'Manages booking and reservation systems',
                'team_function' => 'Booking Management',
                'employee_count' => 8,
                'color_scheme' => 'from-green-500 to-teal-600',
                'initial' => 'RS',
                'is_active' => true,
                'professions' => ['Reservation Manager', 'Reservation Executive', 'Booking Agent']
            ],
            [
                'name' => 'Logistics',
                'code' => 'LOG',
                'description' => 'Oversees transportation and supply chain',
                'team_function' => 'Supply Chain Operations',
                'employee_count' => 15,
                'color_scheme' => 'from-orange-500 to-red-600',
                'initial' => 'LO',
                'is_active' => true,
                'professions' => ['Logistics Officer', 'Logistics Executive', 'Warehouse Manager']
            ],
            [
                'name' => 'Marketing',
                'code' => 'MKT',
                'description' => 'Handles marketing campaigns and brand promotion',
                'team_function' => 'Brand & Marketing',
                'employee_count' => 10,
                'color_scheme' => 'from-purple-500 to-pink-600',
                'initial' => 'MK',
                'is_active' => true,
                'professions' => ['Marketing Officer', 'Digital Marketer', 'Content Creator', 'Brand Strategist']
            ],
            [
                'name' => 'Finance & Accounting',
                'code' => 'FIN',
                'description' => 'Manages financial operations and accounting',
                'team_function' => 'Financial Management',
                'employee_count' => 6,
                'color_scheme' => 'from-emerald-500 to-cyan-600',
                'initial' => 'FI',
                'is_active' => true,
                'professions' => ['Finance Manager', 'Accountant', 'Cashier', 'Auditor']
            ],
            [
                'name' => 'Media',
                'code' => 'MED',
                'description' => 'Creates and manages media content',
                'team_function' => 'Content Creation',
                'employee_count' => 7,
                'color_scheme' => 'from-yellow-500 to-cyan-600',
                'initial' => 'ME',
                'is_active' => true,
                'professions' => ['Photographer', 'Videographer', 'Social Media Manager', 'Graphic Designer']
            ]
        ];

        foreach ($departments as $deptData) {
            $professions = $deptData['professions'];
            unset($deptData['professions']);

            $department = Department::create($deptData);

            foreach ($professions as $profession) {
                DepartmentProfession::create([
                    'department_id' => $department->id,
                    'name' => $profession,
                    'description' => ucfirst($profession) . ' role in ' . $department->name
                ]);
            }
        }
    }
}
