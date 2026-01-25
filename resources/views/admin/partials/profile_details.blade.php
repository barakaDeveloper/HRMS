<!-- Employee Profile Content -->
<div class="p-4 sm:p-6">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.employees.index') }}" class="chip flex items-center gap-2 w-fit hover:bg-[var(--hover-bg)] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Employees
        </a>
    </div>

    <!-- Employee Profile Header -->
    <div class="panel p-4 sm:p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 sm:gap-6">
            <!-- Profile Info Section -->
            <div class="flex items-center gap-3 sm:gap-4">
                <img src="{{ $employee->profile_photo_url }}" 
                     alt="{{ $employee->name }}" 
                     class="w-16 h-16 sm:w-20 sm:h-20 rounded-full border-4 border-[var(--border-color)] flex-shrink-0">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl font-bold logo-text truncate">{{ $employee->name }}</h1>
                    <!-- Status Chips -->
                    <div class="flex flex-wrap items-center gap-2 mt-2">
                        <span class="chip text-xs sm:text-sm whitespace-nowrap">{{ $employee->profession }}</span>
                        <span class="chip text-xs sm:text-sm whitespace-nowrap">{{ $employee->department }}</span>
                        <span class="chip text-xs sm:text-sm whitespace-nowrap
                            @if($employee->employee_status == 'active') bg-green-500/20 text-green-600 border-green-500/30
                            @elseif($employee->employee_status == 'on_leave') bg-yellow-500/20 text-yellow-600 border-yellow-500/30
                            @else bg-red-500/20 text-red-600 border-red-500/30
                            @endif">
                            {{ $employee->formatted_employee_status ?? ucfirst(str_replace('_', ' ', $employee->employee_status ?? 'Not set')) }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 md:flex-shrink-0">
                <button onclick="exportProfile()" class="chip flex items-center justify-center gap-2 hover:bg-[var(--hover-bg)] transition-colors whitespace-nowrap px-4 py-2.5 sm:py-2 text-sm sm:text-base">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export
                </button>
                <button onclick="openEditModal()" class="chip flex items-center justify-center gap-2 bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] transition-colors whitespace-nowrap px-4 py-2.5 sm:py-2 text-sm sm:text-base">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Profile
                </button>
            </div>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Personal Info & Employment -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information Card -->
            <div class="panel p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold logo-text">Personal Information</h2>
                    <span class="chip text-sm">{{ $employee->employee_id }}</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-[var(--muted)] mb-1">Full Name</label>
                            <p class="chip bg-transparent border-none p-0">{{ $employee->name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-[var(--muted)] mb-1">Date of Birth</label>
                            <p class="chip bg-transparent border-none p-0">
                                @if($employee->date_of_birth)
                                    {{ $employee->date_of_birth->format('F d, Y') }}
                                    @if($employee->age)
                                        <span class="text-[var(--muted)] ml-2">({{ $employee->age }} years)</span>
                                    @endif
                                @else
                                    Not set
                                @endif
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-[var(--muted)] mb-1">Gender</label>
                            <p class="chip bg-transparent border-none p-0">{{ ucfirst($employee->gender ?? 'Not set') }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-[var(--muted)] mb-1">National ID</label>
                            <p class="chip bg-transparent border-none p-0">{{ $employee->national_id ?? 'Not set' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-[var(--muted)] mb-1">Marital Status</label>
                            <p class="chip bg-transparent border-none p-0">{{ $employee->formatted_marital_status ?? ucfirst($employee->marital_status ?? 'Not set') }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-[var(--muted)] mb-1">Email Address</label>
                            <p class="chip bg-transparent border-none p-0">
                                <a href="mailto:{{ $employee->email }}" class="text-[var(--g-spring)] hover:underline">{{ $employee->email }}</a>
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-[var(--muted)] mb-1">Phone Number</label>
                            <p class="chip bg-transparent border-none p-0">
                                <a href="tel:{{ $employee->phone }}" class="text-[var(--g-spring)] hover:underline">{{ $employee->phone }}</a>
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-[var(--muted)] mb-1">Emergency Contact</label>
                            <p class="chip bg-transparent border-none p-0">{{ $employee->emergency_contact ?? 'Not set' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-[var(--muted)] mb-1">Address</label>
                            <p class="chip bg-transparent border-none p-0">{{ $employee->address ?? 'Not set' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Employment Details Card -->
            <div class="panel p-6">
                <h2 class="text-xl font-bold logo-text mb-6">Employment Details</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-[var(--muted)] mb-1">Department</label>
                            <p class="chip bg-transparent border-none p-0">{{ $employee->department }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-[var(--muted)] mb-1">Profession/Title</label>
                            <p class="chip bg-transparent border-none p-0">{{ $employee->profession }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-[var(--muted)] mb-1">Employment Type</label>
                            <p class="chip bg-transparent border-none p-0">{{ $employee->formatted_employment_type ?? ucfirst(str_replace('_', ' ', $employee->employment_type ?? 'Not set')) }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-[var(--muted)] mb-1">Date Joined</label>
                            <p class="chip bg-transparent border-none p-0">
                                @if($employee->join_date)
                                    {{ $employee->join_date->format('F d, Y') }}
                                    @if($employee->years_of_service)
                                        <span class="text-[var(--muted)] ml-2">({{ $employee->years_of_service }} years)</span>
                                    @endif
                                @else
                                    Not set
                                @endif
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-[var(--muted)] mb-1">Work Location</label>
                            <p class="chip bg-transparent border-none p-0">{{ $employee->work_location ?? 'Not set' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-[var(--muted)] mb-1">Employee Status</label>
                            <p class="chip text-sm 
                                @if($employee->employee_status == 'active') bg-green-500/20 text-green-600 border-green-500/30
                                @elseif($employee->employee_status == 'on_leave') bg-yellow-500/20 text-yellow-600 border-yellow-500/30
                                @else bg-red-500/20 text-red-600 border-red-500/30
                                @endif w-fit">
                                {{ $employee->formatted_employee_status ?? ucfirst(str_replace('_', ' ', $employee->employee_status ?? 'Not set')) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Work Performance Card -->
            <div class="panel p-6">
                <h2 class="text-xl font-bold logo-text mb-6">Work Performance</h2>
                
                <div class="space-y-6">
                    <!-- Productivity -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-medium text-[var(--muted)]">Productivity Score</label>
                            <span class="text-lg font-semibold">{{ $employee->productivity ?? 0 }}%</span>
                        </div>
                        <div class="w-full h-3 rounded-full bg-[var(--chip-bg)] overflow-hidden">
                            <div class="h-3 
                                @if(($employee->productivity ?? 0) >= 85) bg-green-500
                                @elseif(($employee->productivity ?? 0) >= 70) bg-yellow-500
                                @else bg-red-500
                                @endif rounded-full" 
                                style="width: {{ min($employee->productivity ?? 0, 100) }}%">
                            </div>
                        </div>
                        <div class="flex justify-between text-xs text-[var(--muted)] mt-1">
                            <span>0%</span>
                            <span>50%</span>
                            <span>100%</span>
                        </div>
                    </div>
                    
                    <!-- Key Performance Indicators -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <label class="block text-sm font-medium text-[var(--muted)]">Key Performance Indicators</label>
                            <button onclick="openKpiModal()" class="chip text-xs hover:bg-[var(--hover-bg)] transition-colors">
                                + Add KPI
                            </button>
                        </div>
                        @php
                            // Safely check for KPIs
                            $hasKpis = false;
                            if (isset($employee->key_performance_indicators) && is_array($employee->key_performance_indicators)) {
                                $filteredKpis = array_filter($employee->key_performance_indicators, function($kpi) {
                                    return is_array($kpi) && isset($kpi['name']);
                                });
                                $hasKpis = !empty($filteredKpis);
                            }
                        @endphp
                        
                        @if($hasKpis)
                            <div class="space-y-2">
                                @foreach($employee->key_performance_indicators as $kpi)
                                    @if(is_array($kpi) && isset($kpi['name']))
                                        <div class="chip flex justify-between items-center hover:bg-[var(--hover-bg)] transition-colors">
                                            <div>
                                                <span class="font-medium">{{ $kpi['name'] }}</span>
                                                @if(!empty($kpi['description']))
                                                    <p class="text-xs text-[var(--muted)] mt-1">{{ $kpi['description'] }}</p>
                                                @endif
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <span class="font-semibold">{{ $kpi['value'] ?? 'N/A' }}</span>
                                                @if(!empty($kpi['target']))
                                                    <span class="text-xs text-[var(--muted)]">Target: {{ $kpi['target'] }}</span>
                                                @endif
                                                <button onclick="removeKpi('{{ $kpi['id'] ?? '' }}')" class="text-red-500 hover:text-red-700 p-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p class="chip bg-transparent border-none p-0 text-center text-[var(--muted)]">No KPIs set</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column - Financial, Documents & Actions -->
        <div class="space-y-6">
            <!-- Financial Information Card -->
            <div class="panel p-6">
                <h2 class="text-xl font-bold logo-text mb-6">Financial Information</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-[var(--muted)] mb-1">Salary</label>
                        <p class="chip bg-transparent border-none p-0 font-semibold text-lg">
                            {{ $employee->salary_with_symbol ?? 'Not set' }}
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-[var(--muted)] mb-1">Allowances</label>
                        <p class="chip bg-transparent border-none p-0">
                            {{ $employee->allowances_with_symbol ?? 'Not set' }}
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-[var(--muted)] mb-1">Bonus</label>
                        <p class="chip bg-transparent border-none p-0">
                            {{ $employee->bonus_with_symbol ?? 'Not set' }}
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-[var(--muted)] mb-1">Commission</label>
                        <p class="chip bg-transparent border-none p-0 font-bold text-lg text-[var(--g-spring)]">
                            {{ $employee->commission_with_symbol ?? 'Not set' }}
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-[var(--muted)] mb-1">Total Earnings</label>
                        @php
                            $breakdown = $employee->total_earnings_by_currency;
                        @endphp
                        
                        @if(count($breakdown) > 1)
                            <div class="flex items-center gap-3 flex-wrap">
                                @foreach($breakdown as $currency => $total)
                                    @if(!$loop->first)
                                        <span class="text-black font-bold text-lg">|</span>
                                    @endif
                                    <p class="chip bg-transparent border-none p-0 font-bold text-lg text-[var(--g-spring)]">
                                        {{ $total }}
                                    </p>
                                @endforeach
                            </div>
                        @elseif(count($breakdown) > 0)
                            <p class="chip bg-transparent border-none p-0 font-bold text-lg text-[var(--g-spring)]">
                                @foreach($breakdown as $total)
                                    {{ $total }}
                                @endforeach
                            </p>
                        @else
                            <p class="chip bg-transparent border-none p-0 font-bold text-lg text-[var(--g-spring)]">
                                {{ $employee->total_earnings_with_symbol ?? 'Not set' }}
                            </p>
                        @endif
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-[var(--muted)] mb-1">Bank Details</label>
                        @if($employee->bank_name)
                            <div class="space-y-2">
                                <p class="chip bg-transparent border-none p-0">{{ $employee->bank_name }}</p>
                                <p class="chip bg-transparent border-none p-0">{{ $employee->bank_account_name ?? 'Not set' }}</p>
                                <p class="chip bg-transparent border-none p-0">{{ $employee->bank_account_number ?? 'Not set' }}</p>
                            </div>
                        @else
                            <p class="chip bg-transparent border-none p-0 text-[var(--muted)]">Not set</p>
                        @endif
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-[var(--muted)] mb-1">Last Salary Increment</label>
                        <p class="chip bg-transparent border-none p-0">
                            @if($employee->last_salary_increment_date)
                                {{ $employee->last_salary_increment_date->format('F d, Y') }}
                            @else
                                Not set
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Documents Card -->
            <div class="panel p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold logo-text">Documents</h2>
                    <button onclick="openDocumentModal()" class="chip text-sm hover:bg-[var(--hover-bg)] transition-colors">
                        + Upload
                    </button>
                </div>
                
                <div class="space-y-3">
                    @php
                        // Safely check for documents
                        $hasDocuments = false;
                        if (isset($employee->documents) && is_array($employee->documents)) {
                            $filteredDocs = array_filter($employee->documents, function($doc) {
                                return is_array($doc) && isset($doc['name']);
                            });
                            $hasDocuments = !empty($filteredDocs);
                        }
                    @endphp
                    
                    @if($hasDocuments)
                        @foreach($employee->documents as $document)
                            @if(is_array($document) && isset($document['name']))
                                @php
                                    $docId = $document['id'] ?? uniqid();
                                    $docUrl = $document['url'] ?? '#';
                                    $uploadedAt = $document['uploaded_at'] ?? now()->toISOString();
                                    $size = $document['size'] ?? 0;
                                @endphp
                                <div class="chip flex items-center justify-between hover:bg-[var(--hover-bg)] transition-colors">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <div>
                                            <span class="text-sm">{{ $document['name'] }}</span>
                                            <p class="text-xs text-[var(--muted)] mt-1">
                                                {{ \Carbon\Carbon::parse($uploadedAt)->format('M d, Y') }} • 
                                                {{ round($size / 1024) }}KB
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        @if($docUrl !== '#')
                                            <a href="{{ $docUrl }}" target="_blank" class="text-[var(--g-spring)] hover:underline text-sm p-1">
                                                View
                                            </a>
                                        @endif
                                        <button onclick="removeDocument('{{ $docId }}')" class="text-red-500 hover:text-red-700 p-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <p class="chip bg-transparent border-none p-0 text-center text-[var(--muted)]">No documents uploaded</p>
                    @endif
                </div>
            </div>
            
            <!-- Quick Actions Card -->
            <div class="panel p-6">
                <h2 class="text-xl font-bold logo-text mb-6">Quick Actions</h2>
                
                <div class="space-y-3">
                    <button onclick="sendMessage()" class="chip w-full flex items-center justify-center gap-2 hover:bg-[var(--hover-bg)] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        Send Message
                    </button>
                    
                    <button onclick="generateReport()" class="chip w-full flex items-center justify-center gap-2 hover:bg-[var(--hover-bg)] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Generate Report
                    </button>
                    
                    <button onclick="deleteEmployee()" class="chip w-full flex items-center justify-center gap-2 bg-red-500/10 text-red-600 hover:bg-red-500/20 border-red-500/20 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete Employee
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal (Comprehensive) -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4 z-50 overflow-y-auto">
    <div class="panel w-full max-w-6xl max-h-[90vh] overflow-y-auto my-8">
        <div class="p-6">
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-[var(--border-color)]">
                <h3 class="text-2xl font-bold logo-text">Edit  <span class="text-green-600">{{ $employee->name }}'s</span>  Profile</h3>
                <button type="button" onclick="closeEditModal()" class="chip hover:bg-[var(--hover-bg)] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Tabs for different sections -->
            <div class="mb-6">
                <div class="flex flex-wrap gap-2 border-b border-[var(--border-color)] pb-4">
                    <button onclick="switchTab('personal')" id="personalTab" class="chip tab-active">Personal Info</button>
                    <button onclick="switchTab('employment')" id="employmentTab" class="chip">Employment</button>
                    <button onclick="switchTab('financial')" id="financialTab" class="chip">Financial</button>
                    <button onclick="switchTab('performance')" id="performanceTab" class="chip">Performance</button>
                </div>
            </div>

            <!-- Edit Form -->
            <form id="editForm" onsubmit="updateEmployee(event)" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Personal Information Tab -->
                <div id="personalTabContent" class="tab-content">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Column 1 -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Full Name *</label>
                                <input type="text" name="name" value="{{ $employee->name }}" required 
                                       class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Email Address *</label>
                                <input type="email" name="email" value="{{ $employee->email }}" required 
                                       class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Phone Number *</label>
                                <input type="tel" name="phone" value="{{ $employee->phone }}" required 
                                       class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Date of Birth</label>
                                <input type="date" name="date_of_birth" 
                                       value="{{ $employee->date_of_birth ? $employee->date_of_birth->format('Y-m-d') : '' }}" 
                                       class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Gender</label>
                                <select name="gender" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ $employee->gender == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ $employee->gender == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ $employee->gender == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Column 2 -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">National ID</label>
                                <input type="text" name="national_id" value="{{ $employee->national_id ?? '' }}" 
                                       class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Marital Status</label>
                                <select name="marital_status" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                                    <option value="">Select Status</option>
                                    <option value="single" {{ $employee->marital_status == 'single' ? 'selected' : '' }}>Single</option>
                                    <option value="married" {{ $employee->marital_status == 'married' ? 'selected' : '' }}>Married</option>
                                    <option value="divorced" {{ $employee->marital_status == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                    <option value="widowed" {{ $employee->marital_status == 'widowed' ? 'selected' : '' }}>Widowed</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Emergency Contact</label>
                                <input type="text" name="emergency_contact" value="{{ $employee->emergency_contact ?? '' }}" 
                                       class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Address</label>
                                <textarea name="address" rows="3" 
                                          class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">{{ $employee->address ?? '' }}</textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Profile Photo</label>
                                <input type="file" name="profile_photo" accept="image/*" 
                                       class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                                @if($employee->profile_photo_url)
                                    <div class="mt-2 flex items-center gap-3">
                                        <img src="{{ $employee->profile_photo_url }}" alt="Current" class="w-12 h-12 rounded-full">
                                        <span class="text-sm text-[var(--muted)]">Current photo</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Employment Tab -->
                <div id="employmentTabContent" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Column 1 -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Employee ID</label>
                                <input type="text" name="employee_id" value="{{ $employee->employee_id }}" 
                                       class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Department *</label>
                                <select id="departmentSelect" name="department" required class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->name }}" data-id="{{ $department->id }}" {{ $employee->department == $department->name ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Profession/Title *</label>
                                <select id="professionSelect" name="profession" required class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                                    <option value="">Select Profession/Title</option>
                                    @php
                                        $currentDepartmentId = null;
                                        if($employee->department) {
                                            $currentDepartmentId = $departments->firstWhere('name', $employee->department)?->id;
                                        }
                                    @endphp
                                    @if($currentDepartmentId)
                                        @foreach($professions as $profession)
                                            @if($profession->department_id == $currentDepartmentId)
                                                <option value="{{ $profession->name }}" {{ $employee->profession == $profession->name ? 'selected' : '' }}>
                                                    {{ $profession->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Employment Type</label>
                                <select name="employment_type" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                                    <option value="full_time" {{ $employee->employment_type == 'full_time' ? 'selected' : '' }}>Full Time</option>
                                    <option value="part_time" {{ $employee->employment_type == 'part_time' ? 'selected' : '' }}>Part Time</option>
                                    <option value="contract" {{ $employee->employment_type == 'contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="internship" {{ $employee->employment_type == 'internship' ? 'selected' : '' }}>Internship</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Column 2 -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Date Joined</label>
                                <input type="date" name="join_date" 
                                       value="{{ $employee->join_date ? $employee->join_date->format('Y-m-d') : '' }}" 
                                       class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Work Location</label>
                                <input type="text" name="work_location" value="{{ $employee->work_location ?? '' }}" 
                                       class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Employee Status</label>
                                <select name="employee_status" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                                    <option value="active" {{ $employee->employee_status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="on_leave" {{ $employee->employee_status == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                                    <option value="terminated" {{ $employee->employee_status == 'terminated' ? 'selected' : '' }}>Terminated</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Notes</label>
                                <textarea name="notes" rows="3" 
                                          class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">{{ $employee->notes ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Financial Tab -->
                <div id="financialTabContent" class="tab-content hidden">
                    <div class="space-y-6">
                        <!-- Salary Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Basic Salary</label>
                                <input type="number" step="0.01" name="salary" value="{{ $employee->salary ?? '' }}" 
                                       class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Currency</label>
                                <select name="salary_currency" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                                    <option value="TZS" {{ $employee->salary_currency == 'TZS' ? 'selected' : '' }}>TZS</option>
                                    <option value="USD" {{ $employee->salary_currency == 'USD' ? 'selected' : '' }}>USD</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Allowances Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Allowances</label>
                                <input type="number" step="0.01" name="allowances" value="{{ $employee->allowances ?? '' }}" 
                                       class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Currency</label>
                                <select name="allowances_currency" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                                    <option value="TZS" {{ $employee->allowances_currency == 'TZS' ? 'selected' : '' }}>TZS</option>
                                    <option value="USD" {{ $employee->allowances_currency == 'USD' ? 'selected' : '' }}>USD</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Bonus Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Bonus</label>
                                <input type="number" step="0.01" name="bonus" value="{{ $employee->bonus ?? '' }}" 
                                       class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Currency</label>
                                <select name="bonus_currency" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                                    <option value="TZS" {{ $employee->bonus_currency == 'TZS' ? 'selected' : '' }}>TZS</option>
                                    <option value="USD" {{ $employee->bonus_currency == 'USD' ? 'selected' : '' }}>USD</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Commission Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Commission</label>
                                <input type="number" step="0.01" name="commission" value="{{ $employee->commission ?? '' }}" 
                                       class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Currency</label>
                                <select name="commission_currency" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                                    <option value="TZS" {{ $employee->commission_currency == 'TZS' ? 'selected' : '' }}>TZS</option>
                                    <option value="USD" {{ $employee->commission_currency == 'USD' ? 'selected' : '' }}>USD</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Bank Details Section -->
                        <div class="border-t border-[var(--border-color)] pt-6 mt-6">
                            <h4 class="text-lg font-semibold mb-4">Bank Details</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Bank Name</label>
                                    <input type="text" name="bank_name" value="{{ $employee->bank_name ?? '' }}" 
                                           class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Account Name</label>
                                    <input type="text" name="bank_account_name" value="{{ $employee->bank_account_name ?? '' }}" 
                                           class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Account Number</label>
                                    <input type="text" name="bank_account_number" value="{{ $employee->bank_account_number ?? '' }}" 
                                           class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Last Salary Increment</label>
                                    <input type="date" name="last_salary_increment_date" 
                                           value="{{ $employee->last_salary_increment_date ? $employee->last_salary_increment_date->format('Y-m-d') : '' }}" 
                                           class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Performance Tab -->
                <div id="performanceTabContent" class="tab-content hidden">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Productivity Score (%)</label>
                            <input type="number" min="0" max="100" name="productivity" value="{{ $employee->productivity ?? 0 }}" 
                                   class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                        </div>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="flex gap-3 justify-end mt-8 pt-6 border-t border-[var(--border-color)]">
                    <button type="button" onclick="closeEditModal()" class="chip px-6 py-2 hover:bg-[var(--hover-bg)] transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="chip px-6 py-2 bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] transition-colors">
                        Save All Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- KPI Modal -->
<div id="kpiModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4 z-50">
    <div class="panel w-full max-w-md">
        <div class="p-6">
            <h3 class="text-xl font-bold logo-text mb-4">Add KPI</h3>
            <form id="kpiForm" onsubmit="submitKpi(event)">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">KPI Name *</label>
                        <input type="text" name="name" required class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Current Value</label>
                        <input type="text" name="value" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Target Value</label>
                        <input type="text" name="target" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Description</label>
                        <textarea name="description" rows="3" class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]"></textarea>
                    </div>
                </div>
                <div class="flex gap-3 justify-end mt-6 pt-4 border-t border-[var(--border-color)]">
                    <button type="button" onclick="closeKpiModal()" class="chip px-6 py-2 hover:bg-[var(--hover-bg)] transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="chip px-6 py-2 bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] transition-colors">
                        Add KPI
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Document Upload Modal -->
<div id="documentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4 z-50">
    <div class="panel w-full max-w-md">
        <div class="p-6">
            <h3 class="text-xl font-bold logo-text mb-4">Upload Document</h3>
            <form id="documentForm" onsubmit="submitDocument(event)" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Document Name *</label>
                        <input type="text" name="name" required class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[var(--accent-text)] mb-2">Document File *</label>
                        <input type="file" name="document" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" 
                               class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)]">
                    </div>
                </div>
                <div class="flex gap-3 justify-end mt-6 pt-4 border-t border-[var(--border-color)]">
                    <button type="button" onclick="closeDocumentModal()" class="chip px-6 py-2 hover:bg-[var(--hover-bg)] transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="chip px-6 py-2 bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] transition-colors">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    console.log('Employee Profile Page Loaded');
    
    // Profile JavaScript functions
    const employeeId = {{ $employee->id }};
    const employeeName = '{{ addslashes($employee->name) }}';
    const baseUrl = '/admin/employees/' + employeeId;

    // ==================== UTILITY FUNCTIONS ====================
    function showLoading(message = 'Processing...') {
        Swal.fire({
            title: message,
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    function showSuccess(message, reload = true) {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: message,
            showConfirmButton: true,
            timer: 2000
        }).then(() => {
            if (reload) {
                location.reload();
            }
        });
    }

    function showError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: message,
            showConfirmButton: true
        });
    }

    // ==================== TAB MANAGEMENT ====================
    function switchTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        
        // Remove active class from all tabs
        document.querySelectorAll('.chip').forEach(tab => {
            tab.classList.remove('tab-active');
        });
        
        // Show selected tab content
        document.getElementById(tabName + 'TabContent').classList.remove('hidden');
        
        // Add active class to selected tab
        document.getElementById(tabName + 'Tab').classList.add('tab-active');
    }

    // ==================== MODAL FUNCTIONS ====================
    function openEditModal() {
        const modal = document.getElementById('editModal');
        modal.style.display = 'flex';
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Reset to first tab
        switchTab('personal');
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        modal.style.display = 'none';
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    function openKpiModal() {
        const modal = document.getElementById('kpiModal');
        modal.style.display = 'flex';
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeKpiModal() {
        const modal = document.getElementById('kpiModal');
        modal.style.display = 'none';
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        document.getElementById('kpiForm').reset();
    }

    function openDocumentModal() {
        const modal = document.getElementById('documentModal');
        modal.style.display = 'flex';
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDocumentModal() {
        const modal = document.getElementById('documentModal');
        modal.style.display = 'none';
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        document.getElementById('documentForm').reset();
    }

    // ==================== FORM SUBMISSION ====================
    function updateEmployee(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        
        showLoading('Updating employee information...');
        
        fetch(baseUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-HTTP-Method-Override': 'PUT'
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            Swal.close();
            if (data.success) {
                showSuccess(data.message || 'Employee information updated successfully!', true);
                closeEditModal();
            } else {
                showError(data.message || 'Failed to update employee information');
            }
        })
        .catch(error => {
            Swal.close();
            console.error('Update error:', error);
            showError('Failed to update employee information. Please try again.');
        });
    }

    function submitKpi(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        
        showLoading('Adding KPI...');
        
        fetch(baseUrl + '/add-kpi', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(Object.fromEntries(formData))
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            Swal.close();
            if (data.success) {
                showSuccess(data.message || 'KPI added successfully!');
                closeKpiModal();
            } else {
                showError(data.message || 'Failed to add KPI');
            }
        })
        .catch(error => {
            Swal.close();
            console.error('KPI error:', error);
            showError('Failed to add KPI. Please try again.');
        });
    }

    function submitDocument(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        
        showLoading('Uploading document...');
        
        fetch(baseUrl + '/upload-document', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            Swal.close();
            if (data.success) {
                showSuccess(data.message || 'Document uploaded successfully!');
                closeDocumentModal();
            } else {
                showError(data.message || 'Failed to upload document');
            }
        })
        .catch(error => {
            Swal.close();
            console.error('Document upload error:', error);
            showError('Failed to upload document. Please try again.');
        });
    }

    function removeKpi(kpiId) {
        Swal.fire({
            title: 'Remove KPI',
            text: 'Are you sure you want to remove this KPI?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, remove it',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch(baseUrl + '/remove-kpi', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ kpi_id: kpiId })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.message || 'Failed to remove KPI');
                    }
                    return data;
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                showSuccess('KPI removed successfully!');
            }
        }).catch(error => {
            Swal.close();
            showError(error.message || 'Failed to remove KPI');
        });
    }

    function removeDocument(documentId) {
        Swal.fire({
            title: 'Remove Document',
            text: 'Are you sure you want to remove this document?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, remove it',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch(baseUrl + '/remove-document', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ document_id: documentId })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.message || 'Failed to remove document');
                    }
                    return data;
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                showSuccess('Document removed successfully!');
            }
        }).catch(error => {
            Swal.close();
            showError(error.message || 'Failed to remove document');
        });
    }

    // ==================== DELETE EMPLOYEE ====================
    function deleteEmployee() {
        Swal.fire({
            title: 'Delete Employee',
            html: `Are you sure you want to permanently delete <strong>${employeeName}</strong>?<br><br>
                  <span class="text-red-600 text-sm font-medium">This action cannot be undone! All employee data will be lost.</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete permanently',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch(baseUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.message || 'Failed to delete employee');
                    }
                    return data;
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleted!',
                    text: 'Employee has been permanently deleted.',
                    icon: 'success',
                    confirmButtonText: 'Go to Employees List',
                    allowOutsideClick: false
                }).then(() => {
                    window.location.href = '{{ route("admin.employees.index") }}';
                });
            }
        }).catch(error => {
            Swal.close();
            Swal.fire({
                title: 'Error!',
                text: error.message || 'Failed to delete employee',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }

   // ==================== EXPORT FUNCTIONS ====================
function exportProfile() {
    Swal.fire({
        title: 'Export Profile',
        text: 'Choose export format',
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'PDF',
        cancelButtonText: 'Excel',
        showDenyButton: true,
        denyButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Export to PDF - use window.location for direct download
            window.location.href = '{{ route("admin.employees.export.pdf", $employee) }}';
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Export to Excel
            window.location.href = '{{ route("admin.employees.export.excel", $employee) }}';
        }
    });
}



// ==================== GENERATE REPORT ====================
function generateReport() {
    // Simple direct download
    window.location.href = '{{ route("admin.employees.generate-report", $employee) }}';
}


    function sendMessage() {
        Swal.fire({
            title: 'Send Message',
            input: 'textarea',
            inputLabel: 'Message to {{ $employee->name }}',
            inputPlaceholder: 'Type your message here...',
            showCancelButton: true,
            confirmButtonText: 'Send',
            showLoaderOnConfirm: true,
            preConfirm: (message) => {
                if (!message) {
                    Swal.showValidationMessage('Please enter a message');
                    return false;
                }
                return new Promise((resolve) => {
                    setTimeout(() => {
                        resolve({ success: true });
                    }, 1500);
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                showSuccess('Message sent successfully!', false);
            }
        });
    }

    function generateReport() {
        showLoading('Generating report...');
        setTimeout(() => {
            Swal.close();
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Report generated and downloaded.',
                showConfirmButton: true,
                timer: 2000
            });
        }, 2000);
    }

    // ==================== DEPARTMENT & PROFESSION CASCADE ====================
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
    
    // Set database-driven professions for edit form
    professionsByDepartmentId = @json($professionsByDepartment);
    console.log('Edit Form - Professions by Department ID:', professionsByDepartmentId);
    
    function initializeDepartmentProfessionCascade() {
        const departmentSelect = document.getElementById('departmentSelect');
        const professionSelect = document.getElementById('professionSelect');
        
        if (!departmentSelect || !professionSelect) return;
        
        departmentSelect.addEventListener('change', function() {
            const departmentId = this.options[this.selectedIndex].getAttribute('data-id');
            const currentProfession = professionSelect.value;
            
            // Clear professions
            professionSelect.innerHTML = '<option value="">Select Profession/Title</option>';
            
            // Populate professions for selected department using global database data
            if (departmentId && professionsByDepartmentId[departmentId]) {
                professionsByDepartmentId[departmentId].forEach(profession => {
                    const option = document.createElement('option');
                    option.value = profession.name;
                    option.textContent = profession.name;
                    professionSelect.appendChild(option);
                });
            }
            
            // Reset to first option if current profession not in new list
            professionSelect.value = '';
        });
    }

    // ==================== INITIALIZATION ====================
    function initializeModals() {
        // Close modals when clicking outside
        document.querySelectorAll('#editModal, #kpiModal, #documentModal').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    if (modal.id === 'editModal') closeEditModal();
                    if (modal.id === 'kpiModal') closeKpiModal();
                    if (modal.id === 'documentModal') closeDocumentModal();
                }
            });
        });

        // Add ESC key to close modals
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeEditModal();
                closeKpiModal();
                closeDocumentModal();
            }
        });
    }

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Profile page initialized');
        initializeModals();
        initializeDepartmentProfessionCascade();
    });

    // Make functions available globally
    window.openEditModal = openEditModal;
    window.closeEditModal = closeEditModal;
    window.switchTab = switchTab;
    window.updateEmployee = updateEmployee;
    window.openKpiModal = openKpiModal;
    window.closeKpiModal = closeKpiModal;
    window.openDocumentModal = openDocumentModal;
    window.closeDocumentModal = closeDocumentModal;
    window.submitKpi = submitKpi;
    window.submitDocument = submitDocument;
    window.removeKpi = removeKpi;
    window.removeDocument = removeDocument;
    window.exportProfile = exportProfile;
    window.deleteEmployee = deleteEmployee;
    window.sendMessage = sendMessage;
    window.generateReport = generateReport;
</script>

<style>
.tab-active {
    background-color: var(--g-spring);
    color: white;
    border-color: var(--g-spring);
}

.tab-content {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>