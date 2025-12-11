<!-- Attendance Header -->
<div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold logo-text">Attendance Management</h1>
        <p class="text-[var(--muted)] mt-1">Track and manage employee attendance</p>
    </div>
    <div class="flex gap-3">
        <button class="chip flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Mark Attendance
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

<!-- Attendance Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="panel p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-[var(--muted)]">Present Today</div>
            <div class="font-semibold text-xl">118</div>
            <div class="text-xs text-green-500 mt-1">+5% from yesterday</div>
        </div>
    </div>

    <div class="panel p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-[var(--muted)]">Absent Today</div>
            <div class="font-semibold text-xl">6</div>
            <div class="text-xs text-red-500 mt-1">-2% from yesterday</div>
        </div>
    </div>

    <div class="panel p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-[var(--muted)]">Late Arrivals</div>
            <div class="font-semibold text-xl">8</div>
            <div class="text-xs text-yellow-500 mt-1">Same as yesterday</div>
        </div>
    </div>

    <div class="panel p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-[var(--muted)]">Early Checkouts</div>
            <div class="font-semibold text-xl">2</div>
            <div class="text-xs text-green-500 mt-1">Same as yesterday</div>
        </div>
    </div>
</div>

<!-- Recent Attendance Table -->
<div class="panel p-6 mb-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold logo-text">Today's Attendance</h2>
        <div class="flex gap-2">
            <select class="chip text-sm">
                <option>All Departments</option>
                <option>Sales</option>
                <option>Reservation</option>
                <option>Logistics</option>
                <option>Marketing</option>
                <option>Finance & Accounting</option>
            </select>
            <input type="date" class="chip text-sm" value="{{ date('Y-m-d') }}">
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-[var(--border-color)]">
                    <th class="text-left py-3 px-4 text-sm text-[var(--muted)] font-medium">Employee</th>
                    <th class="text-left py-3 px-4 text-sm text-[var(--muted)] font-medium">Department</th>
                    <th class="text-left py-3 px-4 text-sm text-[var(--muted)] font-medium">Check In</th>
                    <th class="text-left py-3 px-4 text-sm text-[var(--muted)] font-medium">Check Out</th>
                    <th class="text-left py-3 px-4 text-sm text-[var(--muted)] font-medium">Status</th>
                    <th class="text-left py-3 px-4 text-sm text-[var(--muted)] font-medium">Hours</th>
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
                                <div class="text-xs text-[var(--muted)]">EMP001</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-4 text-sm text-[var(--muted)]">Sales</td>
                    <td class="py-3 px-4 text-sm logo-text">08:15 AM</td>
                    <td class="py-3 px-4 text-sm logo-text">05:30 PM</td>
                    <td class="py-3 px-4">
                        <span class="chip text-xs bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30">Present</span>
                    </td>
                    <td class="py-3 px-4 text-sm logo-text">9.25h</td>
                </tr>
                
                <!-- Row 2 -->
                <tr>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-3">
                            <img src="https://i.pravatar.cc/40?img=2" alt="Jane Smith" class="w-8 h-8 rounded-full">
                            <div>
                                <div class="font-medium text-sm logo-text">Jane Smith</div>
                                <div class="text-xs text-[var(--muted)]">EMP002</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-4 text-sm text-[var(--muted)]">Marketing</td>
                    <td class="py-3 px-4 text-sm logo-text">08:45 AM</td>
                    <td class="py-3 px-4 text-sm logo-text">-</td>
                    <td class="py-3 px-4">
                        <span class="chip text-xs bg-yellow-500/20 text-yellow-600 dark:text-yellow-400 border-yellow-500/30">Late</span>
                    </td>
                    <td class="py-3 px-4 text-sm logo-text">-</td>
                </tr>
                
                <!-- Row 3 -->
                <tr>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-3">
                            <img src="https://i.pravatar.cc/40?img=3" alt="Mike Johnson" class="w-8 h-8 rounded-full">
                            <div>
                                <div class="font-medium text-sm logo-text">Mike Johnson</div>
                                <div class="text-xs text-[var(--muted)]">EMP003</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-4 text-sm text-[var(--muted)]">Logistics</td>
                    <td class="py-3 px-4 text-sm logo-text">08:00 AM</td>
                    <td class="py-3 px-4 text-sm logo-text">05:00 PM</td>
                    <td class="py-3 px-4">
                        <span class="chip text-xs bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30">Present</span>
                    </td>
                    <td class="py-3 px-4 text-sm logo-text">9.00h</td>
                </tr>
                
                <!-- Row 4 -->
                <tr>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-3">
                            <img src="https://i.pravatar.cc/40?img=4" alt="Sarah Wilson" class="w-8 h-8 rounded-full">
                            <div>
                                <div class="font-medium text-sm logo-text">Sarah Wilson</div>
                                <div class="text-xs text-[var(--muted)]">EMP004</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-4 text-sm text-[var(--muted)]">Reservation</td>
                    <td class="py-3 px-4 text-sm logo-text">-</td>
                    <td class="py-3 px-4 text-sm logo-text">-</td>
                    <td class="py-3 px-4">
                        <span class="chip text-xs bg-red-500/20 text-red-600 dark:text-red-400 border-red-500/30">Absent</span>
                    </td>
                    <td class="py-3 px-4 text-sm logo-text">0h</td>
                </tr>
                
                <!-- Row 5 -->
                <tr>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-3">
                            <img src="https://i.pravatar.cc/40?img=5" alt="David Brown" class="w-8 h-8 rounded-full">
                            <div>
                                <div class="font-medium text-sm logo-text">David Brown</div>
                                <div class="text-xs text-[var(--muted)]">EMP005</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-4 text-sm text-[var(--muted)]">Finance</td>
                    <td class="py-3 px-4 text-sm logo-text">08:10 AM</td>
                    <td class="py-3 px-4 text-sm logo-text">05:45 PM</td>
                    <td class="py-3 px-4">
                        <span class="chip text-xs bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30">Present</span>
                    </td>
                    <td class="py-3 px-4 text-sm logo-text">9.58h</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex justify-between items-center mt-6 pt-6 border-t border-[var(--border-color)]">
        <div class="text-sm text-[var(--muted)]">Showing 5 of 124 employees</div>
        <div class="flex gap-2">
            <button class="chip text-sm">Previous</button>
            <button class="chip text-sm bg-[var(--hover-bg)]">1</button>
            <button class="chip text-sm">2</button>
            <button class="chip text-sm">3</button>
            <button class="chip text-sm">Next</button>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="panel p-6">
        <h3 class="font-semibold text-lg logo-text mb-4">Quick Actions</h3>
        <div class="space-y-3">
            <button class="chip w-full justify-center">Bulk Check-in</button>
            <button class="chip w-full justify-center">Generate Report</button>
            <button class="chip w-full justify-center">Send Reminders</button>
        </div>
    </div>
    
    <div class="panel p-6 md:col-span-2">
        <h3 class="font-semibold text-lg logo-text mb-4">Attendance Overview</h3>
        <div class="grid grid-cols-2 gap-4">
            <div class="text-center p-4 rounded-lg bg-[var(--chip-bg)]">
                <div class="text-2xl font-bold text-green-500">95%</div>
                <div class="text-sm text-[var(--muted)] mt-1">This Week</div>
            </div>
            <div class="text-center p-4 rounded-lg bg-[var(--chip-bg)]">
                <div class="text-2xl font-bold text-blue-500">92%</div>
                <div class="text-sm text-[var(--muted)] mt-1">This Month</div>
            </div>
            <div class="text-center p-4 rounded-lg bg-[var(--chip-bg)]">
                <div class="text-2xl font-bold text-purple-500">89%</div>
                <div class="text-sm text-[var(--muted)] mt-1">Last Month</div>
            </div>
            <div class="text-center p-4 rounded-lg bg-[var(--chip-bg)]">
                <div class="text-2xl font-bold text-orange-500">12</div>
                <div class="text-sm text-[var(--muted)] mt-1">Late This Week</div>
            </div>
        </div>
    </div>
</div>