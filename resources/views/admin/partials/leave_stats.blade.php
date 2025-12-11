<!-- Leave Management Header -->
<div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold logo-text">Leave Management</h1>
        <p class="text-[var(--muted)] mt-1">Manage employee leave requests and approvals</p>
    </div>
    <div class="flex gap-3">
        <button class="chip flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Leave Request
        </button>
        <button class="chip flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
            </svg>
            Filter
        </button>
        <button class="chip flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
            </svg>
            Export
        </button>
    </div>
</div>

<!-- Leave Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="panel p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-[var(--muted)]">Pending Requests</div>
            <div class="font-semibold text-xl">18</div>
            <div class="text-xs text-yellow-500 mt-1">Requires approval</div>
        </div>
    </div>

    <div class="panel p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-[var(--muted)]">Approved This Month</div>
            <div class="font-semibold text-xl">42</div>
            <div class="text-xs text-green-500 mt-1">+15% from last month</div>
        </div>
    </div>

    <div class="panel p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-[var(--muted)]">Rejected</div>
            <div class="font-semibold text-xl">5</div>
            <div class="text-xs text-red-500 mt-1">-2 from last month</div>
        </div>
    </div>

    <div class="panel p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-[var(--muted)]">On Leave Today</div>
            <div class="font-semibold text-xl">8</div>
            <div class="text-xs text-blue-500 mt-1">3% of workforce</div>
        </div>
    </div>
</div>

<!-- Leave Overview -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Leave Types Summary -->
    <div class="panel p-6 lg:col-span-2">
        <h2 class="text-lg font-semibold logo-text mb-6">Leave Types Summary</h2>
        <div class="space-y-4">
            <!-- Annual Leave -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-500/10 flex items-center justify-center">
                        <span class="text-blue-500 font-semibold text-sm">A</span>
                    </div>
                    <div>
                        <div class="font-medium text-sm logo-text">Annual Leave</div>
                        <div class="text-xs text-[var(--muted)]">20 days/year</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-semibold text-sm logo-text">1,240 days</div>
                    <div class="text-xs text-[var(--muted)]">62% remaining</div>
                </div>
            </div>

            <!-- Sick Leave -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-green-500/10 flex items-center justify-center">
                        <span class="text-green-500 font-semibold text-sm">S</span>
                    </div>
                    <div>
                        <div class="font-medium text-sm logo-text">Sick Leave</div>
                        <div class="text-xs text-[var(--muted)]">15 days/year</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-semibold text-sm logo-text">890 days</div>
                    <div class="text-xs text-[var(--muted)]">74% remaining</div>
                </div>
            </div>

            <!-- Emergency Leave -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-red-500/10 flex items-center justify-center">
                        <span class="text-red-500 font-semibold text-sm">E</span>
                    </div>
                    <div>
                        <div class="font-medium text-sm logo-text">Emergency Leave</div>
                        <div class="text-xs text-[var(--muted)]">10 days/year</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-semibold text-sm logo-text">420 days</div>
                    <div class="text-xs text-[var(--muted)]">42% remaining</div>
                </div>
            </div>

            <!-- Maternity Leave -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-purple-500/10 flex items-center justify-center">
                        <span class="text-purple-500 font-semibold text-sm">M</span>
                    </div>
                    <div>
                        <div class="font-medium text-sm logo-text">Maternity Leave</div>
                        <div class="text-xs text-[var(--muted)]">90 days</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-semibold text-sm logo-text">180 days</div>
                    <div class="text-xs text-[var(--muted)]">Available</div>
                </div>
            </div>

            <!-- Paternity Leave -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-orange-500/10 flex items-center justify-center">
                        <span class="text-orange-500 font-semibold text-sm">P</span>
                    </div>
                    <div>
                        <div class="font-medium text-sm logo-text">Paternity Leave</div>
                        <div class="text-xs text-[var(--muted)]">5 days</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-semibold text-sm logo-text">60 days</div>
                    <div class="text-xs text-[var(--muted)]">Available</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="panel p-6">
        <h2 class="text-lg font-semibold logo-text mb-6">Leave Actions</h2>
        <div class="space-y-3">
            <button class="chip w-full justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Approve All Pending
            </button>
            <button class="chip w-full justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Reject Selected
            </button>
            <button class="chip w-full justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                </svg>
                Generate Report
            </button>
            <button class="chip w-full justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Add Leave Type
            </button>
        </div>

        <!-- Leave Calendar -->
        <div class="mt-6 pt-6 border-t border-[var(--border-color)]">
            <h3 class="font-semibold text-sm logo-text mb-3">This Week</h3>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-[var(--muted)]">Mon</span>
                    <span class="logo-text">5 on leave</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-[var(--muted)]">Tue</span>
                    <span class="logo-text">7 on leave</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-[var(--muted)]">Wed</span>
                    <span class="logo-text">6 on leave</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-[var(--muted)]">Thu</span>
                    <span class="logo-text">4 on leave</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-[var(--muted)]">Fri</span>
                    <span class="logo-text">3 on leave</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Leave Requests -->
