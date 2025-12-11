<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeeExport implements FromCollection, WithHeadings, WithMapping
{
    protected $employee;

    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    public function collection()
    {
        return collect([$this->employee]);
    }

    public function headings(): array
    {
        return [
            'Name',
            'Employee ID',
            'Email',
            'Phone',
            'Department',
            'Profession',
            'Employment Type',
            'Status',
            'Join Date',
            'Salary',
            'Productivity',
            'Address'
        ];
    }

    public function map($employee): array
    {
        return [
            $employee->name,
            $employee->employee_id,
            $employee->email,
            $employee->phone,
            $employee->department,
            $employee->profession,
            $employee->formatted_employment_type ?? $employee->employment_type,
            $employee->formatted_employee_status ?? $employee->employee_status,
            $employee->join_date ? $employee->join_date->format('Y-m-d') : 'N/A',
            $employee->salary_with_symbol ?? $employee->formatted_salary ?? 'N/A',
            ($employee->productivity ?? 0) . '%',
            $employee->address ?? 'N/A'
        ];
    }
}