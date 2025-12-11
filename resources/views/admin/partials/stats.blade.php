    <!-- Top stat pills -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="panel p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.833.6 6.879 1.804M12 12a4 4 0 100-8 4 4 0 000 8z" />
                </svg>
            </div>
            <div>
                <div class="text-sm text-[var(--muted)]">120 / 120</div>
                <div class="font-semibold">Total Employees</div>
            </div>
        </div>

        <div class="panel p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-[var(--muted)]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6M12 9v6" />
                </svg>
            </div>
            <div>
                <div class="text-sm text-[var(--muted)]">24 / 120</div>
                <div class="font-semibold">On Leave</div>
            </div>
        </div>

        <div class="panel p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-[var(--muted)]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v8l3 3" />
                </svg>
            </div>
            <div>
                <div class="text-sm text-[var(--muted)]">20 / 120</div>
                <div class="font-semibold">New Joinee</div>
            </div>
        </div>

        <div class="panel p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
                <div class="text-2xl">😊</div>
            </div>
            <div>
                <div class="text-sm text-[var(--muted)]">85% / 100%</div>
                <div class="font-semibold">Happiness Rate</div>
            </div>
        </div>
    </section>

    <!-- Main columns -->
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left column (Employee status card) -->
        <div class="lg:col-span-1 space-y-6">
            <div class="panel p-5">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-sm font-semibold">Employee Status</h3>
                    <div class="chip text-xs">This Week</div>
                </div>

                <div class="text-sm text-[var(--muted)] mb-3">Total Employee</div>

                <!-- progress bar -->
                <div class="w-full h-3 rounded-full bg-[var(--chip-bg)] overflow-hidden mb-4">
                    <div style="width:74%" class="h-3 bg-[var(--g-spring)] transition-all duration-500"></div>
                </div>

                <div class="grid grid-cols-2 gap-3 text-sm mb-4">
                    <div class="panel p-3">
                        <div class="text-[var(--muted)] text-xs">Fulltime (48%)</div>
                        <div class="font-bold text-lg">58</div>
                    </div>
                    <div class="panel p-3">
                        <div class="text-[var(--muted)] text-xs">Contract (10%)</div>
                        <div class="font-bold text-lg">12</div>
                    </div>
                    <div class="panel p-3">
                        <div class="text-[var(--muted)] text-xs">Probation (22%)</div>
                        <div class="font-bold text-lg">26</div>
                    </div>
                    <div class="panel p-3">
                        <div class="text-[var(--muted)] text-xs">WFH (20%)</div>
                        <div class="font-bold text-lg">24</div>
                    </div>
                </div>

                <div class="mt-2 flex items-center gap-3 p-3 panel">
                    <img src="https://i.pravatar.cc/40?img=3" class="w-9 h-9 rounded-full border border-[var(--border-color)]" alt="top performer" />
                    <div class="text-sm">
                        <div class="font-medium">Shirley Baker</div>
                        <div class="text-[var(--muted)] text-xs">iOS Developer — <span style="color: var(--g-spring);" class="font-semibold">98%</span></div>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <button class="chip w-full">View All Employees</button>
                </div>
            </div>
        </div>

        <!-- Middle column (Donut chart) -->
        <div class="lg:col-span-1">
            <div class="panel p-5 flex flex-col items-center justify-between h-full">
                <div class="w-full flex justify-between items-start mb-4">
                    <h3 class="text-sm font-semibold">Attendance Overview</h3>
                    <div class="chip text-xs">Today</div>
                </div>

                <!-- donut chart -->
                <div class="flex items-center justify-center my-6">
                    <svg viewBox="0 0 42 42" class="w-44 h-44">
                        <circle r="15.9155" cx="21" cy="21" fill="transparent" stroke="var(--chip-bg)" stroke-width="8" />
                        <circle r="15.9155" cx="21" cy="21" fill="transparent" stroke="rgba(99,179,255,0.9)" stroke-width="8" stroke-dasharray="70 30" stroke-linecap="round" transform="rotate(-90 21 21)" />
                        <circle r="15.9155" cx="21" cy="21" fill="transparent" stroke="rgba(226,248,123,0.9)" stroke-width="8" stroke-dasharray="10 90" stroke-linecap="round" transform="rotate(10 21 21)" />
                        <text x="21" y="22.5" text-anchor="middle" font-size="6" fill="var(--accent-text)" font-weight="700">120</text>
                        <text x="21" y="28.5" text-anchor="middle" font-size="2.2" fill="var(--muted)">Total Attendance</text>
                    </svg>
                </div>

                <div class="w-full text-sm">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center"><span class="dot" style="background:#a7d7ff"></span>Present</div>
                        <div class="text-[var(--muted)]">75%</div>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center"><span class="dot" style="background:#f6d7a0"></span>Late</div>
                        <div class="text-[var(--muted)]">15%</div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center"><span class="dot" style="background:#d6baf7"></span>Absent</div>
                        <div class="text-[var(--muted)]">10%</div>
                    </div>
                </div>

                <div class="mt-6 w-full">
                    <button class="chip w-full">View Details</button>
                </div>
            </div>
        </div>

        <!-- Right column (Clock-in/out list) -->
        <div class="lg:col-span-1 space-y-6">
            <div class="panel p-4">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-sm font-semibold">Clock-In/Out</h3>
                    <div class="chip text-xs">Today</div>
                </div>

                <div class="space-y-3">
                    <div class="panel p-3 flex items-center justify-between">
                        <div class="flex items-center gap-3 min-w-0 flex-1">
                            <img src="https://i.pravatar.cc/40?img=1" class="w-9 h-9 rounded-full flex-shrink-0" alt="Shirley Baker" />
                            <div class="min-w-0">
                                <div class="font-medium text-sm truncate">Shirley Baker</div>
                                <div class="text-xs text-[var(--muted)] truncate">iOS Developer</div>
                            </div>
                        </div>
                        <div class="text-xs chip px-3 py-1 ml-2 flex-shrink-0">09:15</div>
                    </div>

                    <div class="panel p-3 flex items-center justify-between">
                        <div class="flex items-center gap-3 min-w-0 flex-1">
                            <img src="https://i.pravatar.cc/40?img=2" class="w-9 h-9 rounded-full flex-shrink-0" alt="Maryann Tabares" />
                            <div class="min-w-0">
                                <div class="font-medium text-sm truncate">Maryann Tabares</div>
                                <div class="text-xs text-[var(--muted)] truncate">UI/UX Designer</div>
                            </div>
                        </div>
                        <div class="text-xs chip px-3 py-1 ml-2 flex-shrink-0">09:35</div>
                    </div>

                    <div class="panel p-3 flex items-center justify-between">
                        <div class="flex items-center gap-3 min-w-0 flex-1">
                            <img src="https://i.pravatar.cc/40?img=4" class="w-9 h-9 rounded-full flex-shrink-0" alt="Mario Hildreth" />
                            <div class="min-w-0">
                                <div class="font-medium text-sm truncate">Mario Hildreth</div>
                                <div class="text-xs text-[var(--muted)] truncate">Project Manager</div>
                            </div>
                        </div>
                        <div class="text-xs chip px-3 py-1 ml-2 flex-shrink-0">09:30</div>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <button class="chip w-full">View All Attendance</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Lower area (jobs / employees / todo cards) -->
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        <div class="panel p-4">
            <div class="flex justify-between items-center mb-3">
                <h4 class="text-sm font-semibold">Jobs Applicants</h4>
                <button class="chip text-xs">View All</button>
            </div>
            <div class="space-y-3 mt-4">
                <div class="flex items-center justify-between p-3 panel">
                    <div>
                        <div class="font-medium text-sm">Senior Developer</div>
                        <div class="text-xs text-[var(--muted)]">12 Applicants</div>
                    </div>
                    <span class="chip text-xs px-3 py-1">Open</span>
                </div>
                <div class="flex items-center justify-between p-3 panel">
                    <div>
                        <div class="font-medium text-sm">UI/UX Designer</div>
                        <div class="text-xs text-[var(--muted)]">8 Applicants</div>
                    </div>
                    <span class="chip text-xs px-3 py-1">Open</span>
                </div>
                <div class="flex items-center justify-between p-3 panel">
                    <div>
                        <div class="font-medium text-sm">Project Manager</div>
                        <div class="text-xs text-[var(--muted)]">5 Applicants</div>
                    </div>
                    <span class="chip text-xs px-3 py-1">Open</span>
                </div>
            </div>
        </div>

        <div class="panel p-4">
            <div class="flex justify-between items-center mb-3">
                <h4 class="text-sm font-semibold">Recent Employees</h4>
                <button class="chip text-xs">View All</button>
            </div>
            <div class="space-y-3 mt-4">
                <div class="flex items-center gap-3 p-3 panel">
                    <img src="https://i.pravatar.cc/40?img=6" class="w-10 h-10 rounded-full flex-shrink-0" alt="Employee" />
                    <div class="flex-1 min-w-0">
                        <div class="font-medium text-sm truncate">John Smith</div>
                        <div class="text-xs text-[var(--muted)]">Marketing</div>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 panel">
                    <img src="https://i.pravatar.cc/40?img=7" class="w-10 h-10 rounded-full flex-shrink-0" alt="Employee" />
                    <div class="flex-1 min-w-0">
                        <div class="font-medium text-sm truncate">Emma Wilson</div>
                        <div class="text-xs text-[var(--muted)]">Sales</div>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 panel">
                    <img src="https://i.pravatar.cc/40?img=8" class="w-10 h-10 rounded-full flex-shrink-0" alt="Employee" />
                    <div class="flex-1 min-w-0">
                        <div class="font-medium text-sm truncate">Michael Brown</div>
                        <div class="text-xs text-[var(--muted)]">IT Support</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel p-4">
            <div class="flex justify-between items-center mb-3">
                <h4 class="text-sm font-semibold">Todo</h4>
                <div class="chip text-xs">Today</div>
            </div>
            <div class="space-y-3 mt-4">
                <div class="flex items-start gap-3 p-3 panel">
                    <input type="checkbox" class="mt-1 cursor-pointer" />
                    <div class="flex-1 min-w-0">
                        <div class="font-medium text-sm">Review payroll reports</div>
                        <div class="text-xs text-[var(--muted)]">Due: 2:00 PM</div>
                    </div>
                </div>
                <div class="flex items-start gap-3 p-3 panel">
                    <input type="checkbox" class="mt-1 cursor-pointer" />
                    <div class="flex-1 min-w-0">
                        <div class="font-medium text-sm">Team meeting</div>
                        <div class="text-xs text-[var(--muted)]">Due: 4:00 PM</div>
                    </div>
                </div>
                <div class="flex items-start gap-3 p-3 panel">
                    <input type="checkbox" class="mt-1 cursor-pointer" />
                    <div class="flex-1 min-w-0">
                        <div class="font-medium text-sm">Update employee records</div>
                        <div class="text-xs text-[var(--muted)]">Due: 5:00 PM</div>
                    </div>
                </div>
            </div>
        </div>
    </section>