<div class="panel p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold logo-text">Recent Leave Requests</h2>
        <div class="flex gap-2">
            <select class="chip text-sm">
                <option>All Status</option>
                <option>Pending</option>
                <option>Approved</option>
                <option>Rejected</option>
            </select>
            <select class="chip text-sm">
                <option>All Departments</option>
                <option>Sales</option>
                <option>Reservation</option>
                <option>Logistics</option>
                <option>Marketing</option>
                <option>Finance & Accounting</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-[var(--border-color)]">
                    <th class="text-left py-3 px-4 text-sm text-[var(--muted)] font-medium">Employee</th>
                    <th class="text-left py-3 px-4 text-sm text-[var(--muted)] font-medium">Department</th>
                    <th class="text-left py-3 px-4 text-sm text-[var(--muted)] font-medium">Leave Type</th>
                    <th class="text-left py-3 px-4 text-sm text-[var(--muted)] font-medium">Dates</th>
                    <th class="text-left py-3 px-4 text-sm text-[var(--muted)] font-medium">Duration</th>
                    <th class="text-left py-3 px-4 text-sm text-[var(--muted)] font-medium">Status</th>
                    <th class="text-left py-3 px-4 text-sm text-[var(--muted)] font-medium">Actions</th>
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
                    <td class="py-3 px-4 text-sm logo-text">Annual Leave</td>
                    <td class="py-3 px-4 text-sm logo-text">Dec 15-20, 2024</td>
                    <td class="py-3 px-4 text-sm logo-text">6 days</td>
                    <td class="py-3 px-4">
                        <span class="chip text-xs bg-yellow-500/20 text-yellow-600 dark:text-yellow-400 border-yellow-500/30">Pending</span>
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex gap-2">
                            <button class="chip text-xs bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30">Approve</button>
                            <button class="chip text-xs bg-red-500/20 text-red-600 dark:text-red-400 border-red-500/30">Reject</button>
                        </div>
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
                    <td class="py-3 px-4 text-sm logo-text">Sick Leave</td>
                    <td class="py-3 px-4 text-sm logo-text">Dec 10-12, 2024</td>
                    <td class="py-3 px-4 text-sm logo-text">3 days</td>
                    <td class="py-3 px-4">
                        <span class="chip text-xs bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30">Approved</span>
                    </td>
                    <td class="py-3 px-4">
                        <button class="chip text-xs">View</button>
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
                    <td class="py-3 px-4 text-sm logo-text">Emergency Leave</td>
                    <td class="py-3 px-4 text-sm logo-text">Dec 5, 2024</td>
                    <td class="py-3 px-4 text-sm logo-text">1 day</td>
                    <td class="py-3 px-4">
                        <span class="chip text-xs bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30">Approved</span>
                    </td>
                    <td class="py-3 px-4">
                        <button class="chip text-xs">View</button>
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
                    <td class="py-3 px-4 text-sm logo-text">Maternity Leave</td>
                    <td class="py-3 px-4 text-sm logo-text">Jan 1 - Mar 31, 2025</td>
                    <td class="py-3 px-4 text-sm logo-text">90 days</td>
                    <td class="py-3 px-4">
                        <span class="chip text-xs bg-yellow-500/20 text-yellow-600 dark:text-yellow-400 border-yellow-500/30">Pending</span>
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex gap-2">
                            <button class="chip text-xs bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30">Approve</button>
                            <button class="chip text-xs bg-red-500/20 text-red-600 dark:text-red-400 border-red-500/30">Reject</button>
                        </div>
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
                    <td class="py-3 px-4 text-sm logo-text">Paternity Leave</td>
                    <td class="py-3 px-4 text-sm logo-text">Dec 20-24, 2024</td>
                    <td class="py-3 px-4 text-sm logo-text">5 days</td>
                    <td class="py-3 px-4">
                        <span class="chip text-xs bg-red-500/20 text-red-600 dark:text-red-400 border-red-500/30">Rejected</span>
                    </td>
                    <td class="py-3 px-4">
                        <button class="chip text-xs">View Reason</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex justify-between items-center mt-6 pt-6 border-t border-[var(--border-color)]">
        <div class="text-sm text-[var(--muted)]">Showing 5 of 18 pending requests</div>
        <div class="flex gap-2">
            <button class="chip text-sm">Previous</button>
            <button class="chip text-sm bg-[var(--hover-bg)]">1</button>
            <button class="chip text-sm">2</button>
            <button class="chip text-sm">3</button>
            <button class="chip text-sm">Next</button>
        </div>
    </div>
</div>