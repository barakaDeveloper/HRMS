<?php
// app/Http\Controllers\Admin\DepartmentController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\DepartmentProfession;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    // Default professions for each department
    private $defaultProfessions = [
        'Sales' => ['Sales Manager', 'Sales Executive'],
        'Reservations' => ['Reservation Manager', 'Reservation Executive'],
        'Logistics' => ['Logistics Officer', 'Logistics Executive'],
        'Marketing' => ['Marketing Officer', 'Digital Marketer', 'Content Creator', 'Brand Strategist'],
        'Finance & Accounting' => ['Finance Manager', 'Accountant', 'Cashier', 'Auditor'],
        'Media' => ['Photographer', 'Videographer', 'Social Media Manager', 'Graphic Designer']
    ];

    /**
     * Display a listing of the departments.
     */
    public function index()
    {
        // Check authentication and authorization
        if (!Auth::check()) {
            abort(403, 'Unauthorized access.');
        }
        
        // Check if user is admin - FIXED: Using proper auth guard
        $user = Auth::user();
        if (!$this->isAdmin($user)) {
            abort(403, 'Unauthorized access.');
        }

        // Get departments with professions
        $departments = Department::with('professions')->get();
        
        // Calculate actual employee count for each department
        $departments->each(function($department) {
            $department->actual_employee_count = Employee::where('department', $department->name)->count();
        });
        
        // Calculate stats using actual employee counts
        $stats = [
            'total_departments' => $departments->count(),
            'total_employees' => $departments->sum('actual_employee_count'),
            'active_teams' => $departments->where('is_active', true)->count(),
            'avg_team_size' => $departments->count() > 0 ? ($departments->sum('actual_employee_count') / $departments->count()) : 0,
        ];

        // Check if it's an AJAX request
        if (request()->ajax() || request()->wantsJson()) {
            return response()->view('admin.partials.department_stats', compact('departments', 'stats'));
        }
        
        return view('admin.departments.index', compact('departments', 'stats'));
    }

    /**
     * Show the form for creating a new department.
     */
    public function create()
    {
        if (!Auth::check() || !$this->isAdmin(Auth::user())) {
            abort(403, 'Unauthorized access.');
        }
        
        return view('admin.departments.create');
    }

    /**
     * Store a newly created department with AJAX support.
     */
    public function store(Request $request)
    {
        // Check authorization
        if (!Auth::check() || !$this->isAdmin(Auth::user())) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access.'
                ], 403);
            }
            abort(403, 'Unauthorized access.');
        }

        // Validation rules
        $rules = [
            'name' => 'required|string|max:255|unique:departments,name',
            'code' => 'required|string|max:10|unique:departments,code',
            'description' => 'nullable|string',
            'team_function' => 'nullable|string|max:255',
            'color_scheme' => 'nullable|string|max:255',
            'initial' => 'nullable|string|max:2',
            'is_active' => 'nullable|boolean',
        ];

        // Add profession validation rules if professions exist in request
        if ($request->has('professions')) {
            foreach ($request->input('professions', []) as $index => $profession) {
                $rules["professions.{$index}.name"] = 'required|string|max:255';
                $rules["professions.{$index}.description"] = 'nullable|string';
            }
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'message' => 'Please fix the validation errors.'
                ], 422);
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        try {
            // Create department - FIXED: Added missing database fields
            $department = Department::create([
                'name' => $validated['name'],
                'code' => $validated['code'],
                'description' => $validated['description'] ?? null,
                'team_function' => $validated['team_function'] ?? null,
                'employee_count' => $validated['employee_count'] ?? 0,
                'color_scheme' => $validated['color_scheme'] ?? $this->getDefaultColor($validated['name']),
                'initial' => $validated['initial'] ?? strtoupper(substr($validated['name'], 0, 2)),
                'is_active' => $validated['is_active'] ?? true, // Default to true if not provided
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            // Add professions
            if (isset($validated['professions']) && is_array($validated['professions'])) {
                foreach ($validated['professions'] as $professionData) {
                    if (!empty($professionData['name'])) {
                        $department->professions()->create([
                            'name' => $professionData['name'],
                            'description' => $professionData['description'] ?? null,
                            'created_by' => Auth::id(),
                            'updated_by' => Auth::id(),
                        ]);
                    }
                }
            } elseif (isset($this->defaultProfessions[$validated['name']])) {
                // Add default professions based on department name
                foreach ($this->defaultProfessions[$validated['name']] as $professionName) {
                    $department->professions()->create([
                        'name' => $professionName,
                        'description' => null,
                        'created_by' => Auth::id(),
                        'updated_by' => Auth::id(),
                    ]);
                }
            }

            // Return JSON response for AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Department created successfully!',
                    'department' => $department->load('professions'),
                    'redirect' => route('admin.departments.index')
                ]);
            }

            return redirect()->route('admin.departments.index')
                ->with('success', 'Department created successfully!');

        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating department: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Error creating department: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified department.
     */
    public function show(Department $department)
    {
        if (!Auth::check() || !$this->isAdmin(Auth::user())) {
            abort(403, 'Unauthorized access.');
        }
        
        $department->load('professions');
        // Calculate actual employee count for this department
        $department->actual_employee_count = Employee::where('department', $department->name)->count();
        return view('admin.departments.show', compact('department'));
    }

    /**
     * Show the form for editing the department.
     */
    public function edit(Department $department)
    {
        if (!Auth::check() || !$this->isAdmin(Auth::user())) {
            abort(403, 'Unauthorized access.');
        }
        
        $department->load('professions');
        // Calculate actual employee count for this department
        $department->actual_employee_count = Employee::where('department', $department->name)->count();
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'department' => $department,
                'html' => view('admin.partials.edit_department_modal', compact('department'))->render()
            ]);
        }
        
        return view('admin.departments.edit', compact('department'));
    }

    /**
     * Update the specified department with AJAX support.
     */
    public function update(Request $request, Department $department)
    {
        // Check authorization
        if (!Auth::check() || !$this->isAdmin(Auth::user())) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access.'
                ], 403);
            }
            abort(403, 'Unauthorized access.');
        }

        // Validation rules
        $rules = [
            'name' => ['required', 'string', 'max:255', Rule::unique('departments')->ignore($department->id)],
            'code' => ['required', 'string', 'max:10', Rule::unique('departments')->ignore($department->id)],
            'description' => 'nullable|string',
            'team_function' => 'nullable|string|max:255',
            'employee_count' => 'nullable|integer|min:0',
            'color_scheme' => 'nullable|string|max:255',
            'initial' => 'nullable|string|max:2',
            'is_active' => 'nullable|boolean',
        ];

        // Add profession validation rules if professions exist in request
        if ($request->has('professions')) {
            foreach ($request->input('professions', []) as $index => $profession) {
                $rules["professions.{$index}.name"] = 'required|string|max:255';
                $rules["professions.{$index}.description"] = 'nullable|string';
                if (isset($profession['id'])) {
                    $rules["professions.{$index}.id"] = 'exists:department_professions,id';
                }
            }
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'message' => 'Please fix the validation errors.'
                ], 422);
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        try {
            // Update department
            $department->update([
                'name' => $validated['name'],
                'code' => $validated['code'],
                'description' => $validated['description'] ?? null,
                'team_function' => $validated['team_function'] ?? null,
                'employee_count' => $validated['employee_count'] ?? $department->employee_count,
                'color_scheme' => $validated['color_scheme'] ?? $department->color_scheme,
                'initial' => $validated['initial'] ?? $department->initial,
                'is_active' => isset($validated['is_active']) ? (bool)$validated['is_active'] : $department->is_active,
                'updated_by' => Auth::id(),
            ]);

            // Sync professions
            if (isset($validated['professions']) && is_array($validated['professions'])) {
                $existingProfessionIds = [];
                
                foreach ($validated['professions'] as $professionData) {
                    if (!empty($professionData['name'])) {
                        if (isset($professionData['id'])) {
                            // Update existing profession
                            $profession = DepartmentProfession::find($professionData['id']);
                            if ($profession && $profession->department_id == $department->id) {
                                $profession->update([
                                    'name' => $professionData['name'],
                                    'description' => $professionData['description'] ?? null,
                                    'updated_by' => Auth::id(),
                                ]);
                                $existingProfessionIds[] = $profession->id;
                            }
                        } else {
                            // Create new profession
                            $newProfession = $department->professions()->create([
                                'name' => $professionData['name'],
                                'description' => $professionData['description'] ?? null,
                                'created_by' => Auth::id(),
                                'updated_by' => Auth::id(),
                            ]);
                            $existingProfessionIds[] = $newProfession->id;
                        }
                    }
                }
                
                // Delete professions not in the updated list
                if (!empty($existingProfessionIds)) {
                    $department->professions()
                        ->whereNotIn('id', $existingProfessionIds)
                        ->delete();
                }
            }

            // Return JSON response for AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Department updated successfully!',
                    'department' => $department->load('professions'),
                    'redirect' => route('admin.departments.show', $department)
                ]);
            }

            return redirect()->route('admin.departments.show', $department)
                ->with('success', 'Department updated successfully!');

        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating department: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Error updating department: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified department with AJAX support.
     */
    public function destroy(Department $department)
    {
        // Check authorization
        if (!Auth::check() || !$this->isAdmin(Auth::user())) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access.'
                ], 403);
            }
            abort(403, 'Unauthorized access.');
        }

        try {
            // Check if department has employees - use actual count from employees table
            $actualEmployeeCount = Employee::where('department', $department->name)->count();
            
            if ($actualEmployeeCount > 0) {
                $message = 'Cannot delete department with employees. Reassign employees first.';
                
                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $message
                    ], 422);
                }
                
                return redirect()->back()
                    ->with('error', $message);
            }
            
            // Delete related professions first
            $department->professions()->delete();
            
            // Delete department
            $department->delete();
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Department deleted successfully!',
                    'redirect' => route('admin.departments.index')
                ]);
            }
            
            return redirect()->route('admin.departments.index')
                ->with('success', 'Department deleted successfully!');
                
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting department: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Error deleting department: ' . $e->getMessage());
        }
    }

    /**
     * Add a profession to a department via AJAX.
     */
    public function addProfession(Request $request, Department $department)
    {
        if (!Auth::check() || !$this->isAdmin(Auth::user())) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $profession = $department->professions()->create(array_merge(
                $validator->validated(),
                [
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                ]
            ));

            return response()->json([
                'success' => true,
                'profession' => $profession,
                'message' => 'Profession added successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding profession: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a profession via AJAX.
     */
    public function updateProfession(Request $request, Department $department, DepartmentProfession $profession)
    {
        if (!Auth::check() || !$this->isAdmin(Auth::user())) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 403);
        }

        // Verify the profession belongs to the department
        if ($profession->department_id !== $department->id) {
            return response()->json([
                'success' => false,
                'message' => 'Profession does not belong to this department.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $profession->update(array_merge(
                $validator->validated(),
                [
                    'updated_by' => Auth::id(),
                ]
            ));

            return response()->json([
                'success' => true,
                'profession' => $profession,
                'message' => 'Profession updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating profession: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove a profession from a department via AJAX.
     */
    public function removeProfession(Department $department, DepartmentProfession $profession)
    {
        if (!Auth::check() || !$this->isAdmin(Auth::user())) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 403);
        }

        try {
            if ($profession->department_id !== $department->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profession does not belong to this department.'
                ], 403);
            }

            $profession->delete();

            return response()->json([
                'success' => true,
                'message' => 'Profession removed successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error removing profession: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get department data for editing via modal.
     */
    public function getDepartmentData(Department $department)
    {
        if (!Auth::check() || !$this->isAdmin(Auth::user())) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 403);
        }
        
        $department->load('professions');
        
        return response()->json([
            'success' => true,
            'department' => $department
        ]);
    }

    /**
     * Get default color scheme based on department name.
     */
    private function getDefaultColor($departmentName)
    {
        $colorMap = [
            'Sales' => 'from-blue-500 to-purple-600',
            'Reservations' => 'from-green-500 to-teal-600',
            'Logistics' => 'from-orange-500 to-red-600',
            'Marketing' => 'from-purple-500 to-pink-600',
            'Finance & Accounting' => 'from-emerald-500 to-cyan-600',
            'Media' => 'from-yellow-500 to-cyan-600',
        ];

        return $colorMap[$departmentName] ?? 'from-gray-500 to-gray-600';
    }

    /**
     * Check if user has admin privileges.
     */
    private function isAdmin($user)
    {
        // Actual admin check based on your user model
        return $user->hasRole('Super Admin') || $user->is_admin === true;
    
    }
}