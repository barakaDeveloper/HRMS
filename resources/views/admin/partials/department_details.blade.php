
<!-- Department Details Content -->
<div class="p-4 sm:p-6">

    <!-- Header -->
    <div class="panel p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 sm:gap-6">
            <!-- Profile Info Section -->
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full border-4 border-[var(--border-color)] bg-gradient-to-r {{ $department->color_scheme ?? 'from-gray-500 to-gray-600' }} flex items-center justify-center text-white font-bold text-xl flex-shrink-0">
                    {{ $department->initial ?? strtoupper(substr($department->name, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl sm:text-3xl font-bold logo-text truncate">{{ $department->name }}</h1>
                    <p class="text-[var(--muted)] text-base">{{ $department->team_function ?? 'Department Team' }}</p>
                    <!-- Status Chips -->
                    <div class="flex flex-wrap items-center gap-2 mt-3">
                        <span class="chip text-xs sm:text-sm whitespace-nowrap
                            @if($department->is_active) bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30
                            @else bg-red-500/20 text-red-600 dark:text-red-400 border-red-500/30
                            @endif">
                            {{ $department->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <span class="chip text-xs sm:text-sm whitespace-nowrap">{{ $department->code }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 md:flex-shrink-0">
                <a href="{{ route('admin.departments.index') }}" class="chip flex items-center justify-center gap-2 hover:bg-[var(--hover-bg)] transition-colors whitespace-nowrap px-4 py-2.5 sm:py-2 text-sm sm:text-base">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Departments
                </a>
                <a href="{{ route('admin.departments.edit', $department) }}"
                   class="chip flex items-center justify-center gap-2 bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] transition-colors whitespace-nowrap px-4 py-2.5 sm:py-2 text-sm sm:text-base">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Department
                </a>
            </div>
        </div>
    </div>

    <!-- Department Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="panel p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-medium text-[var(--muted)]">Team Members</div>
                    <div class="font-bold text-2xl logo-text">{{ $department->actual_employee_count ?? 0 }}</div>
                </div>
            </div>
        </div>

        <div class="panel p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-medium text-[var(--muted)]">Status</div>
                    <div class="font-bold text-2xl">
                        <span class="chip text-sm whitespace-nowrap
                            @if($department->is_active) bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30
                            @else bg-red-500/20 text-red-600 dark:text-red-400 border-red-500/30
                            @endif">
                            {{ $department->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-medium text-[var(--muted)]">Professions</div>
                    <div class="font-bold text-2xl logo-text">{{ $department->professions->count() }}</div>
                </div>
            </div>
        </div>

        <div class="panel p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-[var(--chip-bg)] flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10m0 0l-2-2m2 2l2-2m6-6v6m0 0l2 2m-2-2l-2 2"/>
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-medium text-[var(--muted)]">Department Code</div>
                    <div class="font-bold text-2xl logo-text">{{ $department->code }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Department Details (Left Column) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Description -->
            @if($department->description)
            <div class="panel p-6">
                <h3 class="text-lg font-semibold mb-4 logo-text">About This Department</h3>
                <p class="text-[var(--muted)] leading-relaxed">{{ $department->description }}</p>
            </div>
            @endif

            <!-- Professions -->
            <div class="panel p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold logo-text">Department Professions</h3>
                    <button type="button" class="chip flex items-center justify-center gap-2 bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] transition-colors whitespace-nowrap px-4 py-2.5 text-sm sm:text-base"
                            onclick="openAddProfessionModal({{ $department->id }})">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Profession
                    </button>
                </div>

                @if($department->professions && $department->professions->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($department->professions as $profession)
                    <div class="panel p-4 hover:shadow-md transition-all duration-200">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="font-semibold logo-text mb-2">{{ $profession->name }}</h4>
                                @if($profession->description)
                                <p class="text-sm text-[var(--muted)] leading-relaxed">{{ $profession->description }}</p>
                                @endif
                            </div>
                            <div class="flex gap-2 ml-4">
                                <button type="button" class="chip p-2 hover:bg-[var(--chip-bg)] transition-colors"
                                        onclick="editProfession({{ $profession->id }}, '{{ addslashes($profession->name) }}', '{{ addslashes($profession->description ?? '') }}')"
                                        title="Edit profession">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button type="button" class="chip p-2 hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/30 dark:hover:text-red-400 transition-colors"
                                        onclick="deleteProfession({{ $profession->id }}, '{{ addslashes($profession->name) }}')"
                                        title="Delete profession">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-[var(--muted)] mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <h4 class="text-lg font-semibold mb-2 logo-text">No Professions Yet</h4>
                    <p class="text-[var(--muted)] mb-6">Add professions to define roles within this department.</p>
                    <button type="button" class="chip flex items-center justify-center gap-2 bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] transition-colors whitespace-nowrap px-6 py-3 text-sm sm:text-base mx-auto"
                            onclick="openAddProfessionModal({{ $department->id }})">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add First Profession
                    </button>
                </div>
                @endif
            </div>
        </div>

        <!-- Department Information (Right Column) -->
        <div class="space-y-6">
            <!-- Department Info -->
            <div class="panel p-6">
                <h3 class="text-lg font-semibold mb-6 logo-text">Department Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-[var(--muted)] mb-1">Department Code</label>
                        <p class="chip bg-transparent border-none p-0">{{ $department->code }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[var(--muted)] mb-1">Initial</label>
                        <p class="chip bg-transparent border-none p-0">{{ $department->initial ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[var(--muted)] mb-1">Color Scheme</label>
                        <div class="flex items-center gap-2">
                            <div class="w-4 h-4 rounded bg-gradient-to-r {{ $department->color_scheme ?? 'from-gray-500 to-gray-600' }}"></div>
                            <span class="chip bg-transparent border-none p-0">{{ $department->color_scheme ? 'Custom' : 'Default' }}</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[var(--muted)] mb-1">Status</label>
                        <span class="chip text-xs sm:text-sm whitespace-nowrap
                            @if($department->is_active) bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30
                            @else bg-red-500/20 text-red-600 dark:text-red-400 border-red-500/30
                            @endif">
                            {{ $department->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[var(--muted)] mb-1">Created</label>
                        <p class="chip bg-transparent border-none p-0">{{ $department->created_at ? $department->created_at->format('M d, Y') : 'N/A' }}</p>
                    </div>
                    @if($department->updated_at && $department->updated_at != $department->created_at)
                    <div>
                        <label class="block text-sm font-medium text-[var(--muted)] mb-1">Last Updated</label>
                        <p class="chip bg-transparent border-none p-0">{{ $department->updated_at->format('M d, Y') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Team Capacity -->
            <div class="panel p-6">
                <h3 class="text-lg font-semibold mb-4 logo-text">Team Capacity</h3>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm mb-2 text-[var(--muted)]">
                            <span>Current Team Size</span>
                            <span>{{ $department->actual_employee_count ?? 0 }}/40</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-[var(--chip-bg)] overflow-hidden">
                            @php
                                $percentage = min(100, (($department->actual_employee_count ?? 0) / 40) * 100);
                            @endphp
                            <div class="h-2 bg-gradient-to-r {{ $department->color_scheme ?? 'from-gray-500 to-gray-600' }} rounded-full transition-all duration-300" 
                                 style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                    <div class="text-center pt-2">
                        <div class="text-2xl font-bold logo-text">{{ number_format($percentage, 1) }}%</div>
                        <div class="text-sm text-[var(--muted)]">Capacity Utilized</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Profession Modal -->
<div id="professionModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="profession-modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black bg-opacity-50" id="professionModalBackdrop" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block w-full max-w-md my-8 overflow-hidden text-left align-bottom transition-all transform sm:my-8 sm:align-middle">
            <div class="panel">
                <div class="p-6">
                    <h3 class="text-xl font-bold logo-text mb-4" id="profession-modal-title">Add Profession</h3>
                    <form id="professionForm" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="profession_name" class="block text-sm font-medium text-[var(--accent-text)] mb-2">Profession Name *</label>
                                <input type="text" 
                                       id="profession_name" 
                                       name="name" 
                                       required 
                                       class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]"
                                       placeholder="e.g., Sales Executive">
                            </div>
                            <div>
                                <label for="profession_description" class="block text-sm font-medium text-[var(--accent-text)] mb-2">Description</label>
                                <textarea id="profession_description" 
                                          name="description" 
                                          rows="3" 
                                          class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]"
                                          placeholder="Describe the role responsibilities..."></textarea>
                            </div>
                        </div>
                        <div class="flex gap-3 justify-end mt-6 pt-4 border-t border-[var(--border-color)]">
                            <button type="button" 
                                    id="cancelProfessionForm" 
                                    class="chip px-6 py-2 hover:bg-[var(--hover-bg)] transition-colors">
                                Cancel
                            </button>
                            <button type="submit" 
                                    id="submitProfessionBtn" 
                                    class="chip px-6 py-2 bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] transition-colors">
                                <span id="professionSubmitText">Add Profession</span>
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
</div>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentProfessionId = null;
    let currentDepartmentId = {{ $department->id }};

    // Modal functions
    window.openAddProfessionModal = function(departmentId) {
        currentProfessionId = null;
        currentDepartmentId = departmentId;
        
        const form = document.getElementById('professionForm');
        form.action = `/admin/departments/${departmentId}/professions`;
        form.reset();
        
        // Remove any existing method override
        const existingMethod = form.querySelector('input[name="_method"]');
        if (existingMethod) existingMethod.remove();
        
        document.getElementById('profession-modal-title').textContent = 'Add Profession';
        document.getElementById('professionSubmitText').textContent = 'Add Profession';
        document.getElementById('professionModal').classList.remove('hidden');
        document.getElementById('profession_name').focus();
    };

    window.editProfession = function(id, name, description) {
        currentProfessionId = id;
        
        const form = document.getElementById('professionForm');
        form.action = `/admin/departments/${currentDepartmentId}/professions/${id}`;
        
        // Add PUT method override
        const existingMethod = form.querySelector('input[name="_method"]');
        if (existingMethod) existingMethod.remove();
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);
        
        document.getElementById('profession_name').value = name;
        document.getElementById('profession_description').value = description;
        document.getElementById('profession-modal-title').textContent = 'Edit Profession';
        document.getElementById('professionSubmitText').textContent = 'Update Profession';
        document.getElementById('professionModal').classList.remove('hidden');
        document.getElementById('profession_name').focus();
    };

    window.deleteProfession = async function(id, name) {
        const result = await Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete the profession "${name}". This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            customClass: {
                container: 'dark:bg-gray-800 dark:text-white',
                popup: 'dark:bg-gray-800 dark:text-white border dark:border-gray-700',
                title: 'dark:text-white',
                htmlContainer: 'dark:text-gray-300',
                confirmButton: 'dark:bg-red-600 dark:hover:bg-red-700',
                cancelButton: 'dark:bg-gray-600 dark:hover:bg-gray-700'
            }
        });
        
        if (result.isConfirmed) {
            try {
                // Show loading
                Swal.fire({
                    title: 'Deleting...',
                    text: 'Please wait while we delete the profession.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    customClass: {
                        container: 'dark:bg-gray-800 dark:text-white',
                        popup: 'dark:bg-gray-800 dark:text-white border dark:border-gray-700',
                        title: 'dark:text-white'
                    }
                });
                
                const response = await fetch(`/admin/departments/${currentDepartmentId}/professions/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Profession has been deleted successfully.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        customClass: {
                            container: 'dark:bg-gray-800 dark:text-white',
                            popup: 'dark:bg-gray-800 dark:text-white border dark:border-gray-700',
                            title: 'dark:text-white'
                        }
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message || 'Failed to delete profession.',
                        icon: 'error',
                        customClass: {
                            container: 'dark:bg-gray-800 dark:text-white',
                            popup: 'dark:bg-gray-800 dark:text-white border dark:border-gray-700',
                            title: 'dark:text-white'
                        }
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'An unexpected error occurred. Please try again.',
                    icon: 'error',
                    customClass: {
                        container: 'dark:bg-gray-800 dark:text-white',
                        popup: 'dark:bg-gray-800 dark:text-white border dark:border-gray-700',
                        title: 'dark:text-white'
                    }
                });
            }
        }
    };

    // Close modal when clicking backdrop
    document.getElementById('professionModalBackdrop').addEventListener('click', function() {
        document.getElementById('professionModal').classList.add('hidden');
    });

    // Close modal when clicking cancel
    document.getElementById('cancelProfessionForm').addEventListener('click', function() {
        document.getElementById('professionModal').classList.add('hidden');
    });

    // Form submission with AJAX
    document.getElementById('professionForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const form = this;
        const submitBtn = document.getElementById('submitProfessionBtn');
        const submitText = document.getElementById('professionSubmitText');
        const loadingSpinner = document.getElementById('loadingSpinner');
        
        const originalText = submitText.textContent;
        submitText.classList.add('hidden');
        loadingSpinner.classList.remove('hidden');
        submitBtn.disabled = true;
        
        try {
            const formData = new FormData(form);
            
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                Swal.fire({
                    title: 'Success!',
                    text: data.message || 'Profession saved successfully!',
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                    customClass: {
                        container: 'dark:bg-gray-800 dark:text-white',
                        popup: 'dark:bg-gray-800 dark:text-white border dark:border-gray-700',
                        title: 'dark:text-white'
                    }
                }).then(() => {
                    location.reload();
                });
            } else {
                let errorMessage = data.message || 'An error occurred while saving the profession.';
                
                if (data.errors) {
                    errorMessage = Object.values(data.errors).flat().join('\n');
                }
                
                Swal.fire({
                    title: 'Error!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK',
                    customClass: {
                        container: 'dark:bg-gray-800 dark:text-white',
                        popup: 'dark:bg-gray-800 dark:text-white border dark:border-gray-700',
                        title: 'dark:text-white'
                    }
                });
                
                submitText.textContent = originalText;
                submitText.classList.remove('hidden');
                loadingSpinner.classList.add('hidden');
                submitBtn.disabled = false;
            }
        } catch (error) {
            console.error('Error:', error);
            
            Swal.fire({
                title: 'Error!',
                text: 'An unexpected error occurred. Please try again.',
                icon: 'error',
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK',
                customClass: {
                    container: 'dark:bg-gray-800 dark:text-white',
                    popup: 'dark:bg-gray-800 dark:text-white border dark:border-gray-700',
                    title: 'dark:text-white'
                }
            });
            
            submitText.textContent = originalText;
            submitText.classList.remove('hidden');
            loadingSpinner.classList.add('hidden');
            submitBtn.disabled = false;
        }
    });

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('professionModal').classList.contains('hidden')) {
            document.getElementById('professionModal').classList.add('hidden');
        }
    });

    // Delete department function
    window.deleteDepartment = function(departmentId) {
        Swal.fire({
            title: 'Delete Department?',
            text: 'This action cannot be undone. Are you sure you want to delete this department?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel',
            customClass: {
                container: 'dark:bg-gray-800 dark:text-white',
                popup: 'dark:bg-gray-800 dark:text-white border dark:border-gray-700',
                title: 'dark:text-white',
                htmlContainer: 'dark:text-gray-300'
            }
        }).then(result => {
            if (result.isConfirmed) {
                // Send delete request
                fetch(`/admin/departments/${departmentId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: data.message || 'Department deleted successfully.',
                            customClass: {
                                container: 'dark:bg-gray-800 dark:text-white',
                                popup: 'dark:bg-gray-800 dark:text-white border dark:border-gray-700',
                                title: 'dark:text-white'
                            }
                        }).then(() => {
                            window.location.href = '/admin/departments';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to delete department.',
                            customClass: {
                                container: 'dark:bg-gray-800 dark:text-white',
                                popup: 'dark:bg-gray-800 dark:text-white border dark:border-gray-700',
                                title: 'dark:text-white'
                            }
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to delete department. Please try again.',
                        customClass: {
                            container: 'dark:bg-gray-800 dark:text-white',
                            popup: 'dark:bg-gray-800 dark:text-white border dark:border-gray-700',
                            title: 'dark:text-white'
                        }
                    });
                });
            }
        });
    };
