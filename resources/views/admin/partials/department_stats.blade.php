<!-- Department List Header -->
<div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-[var(--text-color)] mb-2">Department Management</h1>
        <p class="text-sm text-[var(--muted)]">Manage and view all departments in your organization</p>
    </div>
    <div class="flex gap-3">
        <button type="button" id="openDepartmentModal" 
                class="chip flex items-center gap-2 bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] transition-colors px-4 py-2.5 text-sm sm:text-base">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Department
        </button>
        
        <!-- Filter Button -->
        <div class="relative">
            <button type="button" id="filterBtn" 
                    class="chip flex items-center gap-2 hover:bg-[var(--hover-bg)] transition-colors px-4 py-2.5 text-sm sm:text-base">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
                </svg>
                Filter
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <!-- Filter Dropdown -->
            <div id="filterDropdown" class="absolute right-0 mt-2 w-64 panel rounded-lg shadow-lg z-50 hidden">
                <div class="p-4">
                    <h3 class="text-sm font-semibold text-[var(--text-color)] mb-3">Filter Departments</h3>

                    <!-- Search -->
                    <div class="mb-4">
                        <label class="block text-xs font-medium text-[var(--accent-text)] mb-2">Search</label>
                        <input type="text" id="searchInput" placeholder="Search departments..."
                               class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)] text-sm">
                    </div>

                    <!-- Status Filter -->
                    <div class="mb-4">
                        <label class="block text-xs font-medium text-[var(--accent-text)] mb-2">Status</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" id="filterActive" class="mr-2" checked>
                                <span class="text-xs text-[var(--text-color)]">Active</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" id="filterInactive" class="mr-2" checked>
                                <span class="text-xs text-[var(--text-color)]">Inactive</span>
                            </label>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2 pt-3 border-t border-[var(--border-color)]">
                        <button type="button" id="clearFilters" 
                                class="chip hover:bg-[var(--hover-bg)] flex-1 transition-colors text-sm px-3 py-2">
                            Clear
                        </button>
                        <button type="button" id="applyFilters" 
                                class="chip bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] flex-1 transition-colors text-sm px-3 py-2">
                            Apply
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Department Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="panel p-5">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div>
                <div class="text-sm text-[var(--muted)]">Total Departments</div>
                <div class="font-bold text-2xl text-[var(--text-color)]">{{ $stats['total_departments'] ?? 0 }}</div>
            </div>
        </div>
    </div>

    <div class="panel p-5">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-sm text-[var(--muted)]">Total Employees</div>
                <div class="font-bold text-2xl text-[var(--text-color)]">{{ $stats['total_employees'] ?? 0 }}</div>
            </div>
        </div>
    </div>

    <div class="panel p-5">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-sm text-[var(--muted)]">Active Teams</div>
                <div class="font-bold text-2xl text-[var(--text-color)]">{{ $stats['active_teams'] ?? 0 }}</div>
            </div>
        </div>
    </div>

    <div class="panel p-5">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-sm text-[var(--muted)]">Avg Team Size</div>
                <div class="font-bold text-2xl text-[var(--text-color)]">{{ number_format($stats['avg_team_size'] ?? 0, 1) }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Department Grid -->
@if($departments && $departments->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 department-grid">
    @foreach($departments as $department)
    @php
        $percentage = min(100, ($department->employee_count / 40) * 100);
    @endphp
    
    <div class="department-card panel p-5 hover:shadow-md transition-all duration-200 border border-[var(--border-color)]" 
         data-name="{{ strtolower($department->name) }}"
         data-status="{{ $department->is_active ? 'active' : 'inactive' }}">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full border-2 border-[var(--border-color)] bg-gradient-to-r {{ $department->color_scheme ?? 'from-gray-500 to-gray-600' }} flex items-center justify-center text-white font-bold text-base">
                    {{ $department->initial ?? substr($department->name, 0, 2) }}
                </div>
                <div>
                    <h3 class="font-semibold text-base text-[var(--text-color)]">{{ $department->name }}</h3>
                    <p class="text-xs text-[var(--muted)] mt-1">{{ $department->team_function ?? 'Department Team' }}</p>
                </div>
            </div>
            <span class="chip text-xs {{ $department->is_active ? 'bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30' : 'bg-red-500/20 text-red-600 dark:text-red-400 border-red-500/30' }}">
                {{ $department->is_active ? 'Active' : 'Inactive' }}
            </span>
        </div>
        
        <!-- Professions Preview -->
        @if($department->professions && $department->professions->count() > 0)
        <div class="mb-4">
            <div class="text-xs text-[var(--muted)] mb-2">Key Professions</div>
            <div class="flex flex-wrap gap-2">
                @foreach($department->professions->take(3) as $profession)
                <span class="chip text-xs px-2 py-1">
                    {{ $profession->name }}
                </span>
                @endforeach
                @if($department->professions->count() > 3)
                <span class="chip text-xs px-2 py-1 text-[var(--muted)]">
                    +{{ $department->professions->count() - 3 }} more
                </span>
                @endif
            </div>
        </div>
        @endif
        
        <!-- Team Size -->
        <div class="mb-4">
            <div class="flex justify-between text-xs text-[var(--muted)] mb-2">
                <span>Team Members</span>
                <span>{{ $department->employee_count }} employees</span>
            </div>
            <div class="w-full h-1.5 rounded-full bg-[var(--chip-bg)] overflow-hidden">
                <div class="h-1.5 bg-gradient-to-r {{ $department->color_scheme ?? 'from-gray-500 to-gray-600' }} rounded-full" style="width: {{ $percentage }}%"></div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="flex gap-2 pt-3 border-t border-[var(--border-color)]">
            <a href="{{ route('admin.departments.show', $department) }}" 
               class="chip hover:bg-[var(--hover-bg)] flex-1 transition-colors text-sm text-center py-2">
                View Details
            </a>
            <a href="{{ route('admin.departments.edit', $department) }}" 
               class="chip bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] flex-1 transition-colors text-sm text-center py-2">
                Manage
            </a>
        </div>
    </div>
    @endforeach
</div>
@else
<!-- Empty State -->
<div class="panel p-12 text-center">
    <div class="max-w-md mx-auto">
        <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-[var(--chip-bg)] flex items-center justify-center">
            <svg class="w-10 h-10 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </div>
        <h3 class="text-xl font-semibold text-[var(--text-color)] mb-3">No Departments Yet</h3>
        <p class="text-sm text-[var(--muted)] mb-6">Get started by creating your first department. Departments help organize your team and assign professions.</p>
        <button type="button" id="openDepartmentModalFromEmpty" 
                class="chip flex items-center gap-2 bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] transition-colors mx-auto px-4 py-2.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Create First Department
        </button>
    </div>
</div>
@endif

<!-- Add Department Modal - Fixed to appear in the center -->
<div id="departmentModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" id="modalBackdrop"></div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal panel -->
        <div class="inline-block w-full max-w-2xl my-8 overflow-hidden text-left align-bottom transition-all transform panel sm:my-8 sm:align-middle">
            <div class="p-6">
                <h3 class="text-xl font-bold text-[var(--text-color)] mb-4" id="modal-title">Add New Department</h3>
                <form id="departmentForm" method="POST" action="{{ route('admin.departments.store') }}">
                    @csrf
                    <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-2">
                        <!-- Department Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Department Name *</label>
                                <input type="text" name="name" required 
                                       class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]"
                                       placeholder="e.g., Sales">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Department Code *</label>
                                <input type="text" name="code" required 
                                       class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]"
                                       placeholder="e.g., SAL" maxlength="10">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Initial</label>
                                <input type="text" name="initial" 
                                       class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]"
                                       placeholder="e.g., S" maxlength="2">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Color Scheme</label>
                                <select name="color_scheme" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                                    <option value="">Default</option>
                                    <option value="from-blue-500 to-purple-600">Blue to Purple</option>
                                    <option value="from-green-500 to-teal-600">Green to Teal</option>
                                    <option value="from-orange-500 to-red-600">Orange to Red</option>
                                    <option value="from-purple-500 to-pink-600">Purple to Pink</option>
                                    <option value="from-emerald-500 to-cyan-600">Emerald to Cyan</option>
                                    <option value="from-yellow-500 to-cyan-600">Yellow to Cyan</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Team Function</label>
                                <input type="text" name="team_function" 
                                       class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]"
                                       placeholder="e.g., Revenue Generation Team">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Employee Count</label>
                                <input type="number" name="employee_count" 
                                       class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]"
                                       min="0" value="0">
                            </div>
                        </div>
                        
                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Description</label>
                            <textarea name="description" rows="3" 
                                      class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]"
                                      placeholder="Describe the department's purpose, responsibilities, and objectives..."></textarea>
                        </div>
                        
                        <!-- Professions Section -->
                        <div class="pt-2">
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="text-sm font-medium text-[var(--accent-text)]">Professions</h4>
                                <button type="button" id="addProfessionBtn" 
                                        class="chip flex items-center gap-1 bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] transition-colors text-xs px-3 py-1.5">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Add Profession
                                </button>
                            </div>
                            
                            <div id="professionsContainer" class="space-y-3">
                                <!-- Default profession field -->
                                <div class="profession-item p-3 border border-[var(--border-color)] rounded-lg bg-[var(--chip-bg)]">
                                    <div class="flex gap-3">
                                        <div class="flex-1">
                                            <input type="text" name="professions[0][name]" 
                                                   class="chip w-full mb-2 focus:ring-2 focus:ring-[var(--g-spring)]"
                                                   placeholder="Profession Title (e.g., Sales Manager)"
                                                   required>
                                            <textarea name="professions[0][description]" 
                                                      class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]"
                                                      placeholder="Profession description (optional)..."
                                                      rows="2"></textarea>
                                        </div>
                                        <button type="button" class="remove-profession text-red-500 hover:text-red-700 mt-2 opacity-50 cursor-not-allowed" disabled>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class="flex gap-3 justify-end mt-6 pt-4 border-t border-[var(--border-color)]">
                        <button type="button" id="cancelForm" 
                                class="chip px-6 py-2 hover:bg-[var(--hover-bg)] transition-colors text-sm">
                            Cancel
                        </button>
                        <button type="submit" id="submitBtn" 
                                class="chip px-6 py-2 bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] transition-colors text-sm">
                            <span id="submitText">Create Department</span>
                            <span id="loadingSpinner" class="hidden ml-2">
                                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
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
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal elements
    const modal = document.getElementById('departmentModal');
    const modalBackdrop = document.getElementById('modalBackdrop');
    const openModalBtn = document.getElementById('openDepartmentModal');
    const openModalEmptyBtn = document.getElementById('openDepartmentModalFromEmpty');
    const cancelFormBtn = document.getElementById('cancelForm');
    
    // Filter elements
    const filterBtn = document.getElementById('filterBtn');
    const filterDropdown = document.getElementById('filterDropdown');
    const searchInput = document.getElementById('searchInput');
    const filterActive = document.getElementById('filterActive');
    const filterInactive = document.getElementById('filterInactive');
    const clearFilters = document.getElementById('clearFilters');
    const applyFilters = document.getElementById('applyFilters');
    
    // Profession management
    const addProfessionBtn = document.getElementById('addProfessionBtn');
    const professionsContainer = document.getElementById('professionsContainer');
    let professionIndex = 1;
    
    // Form elements
    const departmentForm = document.getElementById('departmentForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const loadingSpinner = document.getElementById('loadingSpinner');
    
    // Open modal function
    function openModal() {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    
    // Close modal function
    function closeModal() {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    
    // Event listeners for opening modal
    if (openModalBtn) openModalBtn.addEventListener('click', openModal);
    if (openModalEmptyBtn) openModalEmptyBtn.addEventListener('click', openModal);
    
    // Event listeners for closing modal
    if (cancelFormBtn) cancelFormBtn.addEventListener('click', closeModal);
    if (modalBackdrop) modalBackdrop.addEventListener('click', closeModal);
    
    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
    
    // Filter functionality
    if (filterBtn && filterDropdown) {
        filterBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            filterDropdown.classList.toggle('hidden');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!filterBtn.contains(e.target) && !filterDropdown.contains(e.target)) {
                filterDropdown.classList.add('hidden');
            }
        });
        
        // Apply filters
        if (applyFilters) {
            applyFilters.addEventListener('click', function() {
                applyDepartmentFilters();
                filterDropdown.classList.add('hidden');
            });
        }
        
        // Clear filters
        if (clearFilters) {
            clearFilters.addEventListener('click', function() {
                searchInput.value = '';
                filterActive.checked = true;
                filterInactive.checked = true;
                applyDepartmentFilters();
                filterDropdown.classList.add('hidden');
            });
        }
        
        // Real-time search
        if (searchInput) {
            searchInput.addEventListener('input', applyDepartmentFilters);
        }
        
        // Status filter changes
        if (filterActive) filterActive.addEventListener('change', applyDepartmentFilters);
        if (filterInactive) filterInactive.addEventListener('change', applyDepartmentFilters);
    }
    
    // Filter function - FIXED
    function applyDepartmentFilters() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const showActive = filterActive ? filterActive.checked : true;
        const showInactive = filterInactive ? filterInactive.checked : true;
        
        const departmentCards = document.querySelectorAll('.department-card');
        
        departmentCards.forEach(card => {
            const departmentName = card.getAttribute('data-name') || '';
            const departmentStatus = card.getAttribute('data-status') || 'active';
            
            // Check if matches search
            const matchesSearch = !searchTerm || departmentName.includes(searchTerm.toLowerCase());
            
            // Check if matches status filter
            let matchesStatus = false;
            if (departmentStatus === 'active' && showActive) {
                matchesStatus = true;
            }
            if (departmentStatus === 'inactive' && showInactive) {
                matchesStatus = true;
            }
            
            // Show/hide card based on filters
            if (matchesSearch && matchesStatus) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
    
    // Add profession field
    if (addProfessionBtn) {
        addProfessionBtn.addEventListener('click', function() {
            const professionItem = createProfessionField(professionIndex);
            professionsContainer.appendChild(professionItem);
            
            // Enable remove button on the first profession if there are multiple
            if (professionIndex === 1) {
                const firstRemoveBtn = professionsContainer.querySelector('.profession-item:first-child .remove-profession');
                if (firstRemoveBtn) {
                    firstRemoveBtn.disabled = false;
                    firstRemoveBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
            
            professionIndex++;
        });
    }
    
    // Create profession field HTML
    function createProfessionField(index) {
        const professionItem = document.createElement('div');
        professionItem.className = 'profession-item p-3 border border-[var(--border-color)] rounded-lg bg-[var(--chip-bg)]';
        professionItem.innerHTML = `
            <div class="flex gap-3">
                <div class="flex-1">
                    <input type="text" name="professions[${index}][name]" 
                           class="chip w-full mb-2 focus:ring-2 focus:ring-[var(--g-spring)]"
                           placeholder="Profession Title (e.g., Sales Manager)"
                           required>
                    <textarea name="professions[${index}][description]" 
                              class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]"
                              placeholder="Profession description (optional)..."
                              rows="2"></textarea>
                </div>
                <button type="button" class="remove-profession text-red-500 hover:text-red-700 mt-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </div>
        `;
        return professionItem;
    }
    
    // Remove profession field
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-profession')) {
            const professionItem = e.target.closest('.profession-item');
            if (professionItem) {
                const professionItems = professionsContainer.querySelectorAll('.profession-item');
                if (professionItems.length > 1) {
                    professionItem.remove();
                    
                    // Disable remove button on the first profession if only one remains
                    if (professionItems.length === 2) { // One will be removed, leaving 1
                        const firstRemoveBtn = professionsContainer.querySelector('.profession-item:first-child .remove-profession');
                        if (firstRemoveBtn) {
                            firstRemoveBtn.disabled = true;
                            firstRemoveBtn.classList.add('opacity-50', 'cursor-not-allowed');
                        }
                    }
                    
                    // Renumber remaining profession fields
                    renumberProfessionFields();
                }
            }
        }
    });
    
    // Renumber profession fields after removal
    function renumberProfessionFields() {
        const professionItems = professionsContainer.querySelectorAll('.profession-item');
        professionItems.forEach((item, index) => {
            const nameInput = item.querySelector('input[name^="professions"]');
            const descTextarea = item.querySelector('textarea[name^="professions"]');
            
            if (nameInput && descTextarea) {
                nameInput.name = `professions[${index}][name]`;
                descTextarea.name = `professions[${index}][description]`;
            }
        });
        professionIndex = professionItems.length;
    }
    
    // Auto-generate initial from name
    const nameInput = document.querySelector('input[name="name"]');
    const initialInput = document.querySelector('input[name="initial"]');
    
    if (nameInput && initialInput) {
        nameInput.addEventListener('input', function(e) {
            if (!initialInput.value && e.target.value.trim()) {
                initialInput.value = e.target.value.substring(0, 2).toUpperCase();
            }
        });
    }
    
    // Form submission with AJAX
    if (departmentForm) {
        departmentForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Show loading state
            submitText.classList.add('hidden');
            loadingSpinner.classList.remove('hidden');
            submitBtn.disabled = true;
            
            try {
                const formData = new FormData(this);
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData
                });
                
                const data = await response.json();
                
                if (response.ok && data.success) {
                    // Close modal and reload page
                    closeModal();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    alert(data.message || 'An error occurred');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            } finally {
                // Reset loading state
                submitText.classList.remove('hidden');
                loadingSpinner.classList.add('hidden');
                submitBtn.disabled = false;
            }
        });
    }
});
</script>
@endpush