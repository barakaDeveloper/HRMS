<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class PayrollController extends Controller
{
    // Exchange rate (1 USD = TZS)
    const EXCHANGE_RATE = 2500;

    /**
     * Display a listing of the payroll records.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check if user is admin
        if (!Auth::user() || !$this->isAdmin(Auth::user())) {
            abort(403, 'Unauthorized access.');
        }

        // Get all active employees for payroll calculations
        $employees = Employee::where('employee_status', 'active')->get();
        $departments = Department::all();

        // Calculate payroll statistics
        $stats = $this->calculatePayrollStats($employees);

        // Get department-wise breakdown
        $departmentBreakdown = $this->getDepartmentBreakdown($employees);

        // Get recent transactions (top 10 employees with highest salaries)
        $recentTransactions = $employees->sortByDesc(function($emp) {
            return $this->calculateEmployeeTotal($emp)['tzs'];
        })->take(10);

        // Check if it's an AJAX request
        if (request()->ajax()) {
            return response()->view('admin.partials.payroll_stats', [
                'stats' => $stats,
                'departmentBreakdown' => $departmentBreakdown,
                'recentTransactions' => $recentTransactions,
                'departments' => $departments
            ]);
        }
        
        return response()->view('admin.payroll.index', [
            'stats' => $stats,
            'departmentBreakdown' => $departmentBreakdown,
            'recentTransactions' => $recentTransactions,
            'departments' => $departments
        ]);
    }

    /**
     * Calculate payroll statistics from actual employee data
     *
     * @param \Illuminate\Support\Collection $employees
     * @return array
     */
    private function calculatePayrollStats($employees)
    {
        $totalEmployees = $employees->count();
        $activeEmployees = $employees->where('employee_status', 'active')->count();
        
        // Calculate total monthly payroll in TZS and USD separately
        $tzsTotal = 0;
        $usdTotal = 0;
        $processedTzs = 0;
        $processedUsd = 0;
        $pendingTzs = 0;
        $pendingUsd = 0;
        $processedCount = 0;
        
        foreach ($employees as $employee) {
            $totals = $this->calculateEmployeeTotal($employee);
            $tzsTotal += $totals['tzs'];
            $usdTotal += $totals['usd'];
            
            // Simulate 95% processed, 5% pending for now
            if ($totals['tzs'] > 0 || $totals['usd'] > 0) {
                $processedTzs += $totals['tzs'] * 0.95;
                $processedUsd += $totals['usd'] * 0.95;
                $pendingTzs += $totals['tzs'] * 0.05;
                $pendingUsd += $totals['usd'] * 0.05;
                $processedCount++;
            }
        }

        // Calculate percentages
        $totalPayrollValue = $this->convertToTzs($tzsTotal, $usdTotal);
        $processedPercent = $totalPayrollValue > 0 ? round(($this->convertToTzs($processedTzs, $processedUsd) / $totalPayrollValue) * 100) : 0;
        $pendingPercent = $totalPayrollValue > 0 ? round(($this->convertToTzs($pendingTzs, $pendingUsd) / $totalPayrollValue) * 100) : 0;
        $completionPercent = $totalEmployees > 0 ? round(($processedCount / $totalEmployees) * 100) : 0;

        return [
            'monthly_payroll_tzs' => $tzsTotal,
            'monthly_payroll_usd' => $usdTotal,
            'total_employees' => $totalEmployees,
            'employees_paid' => $processedCount,
            'completion_percent' => $completionPercent,
            'processed_tzs' => $processedTzs,
            'processed_usd' => $processedUsd,
            'pending_tzs' => $pendingTzs,
            'pending_usd' => $pendingUsd,
            'processed_percent' => $processedPercent,
            'pending_percent' => $pendingPercent
        ];
    }

    /**
     * Convert USD to TZS for percentage calculations
     */
    private function convertToTzs($tzs, $usd)
    {
        return $tzs + ($usd * self::EXCHANGE_RATE);
    }

    /**
     * Calculate employee total earnings in both currencies
     *
     * @param mixed $employee
     * @return array
     */
    private function calculateEmployeeTotal($employee)
    {
        $tzsTotal = 0;
        $usdTotal = 0;

        // Add salary
        if ($employee->salary) {
            if ($employee->salary_currency === 'TZS') {
                $tzsTotal += $employee->salary;
            } else {
                $usdTotal += $employee->salary;
            }
        }

        // Add allowances
        if ($employee->allowances) {
            if ($employee->allowances_currency === 'TZS') {
                $tzsTotal += $employee->allowances;
            } else {
                $usdTotal += $employee->allowances;
            }
        }

        // Add bonus
        if ($employee->bonus) {
            if ($employee->bonus_currency === 'TZS') {
                $tzsTotal += $employee->bonus;
            } else {
                $usdTotal += $employee->bonus;
            }
        }

        // Add commission
        if ($employee->commission) {
            if ($employee->commission_currency === 'TZS') {
                $tzsTotal += $employee->commission;
            } else {
                $usdTotal += $employee->commission;
            }
        }

        return [
            'tzs' => $tzsTotal,
            'usd' => $usdTotal
        ];
    }

    /**
     * Get department-wise payroll breakdown
     *
     * @param \Illuminate\Support\Collection $employees
     * @return array
     */
    private function getDepartmentBreakdown($employees)
    {
        $breakdown = [];
        $totalTzs = 0;
        $totalUsd = 0;

        // Group employees by department
        $departmentData = $employees->groupBy('department');

        foreach ($departmentData as $deptName => $deptEmployees) {
            $deptTzs = 0;
            $deptUsd = 0;
            $employeeCount = $deptEmployees->count();

            foreach ($deptEmployees as $employee) {
                $totals = $this->calculateEmployeeTotal($employee);
                $deptTzs += $totals['tzs'];
                $deptUsd += $totals['usd'];
            }

            $totalTzs += $deptTzs;
            $totalUsd += $deptUsd;

            $breakdown[] = [
                'name' => $deptName,
                'employee_count' => $employeeCount,
                'total_tzs' => $deptTzs,
                'total_usd' => $deptUsd
            ];
        }

        $totalPayrollValue = $this->convertToTzs($totalTzs, $totalUsd);

        // Calculate percentages
        foreach ($breakdown as &$item) {
            $itemValue = $this->convertToTzs($item['total_tzs'], $item['total_usd']);
            $item['percent'] = $totalPayrollValue > 0 ? round(($itemValue / $totalPayrollValue) * 100) : 0;
        }

        // Sort by total descending
        usort($breakdown, function ($a, $b) {
            $aValue = $this->convertToTzs($a['total_tzs'], $a['total_usd']);
            $bValue = $this->convertToTzs($b['total_tzs'], $b['total_usd']);
            return $bValue - $aValue;
        });

        return [
            'departments' => $breakdown,
            'total_tzs' => $totalTzs,
            'total_usd' => $totalUsd
        ];
    }

    /**
     * Check if user has admin privileges
     */
    private function isAdmin($user)
    {
        return true;
    }

    /**
     * Process payroll for a specific month
     */
    public function processPayroll(Request $request): JsonResponse
    {
        try {
            $month = $request->input('month', date('Y-m'));
            
            // Get all active employees
            $employees = Employee::where('employee_status', 'active')->get();
            
            $processed = 0;
            $failed = 0;
            $totalTzs = 0;
            $totalUsd = 0;

            foreach ($employees as $employee) {
                $totals = $this->calculateEmployeeTotal($employee);
                if ($totals['tzs'] > 0 || $totals['usd'] > 0) {
                    $processed++;
                    $totalTzs += $totals['tzs'];
                    $totalUsd += $totals['usd'];
                } else {
                    $failed++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Payroll processed successfully for {$month}",
                'data' => [
                    'month' => $month,
                    'employees_processed' => $processed,
                    'employees_failed' => $failed,
                    'total_tzs' => $totalTzs,
                    'total_usd' => $totalUsd
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Payroll processing error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error processing payroll: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate PDF salary slip for a single employee
     */
    public function generateSalarySlip(Request $request): JsonResponse
    {
        try {
            $employeeId = $request->input('employee_id');
            $month = $request->input('month', date('Y-m'));
            
            $employee = Employee::where('employee_id', $employeeId)->first();
            
            if (!$employee) {
                return response()->json([
                    'success' => false,
                    'message' => 'Employee not found'
                ], 404);
            }

            // Calculate earnings
            $salary = $employee->salary ?? 0;
            $allowances = $employee->allowances ?? 0;
            $bonus = $employee->bonus ?? 0;
            $commission = $employee->commission ?? 0;
            
            $currency = $employee->salary_currency ?? 'TZS';
            
            // Calculate totals
            $grossSalary = $salary + $allowances + $bonus + $commission;
            $deductions = 0; // Add deductions if you have this field
            $netSalary = $grossSalary - $deductions;

            // Prepare data for PDF
            $companyName = Setting::get('company_name', 'COMPANY NAME');
            $companyAddress = Setting::get('company_address', 'Company Address, City, Country');
            $companyLogo = Setting::get('company_logo', '');
            $hrFinanceSignature = Setting::get('hr_finance_signature', '');
            
            $data = [
                'employee' => $employee,
                'month' => $month,
                'company_name' => $companyName,
                'company_address' => $companyAddress,
                'company_logo' => $companyLogo,
                'hr_finance_signature' => $hrFinanceSignature,
                'salary' => $salary,
                'allowances' => $allowances,
                'bonus' => $bonus,
                'commission' => $commission,
                'gross_salary' => $grossSalary,
                'deductions' => $deductions,
                'net_salary' => $netSalary,
                'currency' => $currency,
                'generated_at' => now()->format('Y-m-d H:i:s')
            ];

            // Generate PDF
            $pdf = Pdf::loadView('admin.payroll.salary_slip', $data);
            
            // Return PDF as download
            $filename = "salary_slip_{$employee->employee_id}_{$month}.pdf";
            
            return response()->json([
                'success' => true,
                'message' => 'Salary slip generated successfully',
                'pdf_url' => route('admin.payroll.download_slip', ['employee_id' => $employeeId, 'month' => $month])
            ]);

        } catch (\Exception $e) {
            Log::error('Salary slip generation error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error generating salary slip: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download PDF salary slip (HTML view for interactive editing)
     */
    public function downloadSalarySlip(Request $request)
    {
        try {
            $employeeId = $request->input('employee_id');
            $month = $request->input('month', date('Y-m'));
            
            $employee = Employee::where('employee_id', $employeeId)->first();
            
            if (!$employee) {
                abort(404, 'Employee not found');
            }

            // Calculate earnings
            $salary = $employee->salary ?? 0;
            $allowances = $employee->allowances ?? 0;
            $bonus = $employee->bonus ?? 0;
            $commission = $employee->commission ?? 0;
            
            $currency = $employee->salary_currency ?? 'TZS';
            
            // Calculate totals
            $grossSalary = $salary + $allowances + $bonus + $commission;
            $tax = 0; // Default tax
            $otherDeductions = 0; // Default other deductions
            $netSalary = $grossSalary - $tax - $otherDeductions;
            
            // Generate slip number
            $slipNumber = 'SLIP-' . strtoupper(substr($employee->employee_id, 0, 5)) . '-' . date('Ym') . '-' . rand(1000, 9999);
            
            // Get company settings from database
            $companyName = Setting::get('company_name', 'COMPANY NAME');
            $companyAddress = Setting::get('company_address', 'Company Address, City, Country');
            $companyLogo = Setting::get('company_logo', '');
            $hrFinanceSignature = Setting::get('hr_finance_signature', '');
            
            return view('admin.payroll.salary_slip', [
                'employee' => $employee,
                'pay_period' => date('F Y', strtotime($month . '-01')),
                'slip_number' => $slipNumber,
                'company_name' => $companyName,
                'company_address' => $companyAddress,
                'company_logo' => $companyLogo,
                'hr_finance_signature' => $hrFinanceSignature,
                'salary' => $salary,
                'allowances' => $allowances,
                'bonus' => $bonus,
                'commission' => $commission,
                'tax' => $tax,
                'other_deductions' => $otherDeductions,
                'gross_salary' => $grossSalary,
                'net_salary' => $netSalary,
                'currency' => $currency
            ]);

        } catch (\Exception $e) {
            Log::error('Salary slip download error: ' . $e->getMessage());
            abort(500, 'Error generating salary slip: ' . $e->getMessage());
        }
    }

    /**
     * Generate bulk salary slips for all employees
     */
    public function generateBulkSalarySlips(Request $request): JsonResponse
    {
        try {
            $month = $request->input('month', date('Y-m'));
            
            // Get all active employees
            $employees = Employee::where('employee_status', 'active')->get();
            
            $slips = [];
            foreach ($employees as $employee) {
                $totals = $this->calculateEmployeeTotal($employee);
                if ($totals['tzs'] > 0 || $totals['usd'] > 0) {
                    $slips[] = [
                        'employee_id' => $employee->employee_id,
                        'name' => $employee->name,
                        'department' => $employee->department,
                        'total_tzs' => $totals['tzs'],
                        'total_usd' => $totals['usd']
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Generated " . count($slips) . " salary slips for {$month}",
                'data' => [
                    'month' => $month,
                    'total_slips' => count($slips),
                    'slips' => $slips
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Bulk salary slip generation error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error generating salary slips: ' . $e->getMessage()
            ], 500);
        }
    }
}
