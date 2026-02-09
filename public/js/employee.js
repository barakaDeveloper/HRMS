// Database-driven professions by department will be set from blade template
// (Already declared in employeelist.blade.php)
let departmentNameToIdMap = {};

// Filter state
let currentFilters = {
    name: '',
    employeeId: '',
    department: '',
    profession: '',
    employmentType: '',
    status: '',
    minProductivity: '',
    maxProductivity: ''
};

// ==================== EMPLOYEE MODAL FUNCTIONS ====================

function openEmployeeModal() {
    const modal = document.getElementById('employeeModal');
    if (modal) {
        modal.style.display = 'flex';
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeEmployeeModal() {
    const modal = document.getElementById('employeeModal');
    const form = document.getElementById('employeeForm');

    modal.style.display = 'none';
    modal.classList.add('hidden');
    document.body.style.overflow = '';

    // Reset form
    if (form) {
        form.reset();
    }

    // Reset profession dropdown
    const professionSelect = document.getElementById('professionSelect');
    if (professionSelect) {
        professionSelect.innerHTML = '<option value="">Select Department First</option>';
    }
}

function updateProfessions() {
    const departmentSelect = document.getElementById('departmentSelect');
    const professionSelect = document.getElementById('professionSelect');

    if (!departmentSelect || !professionSelect) {
        return;
    }

    const selectedOption = departmentSelect.options[departmentSelect.selectedIndex];
    const departmentId = selectedOption.getAttribute('data-id');
    const selectedDepartment = departmentSelect.value;

    professionSelect.innerHTML = '<option value="">Select Profession</option>';

    // Use database data if available
    if (departmentId && professionsByDepartmentId[departmentId]) {
        professionsByDepartmentId[departmentId].forEach(profession => {
            const option = document.createElement('option');
            option.value = profession.name;
            option.textContent = profession.name;
            professionSelect.appendChild(option);
        });
    }

    // Generate employee ID when department is selected
    generateEmployeeId(selectedDepartment);
}

function generateEmployeeId(department) {
    if (!department) {
        document.getElementById('employee_id').value = '';
        return;
    }

    const baseUrl = (window.generateEmployeeIdUrl) ? window.generateEmployeeIdUrl : '/admin/employees/generate-id';
    fetch(`${baseUrl}/${encodeURIComponent(department)}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('employee_id').value = data.employee_id;
            } else {
                document.getElementById('employee_id').value = '';
            }
        })
        .catch(error => {
            document.getElementById('employee_id').value = '';
        });
}

// ==================== FILTER FUNCTIONS ====================

function openFilterModal() {
    const modal = document.getElementById('filterModal');
    if (modal) {
        modal.style.display = 'flex';
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        populateFilterData();
    }
}

function closeFilterModal() {
    const modal = document.getElementById('filterModal');
    if (modal) {
        modal.style.display = 'none';
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
}

function populateFilterData() {
    const employeeCards = document.querySelectorAll('.employee-card');
    const professions = new Set();

    employeeCards.forEach(card => {
        const profession = card.getAttribute('data-profession');
        if (profession) {
            professions.add(profession);
        }
    });

    // Populate professions dropdown
    const professionFilter = document.getElementById('professionFilter');
    if (professionFilter) {
        const allProfessionsOption = professionFilter.querySelector('option[value=""]');
        professionFilter.innerHTML = '';
        if (allProfessionsOption) {
            professionFilter.appendChild(allProfessionsOption);
        }

        professions.forEach(profession => {
            const option = document.createElement('option');
            option.value = profession;
            option.textContent = profession;
            professionFilter.appendChild(option);
        });
    }
}

function applyFilters(event) {
    if (event) event.preventDefault();

    // Get filter values
    currentFilters = {
        name: document.getElementById('nameFilter')?.value.toLowerCase().trim() || '',
        employeeId: document.getElementById('employeeIdFilter')?.value.toLowerCase().trim() || '',
        department: document.getElementById('departmentFilter')?.value || '',
        profession: document.getElementById('professionFilter')?.value || '',
        employmentType: document.getElementById('employmentTypeFilter')?.value || '',
        status: document.getElementById('statusFilter')?.value || '',
        minProductivity: document.getElementById('minProductivity')?.value || '',
        maxProductivity: document.getElementById('maxProductivity')?.value || ''
    };

    filterEmployees();
    updateActiveFiltersDisplay();
    closeFilterModal();
}

function filterEmployees() {
    const employeeCards = document.querySelectorAll('.employee-card');
    let visibleCount = 0;
    const totalCount = employeeCards.length;

    employeeCards.forEach(card => {
        let shouldShow = true;

        // Get employee data from data attributes and text content
        const name = card.querySelector('.employee-name')?.textContent.toLowerCase() || '';
        const employeeId = card.getAttribute('data-employee-id')?.toLowerCase() || '';
        const department = card.getAttribute('data-department') || '';
        const profession = card.getAttribute('data-profession') || '';
        const employmentType = card.getAttribute('data-employment-type') || '';
        const status = card.getAttribute('data-status') || '';
        const productivity = parseInt(card.getAttribute('data-productivity')) || 0;

        // Apply name filter
        if (currentFilters.name && !name.includes(currentFilters.name)) {
            shouldShow = false;
        }

        // Apply employee ID filter
        if (currentFilters.employeeId && !employeeId.includes(currentFilters.employeeId)) {
            shouldShow = false;
        }

        // Apply department filter
        if (currentFilters.department && department !== currentFilters.department) {
            shouldShow = false;
        }

        // Apply profession filter
        if (currentFilters.profession && profession !== currentFilters.profession) {
            shouldShow = false;
        }

        // Apply employment type filter
        if (currentFilters.employmentType && employmentType !== currentFilters.employmentType) {
            shouldShow = false;
        }

        // Apply status filter
        if (currentFilters.status && status !== currentFilters.status) {
            shouldShow = false;
        }

        // Apply productivity filters
        if (currentFilters.minProductivity && productivity < parseInt(currentFilters.minProductivity)) {
            shouldShow = false;
        }

        if (currentFilters.maxProductivity && productivity > parseInt(currentFilters.maxProductivity)) {
            shouldShow = false;
        }

        // Show/hide card
        if (shouldShow) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    updateResultsCount(visibleCount, totalCount);
    updateStats(visibleCount, totalCount);
}

function updateResultsCount(visible, total) {
    const resultsCount = document.getElementById('resultsCount');
    const visibleCount = document.getElementById('visibleCount');
    const totalCount = document.getElementById('totalCount');
    const noRecordsMessage = document.getElementById('noRecordsMessage');
    const employeeGrid = document.getElementById('employeeGrid');

    if (visibleCount) visibleCount.textContent = visible;
    if (totalCount) totalCount.textContent = total;

    if (resultsCount) {
        if (visible === total) {
            resultsCount.classList.add('hidden');
        } else {
            resultsCount.classList.remove('hidden');
        }
    }

    // Show/hide no records message
    if (noRecordsMessage) {
        if (visible === 0) {
            noRecordsMessage.classList.remove('hidden');
            if (employeeGrid) employeeGrid.classList.add('hidden');
        } else {
            noRecordsMessage.classList.add('hidden');
            if (employeeGrid) employeeGrid.classList.remove('hidden');
        }
    }
}

function updateStats(visible, total) {
    // Update the stats cards based on filtered results
    const totalEmployeesCount = document.getElementById('totalEmployeesCount');
    if (totalEmployeesCount) {
        totalEmployeesCount.textContent = visible;
    }
}

function updateActiveFiltersDisplay() {
    const activeFiltersDiv = document.getElementById('activeFilters');
    const filterTagsDiv = document.getElementById('filterTags');
    const activeFilterCount = document.getElementById('activeFilterCount');

    let activeFilterCountValue = 0;
    if (filterTagsDiv) filterTagsDiv.innerHTML = '';

    Object.entries(currentFilters).forEach(([key, value]) => {
        if (value && value !== '') {
            activeFilterCountValue++;

            if (filterTagsDiv) {
                const filterTag = document.createElement('div');
                filterTag.className = 'chip text-xs flex items-center gap-2 bg-[var(--g-spring)] bg-opacity-10 text-white border border-[var(--g-spring)] border-opacity-30';

                const label = getFilterLabel(key);
                filterTag.innerHTML = `
                    <span class="hover:text-[var(--g-spring)] transition-colors"> ${label}: ${value}</span>
                    <button type="button" onclick="removeFilter('${key}')" class="hover:text-red-500 transition-colors">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                `;

                filterTagsDiv.appendChild(filterTag);
            }
        }
    });

    if (activeFiltersDiv) {
        if (activeFilterCountValue > 0) {
            activeFiltersDiv.classList.remove('hidden');
        } else {
            activeFiltersDiv.classList.add('hidden');
        }
    }

    if (activeFilterCount) {
        if (activeFilterCountValue > 0) {
            activeFilterCount.classList.remove('hidden');
            activeFilterCount.textContent = activeFilterCountValue;
        } else {
            activeFilterCount.classList.add('hidden');
        }
    }
}

function getFilterLabel(key) {
    const labels = {
        name: 'Name',
        employeeId: 'Employee ID',
        department: 'Department',
        profession: 'Profession',
        employmentType: 'Employment Type',
        status: 'Status',
        minProductivity: 'Min Productivity',
        maxProductivity: 'Max Productivity'
    };
    return labels[key] || key;
}

function removeFilter(filterKey) {
    currentFilters[filterKey] = '';

    const fieldMap = {
        name: 'nameFilter',
        employeeId: 'employeeIdFilter',
        department: 'departmentFilter',
        profession: 'professionFilter',
        employmentType: 'employmentTypeFilter',
        status: 'statusFilter',
        minProductivity: 'minProductivity',
        maxProductivity: 'maxProductivity'
    };

    const fieldId = fieldMap[filterKey];
    if (fieldId) {
        const field = document.getElementById(fieldId);
        if (field) field.value = '';
    }

    filterEmployees();
    updateActiveFiltersDisplay();
}

function clearAllFilters() {
    currentFilters = {
        name: '',
        employeeId: '',
        department: '',
        profession: '',
        employmentType: '',
        status: '',
        minProductivity: '',
        maxProductivity: ''
    };

    const fieldsToClear = [
        'nameFilter', 'employeeIdFilter', 'departmentFilter',
        'professionFilter', 'employmentTypeFilter', 'statusFilter', 'minProductivity', 'maxProductivity'
    ];

    fieldsToClear.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) field.value = '';
    });

    const employeeCards = document.querySelectorAll('.employee-card');
    employeeCards.forEach(card => {
        card.style.display = 'block';
    });

    updateResultsCount(employeeCards.length, employeeCards.length);
    updateActiveFiltersDisplay();
    updateStats(employeeCards.length, employeeCards.length);
}

// ==================== FORM SUBMISSION ====================

function handleFormSubmit(event) {
    event.preventDefault();

    const form = event.target;

    // Ensure employee ID was generated (read-only auto-generated field)
    const employeeIdField = form.querySelector('[name="employee_id"]');
    const employeeIdValue = employeeIdField ? (employeeIdField.value || '').trim() : '';
    if (!employeeIdValue) {
        Swal.fire({
            icon: 'error',
            title: 'Missing Employee ID',
            text: 'Please select a department to auto-generate the Employee ID before submitting.',
            confirmButtonText: 'OK'
        });
        return;
    }

    const formData = new FormData(form);

    // Show loading state
    const submitText = document.getElementById('submitBtnText');
    const submitLoader = document.getElementById('submitBtnLoader');
    const submitBtn = submitText ? submitText.closest('button[type="submit"]') : null;
    if (submitBtn) {
        submitBtn.disabled = true;
    }
    if (submitText) submitText.classList.add('hidden');
    if (submitLoader) submitLoader.classList.remove('hidden');

    Swal.fire({
        title: 'Saving Employee...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(async response => {
            let data = null;
            try {
                data = await response.json();
            } catch (e) {
                // ignore json parse error
            }

            if (!response.ok) {
                if (response.status === 422 && data && data.errors) {
                    const messages = Object.values(data.errors).flat();
                    throw new Error(messages.join('\n'));
                }
                throw new Error((data && data.message) ? data.message : `HTTP ${response.status}`);
            }

            return data;
        })
        .then(data => {
            Swal.close();

            // Re-enable button and hide loader
            if (submitBtn) submitBtn.disabled = false;
            if (submitText) submitText.classList.remove('hidden');
            if (submitLoader) submitLoader.classList.add('hidden');

            if (data && data.success) {
                Swal.fire({
                    icon: 'success',
                    title: data.message || 'Employee added successfully!',
                    showConfirmButton: true
                }).then(() => {
                    closeEmployeeModal();
                    window.location.href = window.employeeIndexRoute || '/admin/employees';
                });
            } else {
                const errorMsg = (data && data.message) ? data.message : 'An error occurred while saving the employee';
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMsg,
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            Swal.close();

            if (submitBtn) submitBtn.disabled = false;
            if (submitText) submitText.classList.remove('hidden');
            if (submitLoader) submitLoader.classList.add('hidden');

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Please check your connection and try again',
                confirmButtonText: 'OK'
            });
        });
}

// ==================== INITIALIZATION ====================

function initializeFilters() {
    const employeeCards = document.querySelectorAll('.employee-card');
    updateResultsCount(employeeCards.length, employeeCards.length);

    // Add real-time filtering for name and ID
    const nameFilter = document.getElementById('nameFilter');
    const employeeIdFilter = document.getElementById('employeeIdFilter');

    if (nameFilter) {
        nameFilter.addEventListener('input', debounce(() => {
            currentFilters.name = nameFilter.value.toLowerCase().trim();
            filterEmployees();
            updateActiveFiltersDisplay();
        }, 300));
    }

    if (employeeIdFilter) {
        employeeIdFilter.addEventListener('input', debounce(() => {
            currentFilters.employeeId = employeeIdFilter.value.toLowerCase().trim();
            filterEmployees();
            updateActiveFiltersDisplay();
        }, 300));
    }
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// DOM Ready
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('employeeForm');
    const modal = document.getElementById('employeeModal');
    const departmentSelect = document.getElementById('departmentSelect');
    const filterModal = document.getElementById('filterModal');

    if (form) {
        form.addEventListener('submit', handleFormSubmit);
    }

    if (departmentSelect) {
        departmentSelect.addEventListener('change', updateProfessions);
    }

    if (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === this) {
                closeEmployeeModal();
            }
        });
    }

    if (filterModal) {
        filterModal.addEventListener('click', function (e) {
            if (e.target === this) {
                closeFilterModal();
            }
        });
    }

    initializeFilters();
});

// Make functions global
window.openEmployeeModal = openEmployeeModal;
window.closeEmployeeModal = closeEmployeeModal;
window.updateProfessions = updateProfessions;
window.openFilterModal = openFilterModal;
window.closeFilterModal = closeFilterModal;
window.applyFilters = applyFilters;
window.removeFilter = removeFilter;
window.clearAllFilters = clearAllFilters;