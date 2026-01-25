@extends('layouts.app')

@section('title', 'Edit ' . $department->name . ' - Department Management')

@section('content')
<!-- Edit Form Container -->
<div class="p-4 sm:p-6">

    <!-- Header -->
    <div class="panel p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 sm:gap-6">
            <!-- Profile Info Section -->
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full border-4 border-[var(--border-color)] bg-gradient-to-r {{ $department->color_scheme ?? 'from-gray-500 to-gray-600' }} flex items-center justify-center text-white font-bold text-xl flex-shrink-0">
                    {{ $department->initial ?? strtoupper(substr($department->name, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl sm:text-3xl font-bold logo-text truncate">Edit {{ $department->name }}</h1>
                    <p class="text-[var(--muted)] text-base">Update department information and professions</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 md:flex-shrink-0">
                <a href="{{ route('admin.departments.index') }}" class="chip flex items-center justify-center gap-2 hover:bg-[var(--hover-bg)] transition-colors">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Departments
                </a>
                <a href="{{ route('admin.departments.show', $department) }}"
                   class="chip flex items-center justify-center gap-2 bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] transition-colors">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    View Department
                </a>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <form id="editDepartmentForm" method="POST" action="{{ route('admin.departments.update', $department) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Department Details Card -->
                <div class="panel p-6">
                    <h3 class="text-xl font-bold logo-text mb-6 pb-3 border-b border-[var(--border-color)]">Department Details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Department Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-[var(--accent-text)] mb-2">Department Name *</label>
                            <input type="text" id="name" name="name"
                                   class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]"
                                   placeholder="e.g., Sales Department"
                                   value="{{ old('name', $department->name) }}"
                                   required>
                            <div id="name-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <!-- Department Code -->
                        <div>
                            <label for="code" class="block text-sm font-semibold text-[var(--accent-text)] mb-2">Department Code *</label>
                            <input type="text" id="code" name="code"
                                   class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]"
                                   placeholder="e.g., SAL"
                                   maxlength="10"
                                   value="{{ old('code', $department->code) }}"
                                   required>
                            <p class="text-xs text-[var(--muted)] mt-1">Unique identifier for the department</p>
                            <div id="code-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <!-- Initial -->
                        <div>
                            <label for="initial" class="block text-sm font-semibold text-[var(--accent-text)] mb-2">Initial</label>
                            <input type="text" id="initial" name="initial"
                                   class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]"
                                   placeholder="e.g., SD"
                                   maxlength="2"
                                   value="{{ old('initial', $department->initial) }}">
                            <p class="text-xs text-[var(--muted)] mt-1">Shown in department badges and avatars</p>
                        </div>

                        <!-- Team Function -->
                        <div>
                            <label for="team_function" class="block text-sm font-semibold text-[var(--accent-text)] mb-2">Team Function</label>
                            <input type="text" id="team_function" name="team_function"
                                   class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]"
                                   placeholder="e.g., Revenue Generation & Customer Relations"
                                   value="{{ old('team_function', $department->team_function) }}">
                        </div>

                        <!-- Employee Count -->
                        <div>
                            <label for="employee_count" class="block text-sm font-semibold text-[var(--accent-text)] mb-2">Employee Count</label>
                            <input type="number" id="employee_count" 
                                   class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)] bg-[var(--chip-bg)] cursor-not-allowed"
                                   readonly
                                   value="{{ $department->actual_employee_count ?? 0 }}">
                            <p class="text-xs text-[var(--muted)] mt-1">Automatically calculated from assigned employees</p>
                        </div>

                        <!-- Color Scheme -->
                        <div>
                            <label for="color_scheme" class="block text-sm font-semibold text-[var(--accent-text)] mb-2">Color Scheme</label>
                            <select id="color_scheme" name="color_scheme" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                                <option value="">Select a color scheme</option>
                                <option value="from-blue-500 to-purple-600" {{ $department->color_scheme == 'from-blue-500 to-purple-600' ? 'selected' : '' }}>Blue → Purple</option>
                                <option value="from-green-500 to-teal-600" {{ $department->color_scheme == 'from-green-500 to-teal-600' ? 'selected' : '' }}>Green → Teal</option>
                                <option value="from-orange-500 to-red-600" {{ $department->color_scheme == 'from-orange-500 to-red-600' ? 'selected' : '' }}>Orange → Red</option>
                                <option value="from-purple-500 to-pink-600" {{ $department->color_scheme == 'from-purple-500 to-pink-600' ? 'selected' : '' }}>Purple → Pink</option>
                                <option value="from-emerald-500 to-cyan-600" {{ $department->color_scheme == 'from-emerald-500 to-cyan-600' ? 'selected' : '' }}>Emerald → Cyan</option>
                                <option value="from-yellow-500 to-cyan-600" {{ $department->color_scheme == 'from-yellow-500 to-cyan-600' ? 'selected' : '' }}>Yellow → Cyan</option>
                                <option value="from-red-500 to-pink-600" {{ $department->color_scheme == 'from-red-500 to-pink-600' ? 'selected' : '' }}>Red → Pink</option>
                                <option value="from-indigo-500 to-purple-600" {{ $department->color_scheme == 'from-indigo-500 to-purple-600' ? 'selected' : '' }}>Indigo → Purple</option>
                            </select>
                            <p class="text-xs text-[var(--muted)] mt-1">Color gradient for department visuals</p>
                        </div>
                    <div class="md:col-span-2">
                            <div class="p-4 bg-[var(--chip-bg)] rounded-lg border border-[var(--border-color)]">
                                <div class="flex items-center">
                                    <!-- Toggle Switch -->
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="is_active" name="is_active" value="1" 
                                            class="sr-only peer" 
                                            {{ $department->is_active ? 'checked' : '' }}>
                                        <!-- Larger toggle for mobile, normal for desktop -->
                                        <div class="relative w-12 h-7 md:w-11 md:h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[var(--g-spring)]/30 rounded-full peer dark:bg-gray-700 peer-checked:bg-[var(--g-spring)] after:content-[''] after:absolute after:top-0.5 after:left-0.5 md:after:top-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 md:after:h-5 md:after:w-5 after:transition-all dark:border-gray-600 peer-checked:after:translate-x-5 md:peer-checked:after:translate-x-5"></div>
                                        <div class="ml-3">
                                            <span class="text-sm font-medium text-[var(--accent-text)]">Department Status</span>
                                            <p class="text-xs text-[var(--muted)] mt-1">
                                                <span id="statusText">{{ $department->is_active ? 'Active' : 'Inactive' }}</span> - 
                                                <span id="statusDescription">{{ $department->is_active ? 'Visible and operational in the system' : 'Hidden and inactive in the system' }}</span>
                                            </p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description Card -->
                <div class="panel p-6">
                    <label for="description" class="block text-sm font-semibold text-[var(--accent-text)] mb-3">Department Description</label>
                    <textarea id="description" name="description"
                              class="chip w-full h-40 focus:ring-2 focus:ring-[var(--g-spring)]"
                              placeholder="Describe the department's purpose, responsibilities, objectives, and key functions...">{{ old('description', $department->description) }}</textarea>
                    <p class="text-xs text-[var(--muted)] mt-2">This description will be displayed on the department details page.</p>
                </div>

                <!-- Professions Management Card -->
                <div class="panel p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 pb-3 border-b border-[var(--border-color)] gap-4">
                        <h3 class="text-xl font-bold logo-text">Department Professions</h3>
                        <button type="button" id="addProfessionBtn"
                                class="chip flex items-center justify-center gap-2 bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] transition-colors self-start sm:self-auto">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add Profession
                        </button>
                    </div>

                    <div id="professionsContainer" class="space-y-4">
                        @foreach($department->professions as $index => $profession)
                        <div class="profession-item panel p-4 border border-[var(--border-color)]">
                            <div class="flex flex-col sm:flex-row gap-4">
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-[var(--muted)] mb-1">Profession Name *</label>
                                    <input type="text" name="professions[{{ $index }}][name]"
                                           class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]"
                                           placeholder="e.g., Senior Sales Executive"
                                           value="{{ $profession->name }}"
                                           required>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-[var(--muted)] mb-1">Description</label>
                                    <input type="text" name="professions[{{ $index }}][description]"
                                           class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]"
                                           placeholder="Brief description of role responsibilities"
                                           value="{{ $profession->description }}">
                                </div>
                                <input type="hidden" name="professions[{{ $index }}][id]" value="{{ $profession->id }}">
                                <div class="flex items-end">
                                    <button type="button" class="remove-profession chip p-2 hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/30 dark:hover:text-red-400 transition-colors h-11">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    @if($department->professions->isEmpty())
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-[var(--muted)] mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <p class="text-[var(--muted)]">No professions added yet. Click "Add Profession" to start adding roles.</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Actions Card -->
                <div class="panel p-6">
                    <h3 class="text-xl font-bold logo-text mb-6 pb-3 border-b border-[var(--border-color)]">Actions</h3>
                    <div class="space-y-3">
                        <button type="submit" class="w-full chip flex items-center justify-center gap-2 bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] transition-colors" id="submitBtn">
                            <span id="submitText">Update Department</span>
                            <span id="loadingSpinner" class="hidden ml-2">
                                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                        </button>

                        <button type="button" onclick="deleteDepartment({{ $department->id }})"
                                class="w-full chip flex items-center justify-center gap-2 bg-red-500/20 text-red-600 dark:text-red-400 border border-red-500/30 hover:bg-red-500/30 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete Department
                        </button>

                        <a href="{{ route('admin.departments.show', $department) }}"
                           class="w-full chip flex items-center justify-center hover:bg-[var(--hover-bg)] transition-colors text-center">
                            Cancel & View Department
                        </a>
                    </div>
                </div>

                <!-- Preview Card -->
                <div class="panel p-6">
                    <h3 class="text-xl font-bold logo-text mb-6 pb-3 border-b border-[var(--border-color)]">Live Preview</h3>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 p-4 bg-[var(--chip-bg)] rounded-lg">
                            <div id="preview-badge" class="w-14 h-14 rounded-full border-4 border-[var(--border-color)] bg-gradient-to-r {{ $department->color_scheme ?? 'from-gray-500 to-gray-600' }} flex items-center justify-center text-white font-bold text-lg">
                                {{ $department->initial ?? strtoupper(substr($department->name, 0, 2)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div id="preview-name" class="font-bold logo-text truncate">{{ $department->name }}</div>
                                <div id="preview-function" class="text-sm text-[var(--muted)] truncate">{{ $department->team_function ?? 'Department Team' }}</div>
                                <div class="flex items-center gap-2 mt-2">
                                    <span id="preview-status" class="chip text-xs {{ $department->is_active ? 'bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30' : 'bg-red-500/20 text-red-600 dark:text-red-400 border-red-500/30' }}">
                                        {{ $department->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    <span class="chip text-xs bg-blue-500/20 text-blue-600 dark:text-blue-400 border-blue-500/30" id="preview-code">{{ $department->code }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-sm text-[var(--muted)]">
                            <p class="mb-2">Changes will be reflected in real-time:</p>
                            <ul class="space-y-1 list-disc list-inside">
                                <li>Department name and code</li>
                                <li>Initial badge display</li>
                                <li>Color scheme gradient</li>
                                <li>Status indicator</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editDepartmentForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const addProfessionBtn = document.getElementById('addProfessionBtn');
    const professionsContainer = document.getElementById('professionsContainer');

    let professionIndex = {{ $department->professions->count() }};

    // Status toggle elements
    const isActiveCheckbox = document.getElementById('is_active');
    const statusText = document.getElementById('statusText');
    const statusDescription = document.getElementById('statusDescription');

    // Update status text when toggle changes
    if (isActiveCheckbox) {
        // Initialize status text on page load
        updateStatusText(isActiveCheckbox.checked);
        
        isActiveCheckbox.addEventListener('change', function() {
            updateStatusText(this.checked);
            updatePreview();
        });
    }

    // Helper function to update status text
    function updateStatusText(isActive) {
        if (isActive) {
            statusText.textContent = 'Active';
            statusDescription.textContent = 'Visible and operational in the system';
        } else {
            statusText.textContent = 'Inactive';
            statusDescription.textContent = 'Hidden and inactive in the system';
        }
    }

    // Live preview updates
    const nameInput = document.getElementById('name');
    const codeInput = document.getElementById('code');
    const initialInput = document.getElementById('initial');
    const teamFunctionInput = document.getElementById('team_function');
    const colorSchemeSelect = document.getElementById('color_scheme');
    
    const previewName = document.getElementById('preview-name');
    const previewFunction = document.getElementById('preview-function');
    const previewBadge = document.getElementById('preview-badge');
    const previewStatus = document.getElementById('preview-status');
    const previewCode = document.getElementById('preview-code');

    function updatePreview() {
        const name = nameInput.value || 'Department Name';
        const code = codeInput.value || 'CODE';
        const initial = initialInput.value || name.substring(0, 2).toUpperCase();
        const teamFunction = teamFunctionInput.value || 'Department Team';
        const colorScheme = colorSchemeSelect.value || 'from-gray-500 to-gray-600';
        const isActive = isActiveCheckbox ? isActiveCheckbox.checked : true;

        previewName.textContent = name;
        previewCode.textContent = code;
        previewFunction.textContent = teamFunction;
        previewBadge.textContent = initial;
        previewBadge.className = `w-14 h-14 rounded-full border-4 border-[var(--border-color)] bg-gradient-to-r ${colorScheme} flex items-center justify-center text-white font-bold text-lg`;
        previewStatus.textContent = isActive ? 'Active' : 'Inactive';
        previewStatus.className = `chip text-xs ${isActive ? 'bg-green-500/20 text-green-600 dark:text-green-400 border-green-500/30' : 'bg-red-500/20 text-red-600 dark:text-red-400 border-red-500/30'}`;
    }

    [nameInput, codeInput, initialInput, teamFunctionInput, colorSchemeSelect].forEach(input => {
        input.addEventListener('input', updatePreview);
        input.addEventListener('change', updatePreview);
    });

    // Initialize preview
    updatePreview();

    // Add profession field
    if (addProfessionBtn) {
        addProfessionBtn.addEventListener('click', function() {
            const professionField = createProfessionField(professionIndex);
            professionsContainer.appendChild(professionField);
            professionIndex++;
            
            // Scroll to the new field
            professionField.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        });
    }

    // Remove profession field
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-profession')) {
            const professionItem = e.target.closest('.profession-item');
            if (professionItem) {
                Swal.fire({
                    title: 'Remove Profession?',
                    text: 'This profession will be removed from the department. You can save the form to confirm.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Remove',
                    cancelButtonText: 'Keep',
                    reverseButtons: true,
                    customClass: {
                        container: 'dark:bg-gray-800 dark:text-white',
                        popup: 'dark:bg-gray-800 dark:text-white border dark:border-gray-700',
                        title: 'dark:text-white',
                        htmlContainer: 'dark:text-gray-300',
                        confirmButton: 'dark:bg-red-600 dark:hover:bg-red-700',
                        cancelButton: 'dark:bg-gray-600 dark:hover:bg-gray-700'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        professionItem.remove();
                        
                        // Show notification
                        Swal.fire({
                            title: 'Removed!',
                            text: 'Profession removed from the form. Remember to save changes.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                            customClass: {
                                container: 'dark:bg-gray-800 dark:text-white',
                                popup: 'dark:bg-gray-800 dark:text-white border dark:border-gray-700',
                                title: 'dark:text-white'
                            }
                        });
                    }
                });
            }
        }
    });

    // Create profession field HTML
    function createProfessionField(index) {
        const div = document.createElement('div');
        div.className = 'profession-item panel p-4 border border-[var(--border-color)]';
        div.innerHTML = `
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-[var(--muted)] mb-1">Profession Name *</label>
                    <input type="text" name="professions[${index}][name]"
                           class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]"
                           placeholder="e.g., Senior Developer"
                           required>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-[var(--muted)] mb-1">Description</label>
                    <input type="text" name="professions[${index}][description]"
                           class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]"
                           placeholder="Brief description of role responsibilities">
                </div>
                <div class="flex items-end">
                    <button type="button" class="remove-profession chip p-2 hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/30 dark:hover:text-red-400 transition-colors h-11">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        `;
        return div;
    }

    // Form submission with AJAX - FIXED: Ensure is_active checkbox value is properly sent
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const originalText = submitText.textContent;
            submitText.textContent = 'Updating...';
            loadingSpinner.classList.remove('hidden');
            submitBtn.disabled = true;

            try {
                // Create FormData and ensure is_active is included with proper value
                const formData = new FormData(form);
                
                // Ensure checkbox sends proper value (1 for checked, 0 for unchecked)
                if (isActiveCheckbox) {
                    // Remove any existing is_active value
                    formData.delete('is_active');
                    // Add correct value
                    formData.append('is_active', isActiveCheckbox.checked ? '1' : '0');
                }
                
                // Log form data for debugging (optional)
                console.log('Submitting form with is_active:', isActiveCheckbox ? isActiveCheckbox.checked : 'N/A');
                
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
                        text: data.message || 'Department updated successfully!',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'View Department',
                        showCancelButton: true,
                        cancelButtonText: 'Stay Here',
                        customClass: {
                            container: 'dark:bg-gray-800 dark:text-white',
                            popup: 'dark:bg-gray-800 dark:text-white border dark:border-gray-700',
                            title: 'dark:text-white'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = data.redirect || "{{ route('admin.departments.show', $department) }}";
                        } else {
                            // Reload page to show updated status
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        }
                    });
                } else {
                    submitText.textContent = originalText;
                    loadingSpinner.classList.add('hidden');
                    submitBtn.disabled = false;

                    let errorMessage = data.message || 'An error occurred while updating the department.';
                    
                    if (data.errors) {
                        errorMessage = Object.values(data.errors).flat().join('\n');
                        
                        // Show field errors
                        Object.keys(data.errors).forEach(field => {
                            const errorElement = document.getElementById(field + '-error');
                            const inputElement = document.getElementById(field);
                            
                            if (errorElement && inputElement) {
                                errorElement.textContent = data.errors[field][0];
                                errorElement.classList.remove('hidden');
                                inputElement.classList.add('border-red-500');
                                
                                // Remove error on input
                                inputElement.addEventListener('input', function() {
                                    errorElement.classList.add('hidden');
                                    this.classList.remove('border-red-500');
                                }, { once: true });
                            }
                        });
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
                }
            } catch (error) {
                console.error('Error:', error);
                
                submitText.textContent = originalText;
                loadingSpinner.classList.add('hidden');
                submitBtn.disabled = false;

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
            }
        });
    }
});

