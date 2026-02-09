<!-- Payroll Header -->
<div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold logo-text">Payroll Management</h1>
        <p class="text-[var(--muted)] mt-1">Manage employee salaries and payments</p>
    </div>
    <div class="flex gap-3">
        <button onclick="processPayroll()" class="chip flex items-center gap-2 bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Process Payroll
        </button>
        <button onclick="openBulkSlipsModal()" class="chip flex items-center gap-2 hover:bg-[var(--hover-bg)] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Generate All Slips
        </button>
        <button class="chip flex items-center gap-2 hover:bg-[var(--hover-bg)] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Run Audit
        </button>
    </div>
</div>

@php
    use Illuminate\Support\Number;
    
    // Format currency helper
    function formatTzs($amount) {
        if ($amount >= 1000000) {
            return 'TZS ' . number_format($amount / 1000000, 2) . 'M';
        } elseif ($amount >= 1000) {
            return 'TZS ' . number_format($amount / 1000, 1) . 'K';
        }
        return 'TZS ' . number_format($amount, 0);
    }
    
    function formatUsd($amount) {
        return '$ ' . number_format($amount, 2);
    }
    
    // Get department color based on name
    function getDeptColor($name) {
        $colors = [
            'Sales' => 'blue',
            'Logistics' => 'orange',
            'Finance' => 'emerald',
            'Reservation' => 'green',
            'Marketing' => 'purple',
            'HR' => 'red',
            'IT' => 'cyan',
            'Operations' => 'amber',
            'Finance & Accounting' => 'emerald'
        ];
        foreach ($colors as $key => $color) {
            if (stripos($name, $key) !== false) {
                return $color;
            }
        }
        return 'gray';
    }
    
    // Get department initial
    function getDeptInitial($name) {
        return strtoupper(substr($name, 0, 1));
    }
    
    $tzsTotal = $stats['monthly_payroll_tzs'] ?? 0;
    $usdTotal = $stats['monthly_payroll_usd'] ?? 0;
    $totalEmployees = $stats['total_employees'] ?? 0;
    $employeesPaid = $stats['employees_paid'] ?? 0;
    $completionPercent = $stats['completion_percent'] ?? 0;
    $processedTzs = $stats['processed_tzs'] ?? 0;
    $processedUsd = $stats['processed_usd'] ?? 0;
    $pendingTzs = $stats['pending_tzs'] ?? 0;
    $pendingUsd = $stats['pending_usd'] ?? 0;
    $processedPercent = $stats['processed_percent'] ?? 0;
    $pendingPercent = $stats['pending_percent'] ?? 0;
@endphp

<!-- Payroll Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="panel p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11-.402-2.08-.599-3-1"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-[var(--muted)]">Monthly Payroll</div>
            <div class="font-semibold text-xl">{{ formatTzs($tzsTotal) }}</div>
            @if($usdTotal > 0)
            <div class="font-semibold text-lg text-blue-500">{{ formatUsd($usdTotal) }}</div>
            @endif
            <div class="text-xs text-green-500 mt-1">{{ $totalEmployees }} active employees</div>
        </div>
    </div>

    <div class="panel p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-[var(--muted)]">Employees Paid</div>
            <div class="font-semibold text-xl">{{ $employeesPaid }}/{{ $totalEmployees }}</div>
            <div class="text-xs text-blue-500 mt-1">{{ $completionPercent }}% completed</div>
        </div>
    </div>

    <div class="panel p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-[var(--muted)]">Processed</div>
            <div class="font-semibold text-xl">{{ formatTzs($processedTzs) }}</div>
            @if($processedUsd > 0)
            <div class="font-semibold text-sm text-blue-500">{{ formatUsd($processedUsd) }}</div>
            @endif
            <div class="text-xs text-green-500 mt-1">{{ $processedPercent }}% of total</div>
        </div>
    </div>

    <div class="panel p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-[var(--muted)]">Pending</div>
            <div class="font-semibold text-xl">{{ formatTzs($pendingTzs) }}</div>
            @if($pendingUsd > 0)
            <div class="font-semibold text-sm text-yellow-500">{{ formatUsd($pendingUsd) }}</div>
            @endif
            <div class="text-xs text-yellow-500 mt-1">{{ $pendingPercent }}% remaining</div>
        </div>
    </div>
