<!-- Edit Department Modal -->
<div class="max-w-4xl mx-auto">
    <form id="editDepartmentModalForm" method="POST" action="{{ route('admin.departments.update', $department) }}">
        @csrf
        @method('PUT')

        <div class="px-6 py-4 max-h-[70vh] overflow-y-auto" id="modalContent">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Department Details -->
                <div class="space-y-4">
                    <div>
                        <label for="modal_name" class="block text-sm font-medium mb-2">Department Name *</label>
                        <input type="text" id="modal_name" name="name"
                               class="input-field w-full"
                               placeholder="e.g., Sales"
                               value="{{ old('name', $department->name) }}"
                               required>
                        <div id="modal_name-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>

                    <div>
                        <label for="modal_code" class="block text-sm font-medium mb-2">Department Code *</label>
                        <input type="text" id="modal_code" name="code"
                               class="input-field w-full"
                               placeholder="e.g., SAL"
                               maxlength="10"
                               value="{{ old('code', $department->code) }}"
                               required>
                        <p class="text-xs text-[var(--muted)] mt-1">Unique code for the department</p>
                        <div id="modal_code-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>

                    <div>
                        <label for="modal_initial" class="block text-sm font-medium mb-2">Initial</label>
                        <input type="text" id="modal_initial" name="initial"
                               class="input-field w-full"
                               placeholder="e.g., S"
                               maxlength="2"
                               value="{{ old('initial', $department->initial) }}">
                        <p class="text-xs text-[var(--muted)] mt-1">Shown in department badge</p>
                    </div>

                    <div>
                        <label for="modal_team_function" class="block text-sm font-medium mb-2">Team Function</label>
                        <input type="text" id="modal_team_function" name="team_function"
                               class="input-field w-full"
                               placeholder="e.g., Revenue Generation Team"
                               value="{{ old('team_function', $department->team_function) }}">
                    </div>

                    <div>
                        <label for="modal_employee_count" class="block text-sm font-medium mb-2">Employee Count</label>
                        <input type="number" id="modal_employee_count" name="employee_count"
                               class="input-field w-full"
                               min="0"
                               value="{{ old('employee_count', $department->employee_count) }}">
                    </div>

                    <div>
                        <label for="modal_color_scheme" class="block text-sm font-medium mb-2">Color Scheme</label>
                        <select id="modal_color_scheme" name="color_scheme" class="input-field w-full">
                            <option value="">Select a color scheme</option>
                            <option value="from-blue-500 to-purple-600" {{ $department->color_scheme == 'from-blue-500 to-purple-600' ? 'selected' : '' }}>Blue to Purple</option>
                            <option value="from-green-500 to-teal-600" {{ $department->color_scheme == 'from-green-500 to-teal-600' ? 'selected' : '' }}>Green to Teal</option>
                            <option value="from-orange-500 to-red-600" {{ $department->color_scheme == 'from-orange-500 to-red-600' ? 'selected' : '' }}>Orange to Red</option>
                            <option value="from-purple-500 to-pink-600" {{ $department->color_scheme == 'from-purple-500 to-pink-600' ? 'selected' : '' }}>Purple to Pink</option>
                            <option value="from-emerald-500 to-cyan-600" {{ $department->color_scheme == 'from-emerald-500 to-cyan-600' ? 'selected' : '' }}>Emerald to Cyan</option>
                            <option value="from-yellow-500 to-cyan-600" {{ $department->color_scheme == 'from-yellow-500 to-cyan-600' ? 'selected' : '' }}>Yellow to Cyan</option>
                            <option value="from-red-500 to-pink-600" {{ $department->color_scheme == 'from-red-500 to-pink-600' ? 'selected' : '' }}>Red to Pink</option>
                            <option value="from-indigo-500 to-purple-600" {{ $department->color_scheme == 'from-indigo-500 to-purple-600' ? 'selected' : '' }}>Indigo to Purple</option>
                        </select>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" id="modal_is_active" name="is_active" value="1"
                                   {{ $department->is_active ? 'checked' : '' }} class="mr-2">
                            <span class="text-sm">Department is active</span>
                        </label>
                    </div>
                </div>

                <!-- Description -->
                <div class="space-y-4">
                    <div>
                        <label for="modal_description" class="block text-sm font-medium mb-2">Department Description</label>
                        <textarea id="modal_description" name="description"
                                  class="input-field w-full h-48"
                                  placeholder="Describe the department's purpose, responsibilities, and objectives...">{{ old('description', $department->description) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Professions Section -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Department Professions</h3>
                    <button type="button" id="modalAddProfessionBtn"
                            class="chip flex items-center gap-2 bg-[var(--primary)] text-white text-sm hover:bg-[var(--primary-dark)]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Profession
                    </button>
                </div>

                <div id="modalProfessionsContainer" class="space-y-3">
                    @foreach($department->professions as $index => $profession)
                    <div class="profession-item p-4 border border-[var(--border-color)] rounded-lg">
                        <div class="flex gap-3">
                            <div class="flex-1">
                                <input type="text" name="professions[{{ $index }}][name]"
                                       class="input-field w-full" placeholder="Profession name"
                                       value="{{ $profession->name }}" required>
                            </div>
                            <div class="flex-1">
                                <input type="text" name="professions[{{ $index }}][description]"
                                       class="input-field w-full" placeholder="Description (optional)"
                                       value="{{ $profession->description }}">
                            </div>
                            <input type="hidden" name="professions[{{ $index }}][id]" value="{{ $profession->id }}">
                            <button type="button" class="modal-remove-profession text-red-500 hover:text-red-700 p-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Modal footer -->
        <div class="flex justify-end gap-3 px-6 py-4 border-t border-[var(--border-color)]">
            <button type="button" id="modalCancelForm" class="chip px-6 hover:bg-[var(--chip-bg)]">Cancel</button>
            <button type="submit" id="modalSubmitBtn" class="chip px-6 bg-[var(--primary)] text-white hover:bg-[var(--primary-dark)] disabled:opacity-50 disabled:cursor-not-allowed">
                <span id="modalSubmitText">Update Department</span>
                <span id="modalLoadingSpinner" class="hidden">
                    <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // This script runs within the modal context
    const modalForm = document.getElementById('editDepartmentModalForm');
    const modalSubmitBtn = document.getElementById('modalSubmitBtn');
    const modalSubmitText = document.getElementById('modalSubmitText');
    const modalLoadingSpinner = document.getElementById('modalLoadingSpinner');
    const modalAddProfessionBtn = document.getElementById('modalAddProfessionBtn');
    const modalProfessionsContainer = document.getElementById('modalProfessionsContainer');

    let modalProfessionIndex = {{ $department->professions->count() }};

    // Add profession field
    if (modalAddProfessionBtn) {
        modalAddProfessionBtn.addEventListener('click', function() {
            const professionField = createModalProfessionField(modalProfessionIndex);
            modalProfessionsContainer.appendChild(professionField);
            modalProfessionIndex++;
        });
    }

    // Remove profession field
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-remove-profession') || e.target.closest('.modal-remove-profession')) {
            e.target.closest('.profession-item').remove();
        }
    });

    // Create profession field HTML
    function createModalProfessionField(index) {
        const div = document.createElement('div');
        div.className = 'profession-item p-4 border border-[var(--border-color)] rounded-lg';
        div.innerHTML = `
            <div class="flex gap-3">
                <div class="flex-1">
                    <input type="text" name="professions[${index}][name]"
                           class="input-field w-full" placeholder="Profession name" required>
                </div>
                <div class="flex-1">
                    <input type="text" name="professions[${index}][description]"
                           class="input-field w-full" placeholder="Description (optional)">
                </div>
                <button type="button" class="modal-remove-profession text-red-500 hover:text-red-700 p-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </div>
        `;
        return div;
    }

    // Form submission
    if (modalForm) {
        modalForm.addEventListener('submit', function(e) {
            e.preventDefault();

            modalSubmitText.textContent = 'Updating...';
            modalLoadingSpinner.classList.remove('hidden');
            modalSubmitBtn.disabled = true;

            const formData = new FormData(modalForm);

            fetch(modalForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal and refresh the page
                    const modal = document.querySelector('[data-modal]');
                    if (modal) {
                        modal.remove();
                    }
                    location.reload();
                } else {
                    modalSubmitText.textContent = 'Update Department';
                    modalLoadingSpinner.classList.add('hidden');
                    modalSubmitBtn.disabled = false;

                    // Show errors
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            const errorElement = document.getElementById('modal_' + field + '-error');
                            if (errorElement) {
                                errorElement.textContent = data.errors[field][0];
                                errorElement.classList.remove('hidden');
                            }
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                modalSubmitText.textContent = 'Update Department';
                modalLoadingSpinner.classList.add('hidden');
                modalSubmitBtn.disabled = false;
                alert('An error occurred while updating the department');
            });
        });
    }
});
</script>