// Delete department function
function deleteDepartment(departmentId) {
    Swal.fire({
        title: 'Delete Department?',
        text: 'This action cannot be undone. All associated data will be deleted.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete Department',
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
    }).then((result) => {
        if (result.isConfirmed) {
            const url = `/admin/departments/${departmentId}`;
            
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Deleted!',
                        text: data.message || 'Department has been deleted successfully.',
                        icon: 'success',
                        confirmButtonColor: '#10b981',
                        confirmButtonText: 'OK',
                        customClass: {
                            container: 'dark:bg-gray-800 dark:text-white',
                            popup: 'dark:bg-gray-800 dark:text-white border dark:border-gray-700',
                            title: 'dark:text-white'
                        }
                    }).then(() => {
                        window.location.href = '{{ route("admin.departments.index") }}';
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message || 'Failed to delete department.',
                        icon: 'error',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                        customClass: {
                            container: 'dark:bg-gray-800 dark:text-white',
                            popup: 'dark:bg-gray-800 dark:text-white border dark:border-gray-700',
                            title: 'dark:text-white'
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'An unexpected error occurred while deleting the department.',
                    icon: 'error',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK',
                    customClass: {
                        container: 'dark:bg-gray-800 dark:text-white',
                        popup: 'dark:bg-gray-800 dark:text-white border dark:border-gray-700',
                        title: 'dark:text-white'
                    }
                });
            });
        }
    });
}
</script>
@endpush
@endsection