</div>

@php
    $deptBreakdown = $departmentBreakdown['departments'] ?? [];
    $totalDeptTzs = $departmentBreakdown['total_tzs'] ?? 0;
    $totalDeptUsd = $departmentBreakdown['total_usd'] ?? 0;
@endphp

<!-- Payroll Summary -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Department-wise Breakdown -->
    <div class="panel p-6 lg:col-span-2">
        <h2 class="text-lg font-semibold logo-text mb-6">Department Payroll Breakdown</h2>
        @if(count($deptBreakdown) > 0)
        <div class="space-y-4">
            @foreach($deptBreakdown as $dept)
            @php
                $color = getDeptColor($dept['name']);
                $initial = getDeptInitial($dept['name']);
            @endphp
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-{{ $color }}-500/10 flex items-center justify-center">
                        <span class="text-{{ $color }}-500 font-semibold text-sm">{{ $initial }}</span>
                    </div>
                    <div>
                        <div class="font-medium text-sm logo-text">{{ $dept['name'] }}</div>
                        <div class="text-xs text-[var(--muted)]">{{ $dept['employee_count'] }} employees</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-semibold text-sm logo-text">{{ formatTzs($dept['total_tzs']) }}</div>
                    @if($dept['total_usd'] > 0)
                    <div class="font-semibold text-xs text-blue-500">{{ formatUsd($dept['total_usd']) }}</div>
                    @endif
                    <div class="text-xs text-[var(--muted)]">{{ $dept['percent'] }}% of total</div>
                </div>
            </div>
            @endforeach
        </div>
        <!-- Total Summary -->
        <div class="mt-6 pt-4 border-t border-[var(--border-color)]">
            <div class="flex items-center justify-between">
                <div class="font-semibold text-sm logo-text">Total Payroll</div>
                <div class="text-right">
                    <div class="font-semibold text-lg">{{ formatTzs($totalDeptTzs) }}</div>
                    @if($totalDeptUsd > 0)
                    <div class="font-semibold text-sm text-blue-500">{{ formatUsd($totalDeptUsd) }}</div>
                    @endif
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-8 text-[var(--muted)]">
            <p>No active employees found. Add employees to see payroll breakdown.</p>
        </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="panel p-6">
        <h2 class="text-lg font-semibold logo-text mb-6">Payroll Actions</h2>
        <div class="space-y-3">
            <button onclick="processPayroll()" class="chip w-full justify-center gap-2 hover:bg-[var(--hover-bg)] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Process This Month
            </button>
            <button onclick="openBulkSlipsModal()" class="chip w-full justify-center gap-2 hover:bg-[var(--hover-bg)] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Generate All Slips
            </button>
            <button class="chip w-full justify-center gap-2 hover:bg-[var(--hover-bg)] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Set Pay Period
            </button>
            <button class="chip w-full justify-center gap-2 hover:bg-[var(--hover-bg)] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Tax Settings
            </button>
        </div>

        <!-- Payroll Status -->
        <div class="mt-6 pt-6 border-t border-[var(--border-color)]">
            <h3 class="font-semibold text-sm logo-text mb-3">Current Status</h3>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-[var(--muted)]">Pay Period</span>
                    <span class="logo-text">{{ date('F Y') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-[var(--muted)]">Payment Date</span>
                    <span class="logo-text">{{ date('F d, Y', strtotime('+5 days')) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-[var(--muted)]">Status</span>
                    <span class="chip text-xs bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30">In Progress</span>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $transactions = $recentTransactions ?? collect([]);
@endphp

<!-- Recent Payroll Transactions -->
<div class="panel p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold logo-text">Recent Payroll Transactions</h2>
        <div class="flex gap-2">
            <select id="payrollDeptFilter" class="chip text-sm" onchange="filterPayrollTable()">
                <option value="">All Departments</option>
                @foreach($deptBreakdown as $dept)
                    <option value="{{ $dept['name'] }}">{{ $dept['name'] }}</option>
                @endforeach
            </select>
            <input type="month" id="payrollMonthFilter" class="chip text-sm" value="{{ date('Y-m') }}" onchange="filterPayrollTable()">
        </div>
    </div>

    @if($transactions->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-[var(--border-color)]">
                    <th class="text-left py-3 px-4 text-sm text-[var(--muted)] font-medium">Employee</th>
                    <th class="text-left py-3 px-4 text-sm text-[var(--muted)] font-medium">Department</th>
                    <th class="text-left py-3 px-4 text-sm text-[var(--muted)] font-medium">Basic Salary</th>
                    <th class="text-left py-3 px-4 text-sm text-[var(--muted)] font-medium">Allowances</th>
                    <th class="text-left py-3 px-4 text-sm text-[var(--muted)] font-medium">Commission</th>
                    <th class="text-left py-3 px-4 text-sm text-[var(--muted)] font-medium">Bonuses</th>
                    <th class="text-left py-3 px-4 text-sm text-[var(--muted)] font-medium">Total</th>
                    <th class="text-left py-3 px-4 text-sm text-[var(--muted)] font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[var(--border-color)]">
                @foreach($transactions as $employee)
                @php
                    $total = ($employee->salary ?? 0) + ($employee->allowances ?? 0) + ($employee->commission ?? 0) + ($employee->bonus ?? 0);
                    $currency = $employee->salary_currency ?? 'TZS';
                    $status = rand(0, 10) > 2 ? 'Paid' : (rand(0, 5) > 2 ? 'Processing' : 'Pending');
                    $statusClass = $status === 'Paid' ? 'bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30' : 
                                   ($status === 'Processing' ? 'bg-yellow-500/20 text-yellow-600 dark:text-yellow-400 border-yellow-500/30' : 
                                   'bg-red-500/20 text-red-600 dark:text-red-400 border-red-500/30');
                @endphp
                <tr class="payroll-row" data-department="{{ $employee->department }}">
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $employee->profile_photo_url }}" alt="{{ $employee->name }}" class="w-8 h-8 rounded-full">
                            <div>
                                <div class="font-medium text-sm logo-text">{{ $employee->name }}</div>
                                <div class="text-xs text-[var(--muted)]">{{ $employee->employee_id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-4 text-sm text-[var(--muted)]">{{ $employee->department }}</td>
                    <td class="py-3 px-4 text-sm logo-text">{{ $employee->salary ? ($currency === 'USD' ? formatUsd($employee->salary) : formatTzs($employee->salary)) : '-' }}</td>
                    <td class="py-3 px-4 text-sm logo-text">{{ $employee->allowances ? ($currency === 'USD' ? formatUsd($employee->allowances) : formatTzs($employee->allowances)) : '-' }}</td>
                    <td class="py-3 px-4 text-sm logo-text">{{ $employee->commission ? ($currency === 'USD' ? formatUsd($employee->commission) : formatTzs($employee->commission)) : '-' }}</td>
                    <td class="py-3 px-4 text-sm logo-text">{{ $employee->bonus ? ($currency === 'USD' ? formatUsd($employee->bonus) : formatTzs($employee->bonus)) : '-' }}</td>
                    <td class="py-3 px-4 text-sm logo-text font-semibold">
                        {{ $currency === 'USD' ? formatUsd($total) : formatTzs($total) }}
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-2">
                            <span class="chip text-xs {{ $statusClass }}">{{ $status }}</span>
                            <button onclick="downloadSalarySlip('{{ $employee->employee_id }}')" 
                                    class="chip text-xs bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] transition-colors"
                                    title="Download Salary Slip">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center py-12">
        <svg class="w-16 h-16 text-[var(--muted)] mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <h3 class="text-lg font-semibold logo-text mb-2">No Payroll Data</h3>
        <p class="text-[var(--muted)] text-sm">No active employees found. Add employees to see payroll transactions.</p>
    </div>
    @endif

    @if($transactions->count() > 0)
    <div class="flex justify-between items-center mt-6 pt-6 border-t border-[var(--border-color)]">
        <div class="text-sm text-[var(--muted)]">Showing {{ $transactions->count() }} of {{ $totalEmployees }} active employees</div>
        <div class="flex gap-2">
            <button class="chip text-sm hover:bg-[var(--hover-bg)] transition-colors">Previous</button>
            <button class="chip text-sm bg-[var(--g-spring)] text-white">1</button>
            <button class="chip text-sm hover:bg-[var(--hover-bg)] transition-colors">Next</button>
        </div>
    </div>
    @endif
</div>

<!-- Bulk Salary Slips Modal -->
<div id="bulkSlipsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4 z-50" style="display: none;">
    <div class="panel w-full max-w-md max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold logo-text">Generate Salary Slips</h3>
                <button type="button" onclick="closeBulkSlipsModal()" class="chip p-2 hover:bg-[var(--hover-bg)] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form onsubmit="generateBulkSlips(event)">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Select Month</label>
                        <input type="month" id="bulkMonth" name="month" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]" value="{{ date('Y-m') }}" required>
                    </div>
                    <div class="p-4 bg-[var(--chip-bg)] rounded-lg">
                        <p class="text-sm text-[var(--muted)]">
                            This will generate salary slips for all <strong>{{ $totalEmployees }}</strong> active employees with salary data.
                        </p>
                    </div>
                </div>
                
                <div class="flex gap-3 justify-end mt-6 pt-4 border-t border-[var(--border-color)]">
                    <button type="button" onclick="closeBulkSlipsModal()" class="chip px-6 py-2 hover:bg-[var(--hover-bg)] transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="chip px-6 py-2 bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] transition-colors">
                        Generate All Slips
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function processPayroll() {
        const month = document.getElementById('payrollMonthFilter')?.value || new Date().toISOString().slice(0, 7);
        
        Swal.fire({
            title: 'Processing Payroll...',
            text: 'Please wait while payroll is being processed for ' + month,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        fetch('{{ route("admin.payroll.process") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({ month: month })
        })
        .then(response => response.json())
        .then(data => {
            Swal.close();
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Payroll Processed',
                    text: data.message,
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to process payroll',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while processing payroll',
                confirmButtonText: 'OK'
            });
        });
    }
    
    function downloadSalarySlip(employeeId) {
        const month = document.getElementById('payrollMonthFilter')?.value || new Date().toISOString().slice(0, 7);
        
        // Open PDF in new window
        const url = '{{ route("admin.payroll.download_slip") }}?employee_id=' + employeeId + '&month=' + month;
        window.open(url, '_blank');
    }
    
    function openBulkSlipsModal() {
        const modal = document.getElementById('bulkSlipsModal');
        if (modal) {
            modal.style.display = 'flex';
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }
    
    function closeBulkSlipsModal() {
        const modal = document.getElementById('bulkSlipsModal');
        if (modal) {
            modal.style.display = 'none';
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }
    
    function generateBulkSlips(event) {
        event.preventDefault();
        
        const month = document.getElementById('bulkMonth')?.value || new Date().toISOString().slice(0, 7);
        
        Swal.fire({
            title: 'Generating Salary Slips...',
            text: 'Please wait while salary slips are being generated for ' + month,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        fetch('{{ route("admin.payroll.bulk_slips") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({ month: month })
        })
        .then(response => response.json())
        .then(data => {
            Swal.close();
            if (data.success) {
                closeBulkSlipsModal();
                Swal.fire({
                    icon: 'success',
                    title: 'Salary Slips Generated',
                    text: data.message,
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to generate salary slips',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while generating salary slips',
                confirmButtonText: 'OK'
            });
        });
    }
    
    function filterPayrollTable() {
        const deptFilter = document.getElementById('payrollDeptFilter')?.value || '';
        const monthFilter = document.getElementById('payrollMonthFilter')?.value || '';
        
        const rows = document.querySelectorAll('.payroll-row');
        rows.forEach(row => {
            const rowDept = row.getAttribute('data-department') || '';
            if (!deptFilter || rowDept === deptFilter) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
