<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Department;
use App\Models\DepartmentProfession;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeeExport;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the employees.
     */
    public function index()
    {
        if (!Auth::user() || !$this->isAdmin(Auth::user())) {
            abort(403, 'Unauthorized access.');
        }

        $user = Auth::user();
        $employees = Employee::where('is_active', true)->get();
        $departments = Department::where('is_active', true)->get();
        $professions = DepartmentProfession::all();

        if (request()->ajax()) {
            return response()->view('admin.partials.employeelist', [
                'employees' => $employees,
                'departments' => $departments,
                'professions' => $professions
            ]);
        }
        
        return view('admin.employees.index', [
            'title' => 'Employee Management',
            'user' => $user,
            'role' => 'Super Admin',
            'employees' => $employees,
            'departments' => $departments,
            'professions' => $professions
        ]);
    }

    /**
     * Check if user has admin privileges
     */
    private function isAdmin($user)
    {
        return true;
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('admin.employees.index');
    }

    /**
     * Store a newly created employee in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                // Personal Information
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:employees,email',
                'phone' => 'required|string|max:20',
                'employee_id' => 'required|string|unique:employees,employee_id',
                'date_of_birth' => 'nullable|date',
                'gender' => 'nullable|string|in:male,female,other',
                'national_id' => 'nullable|string|max:50',
                'marital_status' => 'nullable|string|in:single,married,divorced,widowed',
                'emergency_contact' => 'nullable|string|max:255',
                'address' => 'nullable|string',
                
                // Employment Information
                'department' => 'required|string',
                'profession' => 'required|string',
                'employment_type' => 'required|string|in:full_time,part_time,contract,internship',
                'employee_status' => 'nullable|string|in:active,on_leave,terminated',
                'work_location' => 'nullable|string|max:255',
                'join_date' => 'nullable|date',
                
                // Financial Information
                'salary' => 'nullable|numeric|min:0',
                'salary_currency' => 'nullable|string|in:TZS,USD',
                'bank_name' => 'nullable|string|max:100',
                'bank_account_number' => 'nullable|string|max:50',
                'bank_account_name' => 'nullable|string|max:255',
                'last_salary_increment_date' => 'nullable|date',
                'bonus' => 'nullable|numeric|min:0',
                'bonus_currency' => 'nullable|string|in:TZS,USD',
                'commission' => 'nullable|numeric|min:0',
                'commission_currency' => 'nullable|string|in:TZS,USD',
                'allowances' => 'nullable|numeric|min:0',
                'allowances_currency' => 'nullable|string|in:TZS,USD',
                
                // Other
                'notes' => 'nullable|string',
                'is_active' => 'nullable|boolean',
                
                // ========== ADDED: Profile Photo Upload ==========
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // ========== FIXED: Handle Profile Photo Upload with your folder structure ==========
            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                // Store in your existing employee_photos folder
                $path = $file->store('employee_photos', 'public');
                $validated['profile_photo_url'] = $path;
            }
            
            // Set default values
            $validated['is_active'] = $request->input('is_active', true);
            $validated['employee_status'] = $request->input('employee_status', 'active');
            $validated['productivity'] = 75;
            
            // Set default currencies if not provided
            $validated['salary_currency'] = $request->input('salary_currency', 'TZS');
            $validated['bonus_currency'] = $request->input('bonus_currency', 'TZS');
            $validated['commission_currency'] = $request->input('commission_currency', 'TZS');
            $validated['allowances_currency'] = $request->input('allowances_currency', 'TZS');
            
            // Initialize JSON fields
            $validated['key_performance_indicators'] = [];
            $validated['documents'] = [];

            $employee = Employee::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Employee added successfully!',
                'employee' => $employee
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Employee creation error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error adding employee: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display employee profile page
     */
    public function profile(Employee $employee): View
    {
        $user = Auth::user();
        
        return view('admin.employees.profile', [
            'title' => $employee->name . ' - Employee Profile',
            'user' => $user,
            'role' => 'Super Admin',
            'employee' => $employee,
            'currencies' => Employee::getCurrencies(),
            'departments' => Department::where('is_active', true)->get(),
            'professions' => DepartmentProfession::all()
        ]);
    }

    /**
     * Update employee profile
     */
    public function updateProfile(Request $request, Employee $employee): JsonResponse
    {
        try {
            $validated = $request->validate([
                // Personal Information
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|unique:employees,email,' . $employee->id,
                'phone' => 'sometimes|required|string|max:20',
                'date_of_birth' => 'nullable|date',
                'gender' => 'nullable|string|in:male,female,other',
                'national_id' => 'nullable|string|max:50',
                'marital_status' => 'nullable|string|in:single,married,divorced,widowed',
                'emergency_contact' => 'nullable|string|max:255',
                'address' => 'nullable|string',
                
                // Employment Details
                'department' => 'sometimes|required|string',
                'profession' => 'sometimes|required|string',
                'employment_type' => 'sometimes|required|string|in:full_time,part_time,contract,internship',
                'employee_status' => 'sometimes|required|string|in:active,on_leave,terminated',
                'work_location' => 'nullable|string|max:255',
                'join_date' => 'nullable|date',
                
                // Work Performance
                'productivity' => 'nullable|integer|min:0|max:100',
                
                // Financial Information
                'salary' => 'nullable|numeric|min:0',
                'salary_currency' => 'nullable|string|in:TZS,USD',
                'bank_name' => 'nullable|string|max:100',
                'bank_account_number' => 'nullable|string|max:50',
                'bank_account_name' => 'nullable|string|max:255',
                'last_salary_increment_date' => 'nullable|date',
                'bonus' => 'nullable|numeric|min:0',
                'bonus_currency' => 'nullable|string|in:TZS,USD',
                'commission' => 'nullable|numeric|min:0',
                'commission_currency' => 'nullable|string|in:TZS,USD',
                'allowances' => 'nullable|numeric|min:0',
                'allowances_currency' => 'nullable|string|in:TZS,USD',
                
                // Notes
                'notes' => 'nullable|string',
            ]);

            $employee->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully!',
                'employee' => $employee
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Profile update error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error updating profile: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add KPI to employee
     */
    public function addKpi(Request $request, Employee $employee): JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'value' => 'nullable|string|max:255',
                'target' => 'nullable|string|max:255',
                'description' => 'nullable|string'
            ]);

            $kpis = $employee->key_performance_indicators ?? [];
            $kpis[] = [
                'id' => uniqid(),
                'name' => $request->name,
                'value' => $request->value,
                'target' => $request->target,
                'description' => $request->description,
                'created_at' => now()->toISOString()
            ];

            $employee->update(['key_performance_indicators' => $kpis]);

            return response()->json([
                'success' => true,
                'message' => 'KPI added successfully!',
                'kpis' => $kpis
            ]);

        } catch (\Exception $e) {
            Log::error('Add KPI error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error adding KPI: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove KPI from employee
     */
    public function removeKpi(Request $request, Employee $employee): JsonResponse
    {
        try {
            $request->validate([
                'kpi_id' => 'required|string'
            ]);

            $kpis = $employee->key_performance_indicators ?? [];
            $kpis = array_filter($kpis, function($kpi) use ($request) {
                return $kpi['id'] !== $request->kpi_id;
            });

            $employee->update(['key_performance_indicators' => array_values($kpis)]);

            return response()->json([
                'success' => true,
                'message' => 'KPI removed successfully!',
                'kpis' => $kpis
            ]);

        } catch (\Exception $e) {
            Log::error('Remove KPI error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error removing KPI: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload document for employee
     */
    public function uploadDocument(Request $request, Employee $employee): JsonResponse
    {
        try {
            Log::info('Upload document request received', [
                'employee_id' => $employee->id,
                'file_name' => $request->file('document')?->getClientOriginalName()
            ]);

            $request->validate([
                'name' => 'required|string|max:255',
                'document' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
            ]);

            $documentFile = $request->file('document');
            $originalName = $documentFile->getClientOriginalName();
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $originalName);
            
            // Create directory if it doesn't exist
            $directory = 'employee_documents/' . $employee->id;
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }
            
            // Store file
            $path = $documentFile->storeAs($directory, $fileName, 'public');
            
            if (!$path) {
                throw new \Exception('Failed to store file');
            }
            
            Log::info('File stored successfully', ['path' => $path]);

            // Get file extension for MIME type
            $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $documentId = uniqid();

            $newDocument = [
                'id' => $documentId,
                'name' => $request->name,
                'file_name' => $fileName,
                'original_name' => $originalName,
                'path' => $path,
                'url' => route('admin.employees.documents.view', ['employee' => $employee->id, 'documentId' => $documentId]),
                'uploaded_at' => now()->toISOString(),
                'size' => $documentFile->getSize(),
                'type' => $this->getMimeTypeFromExtension($extension),
            ];
            
            $documents = $employee->documents ?? [];
            $documents[] = $newDocument;

            $employee->update(['documents' => $documents]);

            Log::info('Document saved to database', ['document_id' => $documentId]);

            return response()->json([
                'success' => true,
                'message' => 'Document uploaded successfully!',
                'document' => $newDocument
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Upload validation error', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . implode(', ', array_map(function ($errors) {
                    return implode(', ', $errors);
                }, $e->errors()))
            ], 422);
        } catch (\Exception $e) {
            Log::error('Upload document error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error uploading document: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * View/download document for employee
     */
    public function viewDocument(Employee $employee, $documentId)
    {
        try {
            Log::info('View document request', [
                'employee_id' => $employee->id,
                'document_id' => $documentId
            ]);

            $documents = $employee->documents ?? [];
            
            foreach ($documents as $document) {
                if (isset($document['id']) && $document['id'] == $documentId) {
                    if (isset($document['path'])) {
                        $fullPath = storage_path('app/public/' . $document['path']);
                        
                        Log::info('Checking document path', [
                            'stored_path' => $document['path'],
                            'full_path' => $fullPath,
                            'exists' => file_exists($fullPath)
                        ]);
                        
                        if (file_exists($fullPath)) {
                            $fileName = $document['original_name'] ?? $document['file_name'] ?? 'document';
                            $mimeType = $document['type'] ?? $this->getMimeTypeFromExtension(pathinfo($fullPath, PATHINFO_EXTENSION));
                            
                            Log::info('Serving document', [
                                'file_name' => $fileName,
                                'mime_type' => $mimeType
                            ]);
                            
                            return response()->file($fullPath, [
                                'Content-Type' => $mimeType,
                                'Content-Disposition' => 'inline; filename="' . $fileName . '"'
                            ]);
                        } else {
                            Log::error('Document file not found on disk', ['path' => $fullPath]);
                            abort(404, 'Document file not found on disk');
                        }
                    }
                }
            }
            
            Log::error('Document not found in database', ['document_id' => $documentId]);
            abort(404, 'Document not found in database');
            
        } catch (\Exception $e) {
            Log::error('View document error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Error accessing document: ' . $e->getMessage());
        }
    }

    /**
     * Remove document from employee
     */
    public function removeDocument(Request $request, Employee $employee): JsonResponse
    {
        try {
            $request->validate([
                'document_id' => 'required|string'
            ]);

            $documents = $employee->documents ?? [];
            $documentFound = false;
            
            foreach ($documents as $index => $document) {
                if (isset($document['id']) && $document['id'] == $request->document_id) {
                    if (isset($document['path'])) {
                        Storage::disk('public')->delete($document['path']);
                    }
                    unset($documents[$index]);
                    $documentFound = true;
                    break;
                }
            }
            
            if (!$documentFound) {
                return response()->json([
                    'success' => false,
                    'message' => 'Document not found'
                ], 404);
            }
            
            // Re-index array
            $documents = array_values($documents);

            $employee->update(['documents' => $documents]);

            return response()->json([
                'success' => true,
                'message' => 'Document removed successfully!',
                'documents' => $documents
            ]);

        } catch (\Exception $e) {
            Log::error('Remove document error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error removing document: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export employee profile to PDF
     */
    public function exportPdf(Employee $employee)
    {
        try {
            $data = [
                'employee' => $employee,
                'title' => $employee->name . ' Profile - ' . date('Y-m-d')
            ];

            // Prepare profile image as base64 so DomPDF can embed it reliably
            $imageData = null;
            try {
                $rawPath = $employee->getAttributes()['profile_photo_url'] ?? null;
                if ($rawPath) {
                    // If stored in public disk (relative path)
                    if (Storage::disk('public')->exists($rawPath)) {
                        $fullPath = Storage::disk('public')->path($rawPath);
                        $contents = @file_get_contents($fullPath);
                    } else {
                        // Try to fetch the accessor URL (may be absolute)
                        $contents = @file_get_contents($employee->profile_photo_url);
                    }

                    if (!empty($contents)) {
                        $finfo = finfo_open();
                        $mime = finfo_buffer($finfo, $contents, FILEINFO_MIME_TYPE) ?: 'image/jpeg';
                        $imageData = 'data:' . $mime . ';base64,' . base64_encode($contents);
                    }
                }
            } catch (\Throwable $ex) {
                Log::warning('Could not prepare profile image for PDF: ' . $ex->getMessage());
                $imageData = null;
            }

            $data['profileImageData'] = $imageData;

            $pdf = Pdf::loadView('admin.employees.export.pdf', $data);
            
            return $pdf->download($employee->name . '-profile-' . date('Y-m-d') . '.pdf');
            
        } catch (\Exception $e) {
            Log::error('PDF export error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export employee profile to Excel
     */
    public function exportExcel(Employee $employee)
    {
        try {
            return Excel::download(new EmployeeExport($employee), $employee->name . '-profile-' . date('Y-m-d') . '.xlsx');
            
        } catch (\Exception $e) {
            Log::error('Excel export error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate Excel: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate comprehensive employee report
     */
    public function generateReport(Employee $employee)
    {
        try {
            $data = [
                'employee' => $employee,
                'report_date' => now(),
                'summary' => [
                    'personal_info' => true,
                    'employment_details' => true,
                    'financial_info' => true,
                    'performance_data' => true,
                    'documents_summary' => count($employee->documents ?? []),
                    'kpis_summary' => count($employee->key_performance_indicators ?? [])
                ]
            ];
            
            $pdf = Pdf::loadView('admin.employees.report.comprehensive', $data);
            
            return $pdf->download($employee->name . '-comprehensive-report-' . date('Y-m-d') . '.pdf');
            
        } catch (\Exception $e) {
            Log::error('Report generation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate report: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle employee status
     */
    public function toggleStatus(Employee $employee): JsonResponse
    {
        try {
            $newStatus = !$employee->is_active;
            $employee->update(['is_active' => $newStatus]);

            return response()->json([
                'success' => true,
                'message' => 'Employee ' . ($newStatus ? 'activated' : 'deactivated') . ' successfully!',
                'is_active' => $newStatus
            ]);

        } catch (\Exception $e) {
            Log::error('Toggle status error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error toggling status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified employee.
     */
    public function show(Employee $employee): View
    {
        $user = Auth::user();
        
        return view('admin.employees.show', [
            'title' => 'Employee Details - ' . $employee->name,
            'user' => $user,
            'role' => 'Super Admin',
            'employee' => $employee
        ]);
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(Employee $employee): View
    {
        $user = Auth::user();
        
        return view('admin.employees.edit', [
            'title' => 'Edit Employee - ' . $employee->name,
            'user' => $user,
            'role' => 'Super Admin',
            'employee' => $employee,
            'currencies' => Employee::getCurrencies()
        ]);
    }

    /**
     * Update the specified employee in storage.
     */
    public function update(Request $request, Employee $employee): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:employees,email,' . $employee->id,
                'phone' => 'required|string|max:20',
                'employee_id' => 'required|string|unique:employees,employee_id,' . $employee->id,
                'date_of_birth' => 'nullable|date',
                'gender' => 'nullable|string|in:male,female,other',
                'national_id' => 'nullable|string|max:50',
                'marital_status' => 'nullable|string|in:single,married,divorced,widowed',
                'emergency_contact' => 'nullable|string|max:255',
                'address' => 'nullable|string',
                
                'department' => 'required|string',
                'profession' => 'required|string',
                'employment_type' => 'required|string|in:full_time,part_time,contract,internship',
                'employee_status' => 'nullable|string|in:active,on_leave,terminated',
                'work_location' => 'nullable|string|max:255',
                'join_date' => 'nullable|date',
                
                'salary' => 'nullable|numeric|min:0',
                'salary_currency' => 'nullable|string|in:TZS,USD',
                'bank_name' => 'nullable|string|max:100',
                'bank_account_number' => 'nullable|string|max:50',
                'bank_account_name' => 'nullable|string|max:255',
                'last_salary_increment_date' => 'nullable|date',
                'bonus' => 'nullable|numeric|min:0',
                'bonus_currency' => 'nullable|string|in:TZS,USD',
                'commission' => 'nullable|numeric|min:0',
                'commission_currency' => 'nullable|string|in:TZS,USD',
                'allowances' => 'nullable|numeric|min:0',
                'allowances_currency' => 'nullable|string|in:TZS,USD',
                
                'productivity' => 'nullable|integer|min:0|max:100',
                
                'notes' => 'nullable|string',
                
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                
                if ($employee->profile_photo_url && strpos($employee->profile_photo_url, 'storage/') !== false) {
                    $oldPhoto = str_replace(asset('storage/'), '', $employee->profile_photo_url);
                    if (Storage::disk('public')->exists($oldPhoto)) {
                        Storage::disk('public')->delete($oldPhoto);
                    }
                }
                
                $path = $file->store('employee_photos', 'public');
                $validated['profile_photo_url'] = $path;
            }
            
            if (!empty($validated['date_of_birth'])) {
                $validated['date_of_birth'] = date('Y-m-d', strtotime($validated['date_of_birth']));
            }
            if (!empty($validated['join_date'])) {
                $validated['join_date'] = date('Y-m-d', strtotime($validated['join_date']));
            }
            if (!empty($validated['last_salary_increment_date'])) {
                $validated['last_salary_increment_date'] = date('Y-m-d', strtotime($validated['last_salary_increment_date']));
            }

            $employee->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Employee updated successfully!',
                'employee' => $employee
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Employee update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating employee: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ========== ADDED: Get MIME type from file extension ==========
     * Helper method to get MIME type from file extension
     */
    private function getMimeTypeFromExtension($extension)
    {
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'txt' => 'text/plain',
            'csv' => 'text/csv',
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        ];
        
        $extension = strtolower($extension);
        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }

    /**
     * Generate employee ID based on department name
     */
    public function generateEmployeeId($departmentName): JsonResponse
    {
        try {
            // Get department by name
            $deptModel = Department::where('name', $departmentName)->first();
            
            if (!$deptModel) {
                return response()->json([
                    'success' => false,
                    'message' => 'Department not found'
                ], 404);
            }
            
            // Get the department code
            $deptCode = $deptModel->code;
            
            // Count existing employees in this department
            $employeeCount = Employee::where('department', $departmentName)->count();
            
            // Generate the next ID
            $nextNumber = $employeeCount + 1;
            $employeeId = $deptCode . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            
            return response()->json([
                'success' => true,
                'employee_id' => $employeeId
            ]);
            
        } catch (\Exception $e) {
            Log::error('Employee ID generation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate employee ID: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified employee from storage.
     */
    public function destroy(Employee $employee): JsonResponse
    {
        try {
            if ($employee->profile_photo_url && strpos($employee->profile_photo_url, 'storage/') !== false) {
                $oldPhoto = str_replace(asset('storage/'), '', $employee->profile_photo_url);
                if (Storage::disk('public')->exists($oldPhoto)) {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }
            
            $documents = $employee->documents ?? [];
            foreach ($documents as $document) {
                if (isset($document['path']) && Storage::disk('public')->exists($document['path'])) {
                    Storage::disk('public')->delete($document['path']);
                }
            }
            
            $employeeDocumentFolder = 'employee_documents/' . $employee->id;
            if (Storage::disk('public')->exists($employeeDocumentFolder)) {
                Storage::disk('public')->deleteDirectory($employeeDocumentFolder);
            }
            
            $employeeName = $employee->name;
            
            $employee->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Employee "' . $employeeName . '" has been deleted successfully.'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Employee deletion error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete employee: ' . $e->getMessage()
            ], 500);
        }
    }
}