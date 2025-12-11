<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .section { margin-bottom: 20px; }
        .section-title { background-color: #f0f0f0; padding: 8px; font-weight: bold; border-radius: 4px; margin-bottom: 10px; }
        .info-row { display: flex; margin-bottom: 5px; }
        .label { font-weight: bold; width: 150px; }
        .value { flex: 1; }
        .logo { text-align: center; margin-bottom: 20px; }
        .footer { margin-top: 50px; text-align: center; font-size: 10px; color: #666; border-top: 1px solid #ccc; padding-top: 10px; }
        .company-name { font-size: 20px; font-weight: bold; }
        .employee-name { font-size: 18px; color: #2c5282; margin: 10px 0; }
    </style>
</head>
<body>
   <div class="header text-center mb-8 pb-6 relative">
        <div class="company-name text-3xl font-bold text-gray-900 mb-2 tracking-tight">EMPLOYEE PROFILE REPORT</div>
        <div class="employee-name text-2xl font-bold uppercase text-indigo-600 my-3 tracking-wide">{{ strtoupper($employee->name) }}</div>
        <div class="meta-info text-gray-600 text-sm mt-3 font-medium">
            <span class="employee-id bg-gray-100 px-4 py-2 rounded-full text-gray-700 font-semibold border border-gray-200">
                ID: {{ $employee->employee_id }}
            </span>
            <span class="mx-3 text-gray-400">•</span>
            Generated: {{ date('F d, Y') }}
        </div>
        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-24 h-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full"></div>
    </div>
    
    <div class="section">
        <div class="section-title">Personal Information</div>
        <div class="info-row"><div class="label">Name:</div><div class="value">{{ $employee->name }}</div></div>
        <div class="info-row"><div class="label">Email:</div><div class="value">{{ $employee->email }}</div></div>
        <div class="info-row"><div class="label">Phone:</div><div class="value">{{ $employee->phone }}</div></div>
        <div class="info-row"><div class="label">Date of Birth:</div><div class="value">{{ $employee->date_of_birth ? $employee->date_of_birth->format('F d, Y') : 'N/A' }}</div></div>
        <div class="info-row"><div class="label">Gender:</div><div class="value">{{ ucfirst($employee->gender ?? 'N/A') }}</div></div>
        <div class="info-row"><div class="label">Address:</div><div class="value">{{ $employee->address ?? 'N/A' }}</div></div>
    </div>
    
    <div class="section">
        <div class="section-title">Employment Details</div>
        <div class="info-row"><div class="label">Department:</div><div class="value">{{ $employee->department }}</div></div>
        <div class="info-row"><div class="label">Profession:</div><div class="value">{{ $employee->profession }}</div></div>
        <div class="info-row"><div class="label">Employment Type:</div><div class="value">{{ $employee->formatted_employment_type ?? $employee->employment_type }}</div></div>
        <div class="info-row"><div class="label">Status:</div><div class="value">{{ $employee->formatted_employee_status ?? $employee->employee_status }}</div></div>
        <div class="info-row"><div class="label">Join Date:</div><div class="value">{{ $employee->join_date ? $employee->join_date->format('F d, Y') : 'N/A' }}</div></div>
    </div>
    
    <div class="section">
        <div class="section-title">Financial Information</div>
        <div class="info-row"><div class="label">Salary:</div><div class="value">{{ $employee->salary_with_symbol ?? $employee->formatted_salary ?? 'N/A' }}</div></div>
        <div class="info-row"><div class="label">Allowances:</div><div class="value">{{ $employee->allowances_with_symbol ?? $employee->formatted_allowances ?? 'N/A' }}</div></div>
        <div class="info-row"><div class="label">Bonus:</div><div class="value">{{ $employee->bonus_with_symbol ?? $employee->formatted_bonus ?? 'N/A' }}</div></div>
        <div class="info-row"><div class="label">Commission:</div><div class="value">{{ $employee->commission_with_symbol ?? $employee->formatted_commission ?? 'N/A' }}</div></div>
    </div>
    
    <div class="section">
        <div class="section-title">Performance</div>
        <div class="info-row"><div class="label">Productivity Score:</div><div class="value">{{ $employee->productivity ?? 0 }}%</div></div>
    </div>
    
    <div class="footer">
        <p>Confidential Employee Document</p>
        <p>Page 1 of 1</p>
    </div>
</body>
</html>