<!-- Payroll Header -->
<div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold logo-text">Payroll Management</h1>
        <p class="text-[var(--muted)] mt-1">Manage employee salaries and payments</p>
    </div>
    <div class="flex gap-3">
        <button class="chip flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Process Payroll
        </button>
        <button class="chip flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
            </svg>
            Export Report
        </button>
        <button class="chip flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Run Audit
        </button>
    </div>
</div>

<!-- Payroll Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="panel p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-[var(--muted)]">Monthly Payroll</div>
            <div class="font-semibold text-xl">$284,560</div>
            <div class="text-xs text-green-500 mt-1">+8% from last month</div>
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
            <div class="font-semibold text-xl">118/124</div>
            <div class="text-xs text-blue-500 mt-1">95% completed</div>
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
            <div class="font-semibold text-xl">$268,432</div>
            <div class="text-xs text-green-500 mt-1">94% of total</div>
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
            <div class="font-semibold text-xl">$16,128</div>
            <div class="text-xs text-yellow-500 mt-1">6% remaining</div>
        </div>
    </div>
</div>

<!-- Payroll Summary -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Department-wise Breakdown -->
    <div class="panel p-6 lg:col-span-2">
        <h2 class="text-lg font-semibold logo-text mb-6">Department Payroll Breakdown</h2>
        <div class="space-y-4">
            <!-- Sales Department -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-500/10 flex items-center justify-center">
                        <span class="text-blue-500 font-semibold text-sm">S</span>
                    </div>
                    <div>
                        <div class="font-medium text-sm logo-text">Sales</div>
                        <div class="text-xs text-[var(--muted)]">28 employees</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-semibold text-sm logo-text">$85,200</div>
                    <div class="text-xs text-[var(--muted)]">30% of total</div>
                </div>
            </div>

            <!-- Logistics Department -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-orange-500/10 flex items-center justify-center">
                        <span class="text-orange-500 font-semibold text-sm">L</span>
                    </div>
                    <div>
                        <div class="font-medium text-sm logo-text">Logistics</div>
                        <div class="text-xs text-[var(--muted)]">35 employees</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-semibold text-sm logo-text">$73,500</div>
                    <div class="text-xs text-[var(--muted)]">26% of total</div>
                </div>
            </div>

            <!-- Finance Department -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                        <span class="text-emerald-500 font-semibold text-sm">F</span>
                    </div>
                    <div>
                        <div class="font-medium text-sm logo-text">Finance & Accounting</div>
                        <div class="text-xs text-[var(--muted)]">21 employees</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-semibold text-sm logo-text">$52,500</div>
                    <div class="text-xs text-[var(--muted)]">18% of total</div>
                </div>
            </div>

            <!-- Reservation Department -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-green-500/10 flex items-center justify-center">
                        <span class="text-green-500 font-semibold text-sm">R</span>
                    </div>
                    <div>
                        <div class="font-medium text-sm logo-text">Reservation</div>
                        <div class="text-xs text-[var(--muted)]">22 employees</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-semibold text-sm logo-text">$44,000</div>
                    <div class="text-xs text-[var(--muted)]">15% of total</div>
                </div>
            </div>

            <!-- Marketing Department -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-purple-500/10 flex items-center justify-center">
                        <span class="text-purple-500 font-semibold text-sm">M</span>
                    </div>
                    <div>
                        <div class="font-medium text-sm logo-text">Marketing</div>
                        <div class="text-xs text-[var(--muted)]">18 employees</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-semibold text-sm logo-text">$29,360</div>
                    <div class="text-xs text-[var(--muted)]">11% of total</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="panel p-6">
        <h2 class="text-lg font-semibold logo-text mb-6">Payroll Actions</h2>
        <div class="space-y-3">
            <button class="chip w-full justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Process This Month
            </button>
            <button class="chip w-full justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Generate Reports
            </button>
            <button class="chip w-full justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Set Pay Period
            </button>
            <button class="chip w-full justify-center gap-2">
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
                    <span class="logo-text">Nov 1-30, 2024</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-[var(--muted)]">Payment Date</span>
                    <span class="logo-text">Dec 5, 2024</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-[var(--muted)]">Status</span>
                    <span class="chip text-xs bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30">In Progress</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Payroll Transactions -->
