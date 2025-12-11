<!-- Department List Header -->
<div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold logo-text">Department Management</h1>
        <p class="text-[var(--muted)] mt-1">Manage and view all departments</p>
    </div>
    <div class="flex gap-3">
        <button class="chip flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Department
        </button>
        <button class="chip flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
            </svg>
            Filter
        </button>
    </div>
</div>

<!-- Department Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="panel p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-[var(--muted)]">Total Departments</div>
            <div class="font-semibold text-xl">5</div>
        </div>
    </div>

    <div class="panel p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-[var(--muted)]">Total Employees</div>
            <div class="font-semibold text-xl">124</div>
        </div>
    </div>

    <div class="panel p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-[var(--muted)]">Active Teams</div>
            <div class="font-semibold text-xl">5</div>
        </div>
    </div>

    <div class="panel p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-[var(--muted)]">Avg Team Size</div>
            <div class="font-semibold text-xl">25</div>
        </div>
    </div>
</div>

<!-- Department Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    <!-- Sales Department -->
    <div class="panel p-6">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-14 h-14 rounded-full border-2 border-[var(--border-color)] bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
                    S
                </div>
                <div>
                    <h3 class="font-semibold text-lg logo-text">Sales</h3>
                    <p class="text-[var(--muted)] text-sm">Revenue Generation Team</p>
                </div>
            </div>
            <div class="chip text-xs px-3 py-1 bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30">28</div>
        </div>
        
        <div class="mb-4">
            <div class="flex justify-between text-sm text-[var(--muted)] mb-2">
                <span>Team Members</span>
                <span>28 employees</span>
            </div>
            <div class="w-full h-2 rounded-full bg-[var(--chip-bg)] overflow-hidden">
                <div class="h-2 bg-blue-500 rounded-full" style="width: 85%"></div>
            </div>
        </div>
        
        <div class="flex gap-2">
            <button class="chip flex-1 text-center text-sm">View Team</button>
            <button class="chip flex-1 text-center text-sm">Manage</button>
        </div>
    </div>

    <!-- Reservation Department -->
    <div class="panel p-6">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-14 h-14 rounded-full border-2 border-[var(--border-color)] bg-gradient-to-r from-green-500 to-teal-600 flex items-center justify-center text-white font-bold text-lg">
                    R
                </div>
                <div>
                    <h3 class="font-semibold text-lg logo-text">Reservation</h3>
                    <p class="text-[var(--muted)] text-sm">Booking & Customer Service</p>
                </div>
            </div>
            <div class="chip text-xs px-3 py-1 bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30">22</div>
        </div>
        
        <div class="mb-4">
            <div class="flex justify-between text-sm text-[var(--muted)] mb-2">
                <span>Team Members</span>
                <span>22 employees</span>
            </div>
            <div class="w-full h-2 rounded-full bg-[var(--chip-bg)] overflow-hidden">
                <div class="h-2 bg-green-500 rounded-full" style="width: 70%"></div>
            </div>
        </div>
        
        <div class="flex gap-2">
            <button class="chip flex-1 text-center text-sm">View Team</button>
            <button class="chip flex-1 text-center text-sm">Manage</button>
        </div>
    </div>

    <!-- Logistics Department -->
    <div class="panel p-6">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-14 h-14 rounded-full border-2 border-[var(--border-color)] bg-gradient-to-r from-orange-500 to-red-600 flex items-center justify-center text-white font-bold text-lg">
                    L
                </div>
                <div>
                    <h3 class="font-semibold text-lg logo-text">Logistics</h3>
                    <p class="text-[var(--muted)] text-sm">Supply Chain & Operations</p>
                </div>
            </div>
            <div class="chip text-xs px-3 py-1 bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30">35</div>
        </div>
        
        <div class="mb-4">
            <div class="flex justify-between text-sm text-[var(--muted)] mb-2">
                <span>Team Members</span>
                <span>35 employees</span>
            </div>
            <div class="w-full h-2 rounded-full bg-[var(--chip-bg)] overflow-hidden">
                <div class="h-2 bg-orange-500 rounded-full" style="width: 95%"></div>
            </div>
        </div>
        
        <div class="flex gap-2">
            <button class="chip flex-1 text-center text-sm">View Team</button>
            <button class="chip flex-1 text-center text-sm">Manage</button>
        </div>
    </div>

    <!-- Marketing Department -->
    <div class="panel p-6">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-14 h-14 rounded-full border-2 border-[var(--border-color)] bg-gradient-to-r from-purple-500 to-pink-600 flex items-center justify-center text-white font-bold text-lg">
                    M
                </div>
                <div>
                    <h3 class="font-semibold text-lg logo-text">Marketing</h3>
                    <p class="text-[var(--muted)] text-sm">Brand & Campaign Management</p>
                </div>
            </div>
            <div class="chip text-xs px-3 py-1 bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30">18</div>
        </div>
        
        <div class="mb-4">
            <div class="flex justify-between text-sm text-[var(--muted)] mb-2">
                <span>Team Members</span>
                <span>18 employees</span>
            </div>
            <div class="w-full h-2 rounded-full bg-[var(--chip-bg)] overflow-hidden">
                <div class="h-2 bg-purple-500 rounded-full" style="width: 60%"></div>
            </div>
        </div>
        
        <div class="flex gap-2">
            <button class="chip flex-1 text-center text-sm">View Team</button>
            <button class="chip flex-1 text-center text-sm">Manage</button>
        </div>
    </div>

    <!-- Finance & Accounting Department -->
    <div class="panel p-6">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-14 h-14 rounded-full border-2 border-[var(--border-color)] bg-gradient-to-r from-emerald-500 to-cyan-600 flex items-center justify-center text-white font-bold text-lg">
                    F
                </div>
                <div>
                    <h3 class="font-semibold text-lg logo-text">Finance & Accounting</h3>
                    <p class="text-[var(--muted)] text-sm">Financial Operations</p>
                </div>
            </div>
            <div class="chip text-xs px-3 py-1 bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30">21</div>
        </div>
        
        <div class="mb-4">
            <div class="flex justify-between text-sm text-[var(--muted)] mb-2">
                <span>Team Members</span>
                <span>21 employees</span>
            </div>
            <div class="w-full h-2 rounded-full bg-[var(--chip-bg)] overflow-hidden">
                <div class="h-2 bg-emerald-500 rounded-full" style="width: 68%"></div>
            </div>
        </div>
        
        <div class="flex gap-2">
            <button class="chip flex-1 text-center text-sm">View Team</button>
            <button class="chip flex-1 text-center text-sm">Manage</button>
        </div>
    </div>
    <!-- Media Department -->
    <div class="panel p-6">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-14 h-14 rounded-full border-2 border-[var(--border-color)] bg-gradient-to-r from-yellow-500 to-cyan-600 flex items-center justify-center text-white font-bold text-lg">
                    MD
                </div>
                <div>
                    <h3 class="font-semibold text-lg logo-text">Media</h3>
                    <p class="text-[var(--muted)] text-sm">Media Operations</p>
                </div>
            </div>
            <div class="chip text-xs px-3 py-1 bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30">21</div>
        </div>
        
        <div class="mb-4">
            <div class="flex justify-between text-sm text-[var(--muted)] mb-2">
                <span>Team Members</span>
                <span>21 employees</span>
            </div>
            <div class="w-full h-2 rounded-full bg-[var(--chip-bg)] overflow-hidden">
                <div class="h-2 bg-yellow-500 rounded-full" style="width: 68%"></div>
            </div>
        </div>
        
        <div class="flex gap-2">
            <button class="chip flex-1 text-center text-sm">View Team</button>
            <button class="chip flex-1 text-center text-sm">Manage</button>
        </div>
    </div>
</div>