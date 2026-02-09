<!-- Header -->
<div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold logo-text">Employee Directory</h1>
        <p class="text-[var(--muted)] mt-1">Manage and view all employees</p>
    </div>

    <div class="flex gap-3">
        <button onclick="openEmployeeModal()" class="chip flex items-center gap-2 bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Employee
        </button>

        <button onclick="openFilterModal()" class="chip flex items-center gap-2 hover:bg-[var(--hover-bg)] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
            </svg>
            Filter
            <span id="activeFilterCount" class="hidden bg-[var(--g-spring)] text-white text-xs rounded-full w-5 h-5 flex items-center justify-center ml-1">0</span>
        </button>
    </div>
</div>
<!-- Filter Modal -->
<div id="filterModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4 z-50" style="display: none;">
    <div class="panel w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold logo-text">Filter Employees</h3>
                <button type="button" onclick="closeFilterModal()" class="chip p-2 hover:bg-[var(--hover-bg)] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Filter Form -->
            <form id="filterForm" onsubmit="applyFilters(event)">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Name Filter -->
                    <div>
                        <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Name</label>
                        <div class="relative">
                            <input type="text" id="nameFilter" 
                                   class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]" 
                                   placeholder="Type to search employees...">
                        </div>
                    </div>

                    <!-- Employee ID Filter -->
                    <div>
                        <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Employee ID</label>
                        <div class="relative">
                            <input type="text" id="employeeIdFilter" 
                                   class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]" 
                                   placeholder="Type employee ID...">
                        </div>
                    </div>

                    <!-- Department Filter -->
                    <div>
                        <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Department</label>
                        <select id="departmentFilter" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                            <option value="">All Departments</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->name }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Profession Filter -->
                    <div>
                        <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Profession</label>
                        <select id="professionFilter" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                            <option value="">All Professions</option>
                            @foreach($professions as $profession)
                                <option value="{{ $profession->name }}">{{ $profession->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Employment Type Filter -->
                    <div>
                        <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Employment Type</label>
                        <select id="employmentTypeFilter" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                            <option value="">All Types</option>
                            <option value="full_time">Full Time</option>
                            <option value="part_time">Part Time</option>
                            <option value="contract">Contract</option>
                            <option value="internship">Internship</option>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Status</label>
                        <select id="statusFilter" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                            <option value="">All Statuses</option>
                            <option value="active">Active</option>
                            <option value="on_leave">On Leave</option>
                            <option value="terminated">Terminated</option>
                        </select>
                    </div>

                    <!-- Productivity Range -->
                    <div>
                        <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Productivity Range</label>
                        <div class="flex items-center gap-2">
                            <input type="number" id="minProductivity" min="0" max="100" 
                                   class="chip w-20 focus:ring-2 focus:ring-[var(--g-spring)]" 
                                   placeholder="Min">
                            <span class="text-[var(--muted)] text-sm">to</span>
                            <input type="number" id="maxProductivity" min="0" max="100" 
                                   class="chip w-20 focus:ring-2 focus:ring-[var(--g-spring)]" 
                                   placeholder="Max">
                            <span class="text-sm text-[var(--muted)]">%</span>
                        </div>
                    </div>
                </div>

                <!-- Active Filters Display -->
                <div id="activeFilters" class="hidden mb-6 p-4 bg-[var(--chip-bg)] rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-[var(--accent-text)]">Active Filters:</span>
                        <button type="button" onclick="clearAllFilters()" class="text-xs text-[var(--g-spring)] hover:underline">
                            Clear All
                        </button>
                    </div>
                    <div id="filterTags" class="flex flex-wrap gap-2">
                        <!-- Filter tags will appear here -->
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex gap-3 justify-end pt-4 border-t border-[var(--border-color)]">
                    <button type="button" onclick="clearAllFilters()" class="chip px-6 py-2 hover:bg-[var(--hover-bg)] transition-colors">
                        Clear All
                    </button>
                    <button type="submit" class="chip px-6 py-2 bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] transition-colors">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Results Count -->
<div id="resultsCount" class="mb-4 text-sm text-[var(--muted)] hidden rounded-lg p-2 border border-[var(--border-color)] width-fit">
    Showing <span id="visibleCount">0</span> of <span id="totalCount">0</span> employees
</div>

<!-- No Records Found Message -->
<div id="noRecordsMessage" class="hidden text-center py-12">
    <div class="flex flex-col items-center justify-center">
        <svg class="w-16 h-16 text-[var(--muted)] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <h3 class="text-lg font-semibold logo-text mb-2">No Employees Found</h3>
        <p class="text-[var(--muted)] text-sm">Try adjusting your filters or search criteria</p>
        <button type="button" onclick="clearAllFilters()" class="chip mt-4 px-6 py-2 bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] transition-colors">
            Clear All Filters
        </button>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="panel p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-[var(--muted)]">Total Employees</div>
            <div class="font-semibold text-xl" id="totalEmployeesCount">{{ $employees->count() }}</div>
        </div>
    </div>

    <div class="panel p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-[var(--muted)]">Active</div>
            <div class="font-semibold text-xl" id="activeEmployeesCount">{{ $employees->where('employee_status', 'active')->count() }}</div>
        </div>
    </div>

    <div class="panel p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-[var(--muted)]">Avg Productivity</div>
            <div class="font-semibold text-xl" id="avgProductivityCount">{{ round($employees->avg('productivity')) }}%</div>
        </div>
    </div>

    <div class="panel p-4 flex items-center gap-4">
        <div class="w-12 h-12 rounded-md bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </div>
        <div>
            <div class="text-sm text-[var(--muted)]">Departments</div>
            <div class="font-semibold text-xl" id="departmentsCount">{{ $employees->pluck('department')->unique()->count() }}</div>
        </div>
    </div>
</div>

<!-- Employee Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="employeeGrid">
    @foreach($employees as $employee)
    <div class="panel p-6 employee-card" data-employee-id="{{ $employee->employee_id }}" data-department="{{ $employee->department }}" data-profession="{{ $employee->profession }}" data-employment-type="{{ $employee->employment_type }}" data-status="{{ $employee->employee_status }}" data-productivity="{{ $employee->productivity }}">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
            <img src="{{ $employee->profile_photo_url }}" alt="{{ $employee->name }}" class="w-14 h-14 rounded-full border-2 border-[var(--border-color)]">
                <div>
                    <h3 class="font-semibold text-lg logo-text employee-name">{{ $employee->name }}</h3>
                    <p class="text-[var(--muted)] text-sm employee-profession">{{ $employee->profession }}</p>
                    <p class="text-xs text-[var(--muted)] mt-1 employee-id-department">{{ $employee->employee_id }} • {{ $employee->department }}</p>
                </div>
            </div>
            <div class="chip text-xs px-3 py-1 
                @if($employee->productivity >= 85) bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30
                @elseif($employee->productivity >= 70) bg-yellow-500/20 text-yellow-600 dark:text-yellow-400 border-yellow-500/30
                @else bg-red-500/20 text-red-600 dark:text-red-400 border-red-500/30
                @endif employee-productivity">
                {{ $employee->productivity }}%
            </div>
        </div>
        
        <div class="mb-4">
            <div class="flex justify-between text-sm text-[var(--muted)] mb-2">
                <span>Productivity</span>
                <span>{{ $employee->productivity }}%</span>
            </div>
            <div class="w-full h-2 rounded-full bg-[var(--chip-bg)] overflow-hidden">
                <div class="h-2 
                    @if($employee->productivity >= 85) bg-green-500
                    @elseif($employee->productivity >= 70) bg-yellow-500
                    @else bg-red-500
                    @endif rounded-full" 
                    style="width: {{ $employee->productivity }}%">
                </div>
            </div>
        </div>
        
        <div class="flex gap-2">
                <a href="{{ route('admin.employees.profile', $employee) }}" class="chip flex-1 text-center text-sm hover:bg-[var(--hover-bg)] transition-colors" onclick="event.stopPropagation();">
                 View Profile
             </a>
            <button class="chip flex-1 text-center text-sm">Message</button>
        </div>
    </div>
    @endforeach
</div>

<!-- Add Employee Modal -->
<div id="employeeModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4 z-50" style="display: none;">
    <div class="panel w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold logo-text">Add New Employee</h3>
                <button type="button" onclick="closeEmployeeModal()" class="chip p-2 hover:bg-[var(--hover-bg)] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Info Note -->
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-sm text-blue-700">
                            Add basic employee information here. Additional details like National ID, Marital Status, 
                            Bank Information, Documents, and Performance KPIs can be added later in the employee's profile.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form id="employeeForm" method="POST" action="{{ route('admin.employees.store') }}" enctype="multipart/form-data" onsubmit="handleFormSubmit(event)">
                @csrf
                
                <!-- Hidden is_active field -->
                <input type="hidden" name="is_active" value="1">
                <input type="hidden" name="employee_status" value="active">
                
                <!-- Personal Information - 3 columns -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="space-y-4">
                        <h4 class="font-semibold text-[var(--muted)] mb-3">Personal Information</h4>
                        
                        <div>
                            <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]" placeholder="Enter full name">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="email" required class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]" placeholder="employee@example.com">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Phone Number <span class="text-red-500">*</span></label>
                            <input type="tel" name="phone" required class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]" placeholder="+255 XXX XXX XXX">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="font-semibold text-[var(--muted)] mb-3">&nbsp;</h4>
                        
                        <div>
                            <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Gender</label>
                            <select name="gender" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Employee ID <span class="text-red-500">*</span></label>
                            <input type="text" id="employee_id" name="employee_id" required 
                                   class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)] bg-[var(--chip-bg)] cursor-not-allowed" 
                                   placeholder="Auto-generated after selecting department"
                                   readonly>
                            <p class="text-xs text-[var(--muted)] mt-1">Automatically generated based on department</p>
                        </div>
                    </div>

                    <!-- Employment Information -->
                    <div class="space-y-4">
                        <h4 class="font-semibold text-[var(--muted)] mb-3">Employment Information</h4>

                        <div>
                            <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Department <span class="text-red-500">*</span></label>
                            <select name="department" id="departmentSelect" required class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->name }}" data-id="{{ $department->id }}" data-code="{{ $department->code ?? substr($department->name, 0, 3) }}">
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Profession <span class="text-red-500">*</span></label>
                            <select name="profession" id="professionSelect" required class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                                <option value="">Select Department First</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Employment Type</label>
                            <select name="employment_type" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                                <option value="full_time">Full Time</option>
                                <option value="part_time">Part Time</option>
                                <option value="contract">Contract</option>
                                <option value="internship">Internship</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Additional Information - 3 columns -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="space-y-4">
                        <h4 class="font-semibold text-[var(--muted)] mb-3">Additional Information</h4>
                        
                        <div>
                            <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Join Date</label>
                            <input type="date" name="join_date" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Basic Salary</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" name="salary" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]" placeholder="Amount">
                                <select name="salary_currency" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                                    <option value="TZS">TZS</option>
                                    <option value="USD">USD</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Emergency Contact</label>
                            <input type="text" name="emergency_contact" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]" placeholder="Contact name & phone">
                        </div>
                    </div>

                    <div class="space-y-4 md:col-span-2">
                        <h4 class="font-semibold text-[var(--muted)] mb-3">&nbsp;</h4>
                        
                        <div>
                            <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Address</label>
                            <textarea name="address" rows="3" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]" placeholder="Enter full address"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Notes</label>
                            <textarea name="notes" rows="2" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]" placeholder="Additional notes (optional)"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex gap-3 justify-end pt-4 border-t border-[var(--border-color)]">
                    <button type="button" onclick="closeEmployeeModal()" class="chip px-6 py-2 hover:bg-[var(--hover-bg)] transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="chip px-6 py-2 bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] transition-colors">
                        <span id="submitBtnText">Add Employee</span>
                        <span id="submitBtnLoader" class="hidden">
                            <svg class="animate-spin h-5 w-5 inline" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Make routes available to employee.js
    window.employeeIndexRoute = '{{ route("admin.employees.index") }}';
    // URL for generating employee IDs (admin-scoped)
    window.generateEmployeeIdUrl = '{{ url("/admin/employees/generate-id") }}';
    
    // ==================== DATABASE-DRIVEN DEPARTMENT & PROFESSION DATA ====================
    @php
        $professionsByDepartment = [];
        foreach($departments as $dept) {
            $professionsByDepartment[$dept->id] = [];
            foreach($professions as $prof) {
                if($prof->department_id == $dept->id) {
                    $professionsByDepartment[$dept->id][] = [
                        'name' => $prof->name,
                        'id' => $prof->id
                    ];
                }
            }
        }
    @endphp
    
    // Pass database data to employee.js BEFORE it loads
    var professionsByDepartmentId = @json($professionsByDepartment);
    console.log('✅ Professions by Department ID ready:', professionsByDepartmentId);
</script>
<script src="{{ asset('js/employee.js') }}"></script>