<div class="panel p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold logo-text">Recent Payroll Transactions</h2>
        <div class="flex gap-2">
            <select class="chip text-sm">
                <option>All Departments</option>
                <option>Sales</option>
                <option>Reservation</option>
                <option>Logistics</option>
                <option>Marketing</option>
                <option>Finance & Accounting</option>
            </select>
            <input type="month" class="chip text-sm" value="{{ date('Y-m') }}">
        </div>
    </div>

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
                    <th class="text-left py-3 px-4 text-sm text-[var(--muted)] font-medium">Deductions</th>
                    <th class="text-left py-3 px-4 text-sm text-[var(--muted)] font-medium">Net Salary</th>
                    <th class="text-left py-3 px-4 text-sm text-[var(--muted)] font-medium">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[var(--border-color)]">
                <!-- Row 1 -->
                <tr>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-3">
                            <img src="https://i.pravatar.cc/40?img=1" alt="John Doe" class="w-8 h-8 rounded-full">
                            <div>
                                <div class="font-medium text-sm logo-text">John Doe</div>
                                <div class="text-xs text-[var(--muted)]">Sales Manager</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-4 text-sm text-[var(--muted)]">Sales</td>
                    <td class="py-3 px-4 text-sm logo-text">$5,800</td>
                    <td class="py-3 px-4 text-sm logo-text">$1,200</td>
                    <td class="py-3 px-4 text-sm logo-text">$450</td>
                    <td class="py-3 px-4 text-sm logo-text">$100</td>
                    <td class="py-3 px-4 text-sm logo-text">$50</td>
                    <td class="py-3 px-4 text-sm logo-text font-semibold">$6,550</td>
                    <td class="py-3 px-4">
                        <span class="chip text-xs bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30">Paid</span>
                    </td>
                </tr>
                
                <!-- Row 2 -->
                <tr>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-3">
                            <img src="https://i.pravatar.cc/40?img=2" alt="Jane Smith" class="w-8 h-8 rounded-full">
                            <div>
                                <div class="font-medium text-sm logo-text">Jane Smith</div>
                                <div class="text-xs text-[var(--muted)]">Marketing Head</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-4 text-sm text-[var(--muted)]">Marketing</td>
                    <td class="py-3 px-4 text-sm logo-text">$5,200</td>
                    <td class="py-3 px-4 text-sm logo-text">$800</td>
                    <td class="py-3 px-4 text-sm logo-text">$30</td>
                    <td class="py-3 px-4 text-sm logo-text">$80</td>
                    <td class="py-3 px-4 text-sm logo-text">$380</td>
                    <td class="py-3 px-4 text-sm logo-text font-semibold">$5,620</td>
                    <td class="py-3 px-4">
                        <span class="chip text-xs bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30">Paid</span>
                    </td>
                </tr>
                
                <!-- Row 3 -->
                <tr>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-3">
                            <img src="https://i.pravatar.cc/40?img=3" alt="Mike Johnson" class="w-8 h-8 rounded-full">
                            <div>
                                <div class="font-medium text-sm logo-text">Mike Johnson</div>
                                <div class="text-xs text-[var(--muted)]">Logistics Supervisor</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-4 text-sm text-[var(--muted)]">Logistics</td>
                    <td class="py-3 px-4 text-sm logo-text">$4,500</td>
                    <td class="py-3 px-4 text-sm logo-text">$600</td>
                    <td class="py-3 px-4 text-sm logo-text">$320</td>
                    <td class="py-3 px-4 text-sm logo-text">$60</td>
                    <td class="py-3 px-4 text-sm logo-text">$300</td>
                    <td class="py-3 px-4 text-sm logo-text font-semibold">$4,780</td>
                    <td class="py-3 px-4">
                        <span class="chip text-xs bg-yellow-500/20 text-yellow-600 dark:text-yellow-400 border-yellow-500/30">Processing</span>
                    </td>
                </tr>
                
                <!-- Row 4 -->
                <tr>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-3">
                            <img src="https://i.pravatar.cc/40?img=4" alt="Sarah Wilson" class="w-8 h-8 rounded-full">
                            <div>
                                <div class="font-medium text-sm logo-text">Sarah Wilson</div>
                                <div class="text-xs text-[var(--muted)]">Reservation Agent</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-4 text-sm text-[var(--muted)]">Reservation</td>
                    <td class="py-3 px-4 text-sm logo-text">$3,200</td>
                    <td class="py-3 px-4 text-sm logo-text">$400</td>
                    <td class="py-3 px-4 text-sm logo-text">$210</td>
                    <td class="py-3 px-4 text-sm logo-text">$40</td>
                    <td class="py-3 px-4 text-sm logo-text">$240</td>
                    <td class="py-3 px-4 text-sm logo-text font-semibold">$3,390</td>
                    <td class="py-3 px-4">
                        <span class="chip text-xs bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30">Paid</span>
                    </td>
                </tr>
                
                <!-- Row 5 -->
                <tr>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-3">
                            <img src="https://i.pravatar.cc/40?img=5" alt="David Brown" class="w-8 h-8 rounded-full">
                            <div>
                                <div class="font-medium text-sm logo-text">David Brown</div>
                                <div class="text-xs text-[var(--muted)]">Finance Analyst</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-4 text-sm text-[var(--muted)]">Finance</td>
                    <td class="py-3 px-4 text-sm logo-text">$4,800</td>
                    <td class="py-3 px-4 text-sm logo-text">$700</td>
                    <td class="py-3 px-4 text-sm logo-text">$350</td>
                    <td class="py-3 px-4 text-sm logo-text">$500</td>
                    <td class="py-3 px-4 text-sm logo-text">$150</td>
                    <td class="py-3 px-4 text-sm logo-text font-semibold">$5,150</td>
                    <td class="py-3 px-4">
                        <span class="chip text-xs bg-red-500/20 text-red-600 dark:text-red-400 border-red-500/30">Pending</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex justify-between items-center mt-6 pt-6 border-t border-[var(--border-color)]">
        <div class="text-sm text-[var(--muted)]">Showing 5 of 118 processed employees</div>
        <div class="flex gap-2">
            <button class="chip text-sm">Previous</button>
            <button class="chip text-sm bg-[var(--hover-bg)]">1</button>
            <button class="chip text-sm">2</button>
            <button class="chip text-sm">3</button>
            <button class="chip text-sm">Next</button>
        </div>
    </div>
</div>