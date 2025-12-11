<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprehensive Report - {{ $employee->name }}</title>
    <style>
        body { font-family: "poppins", sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .section { margin: 20px 0; page-break-inside: avoid; }
        .section-title { background-color: #2c5282; color: white; padding: 8px; font-weight: bold; border-radius: 4px; }
        .content { padding: 15px; }
        .info-row { display: flex; margin-bottom: 8px; }
        .label { font-weight: bold; width: 180px; color: #4a5568; }
        .value { flex: 1; color: #2d3748; }
        .footer { margin-top: 50px; text-align: center; font-size: 10px; color: #718096; border-top: 1px solid #e2e8f0; padding-top: 10px; }
        .summary-box { background-color: #f7fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 4px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Employee Comprehensive Report</h1>
        <h2 class="text-bold">{{ $employee->name }}</h2>
        <p>Employee ID: {{ $employee->employee_id }} | Report Date: {{ $report_date->format('F d, Y') }}</p>
    </div>
    
    <div class="summary-box">
        <h3>Report Summary</h3>
        <div class="info-row"><div class="label">Total Documents:</div><div class="value">{{ $summary['documents_summary'] }}</div></div>
        <div class="info-row"><div class="label">Total KPIs:</div><div class="value">{{ $summary['kpis_summary'] }}</div></div>
        <div class="info-row"><div class="label">Years of Service:</div><div class="value">{{ $employee->years_of_service ?? 0 }} years</div></div>
    </div>
    
    <div class="section">
        <div class="section-title">Personal Information</div>
        <div class="content">
            <div class="info-row"><div class="label">Name:</div><div class="value">{{ $employee->name }}</div></div>
            <div class="info-row"><div class="label">Email:</div><div class="value">{{ $employee->email }}</div></div>
            <div class="info-row"><div class="label">Phone:</div><div class="value">{{ $employee->phone }}</div></div>
            <div class="info-row"><div class="label">Date of Birth:</div><div class="value">{{ $employee->date_of_birth ? $employee->date_of_birth->format('F d, Y') : 'N/A' }}</div></div>
            <div class="info-row"><div class="label">Address:</div><div class="value">{{ $employee->address ?? 'N/A' }}</div></div>
        </div>
    </div>
    
    <div class="section">
        <div class="section-title">Employment Details</div>
        <div class="content">
            <div class="info-row"><div class="label">Department:</div><div class="value">{{ $employee->department }}</div></div>
            <div class="info-row"><div class="label">Profession:</div><div class="value">{{ $employee->profession }}</div></div>
            <div class="info-row"><div class="label">Join Date:</div><div class="value">{{ $employee->join_date ? $employee->join_date->format('F d, Y') : 'N/A' }}</div></div>
            <div class="info-row"><div class="label">Status:</div><div class="value">{{ $employee->formatted_employee_status ?? $employee->employee_status }}</div></div>
        </div>
    </div>
    
    <div class="section">
        <div class="section-title">Financial Information</div>
        <div class="content">
            <div class="info-row"><div class="label">Salary:</div><div class="value">{{ $employee->salary_with_symbol ?? $employee->formatted_salary ?? 'N/A' }}</div></div>
            <div class="info-row"><div class="label">Total Earnings:</div><div class="value">{{ $employee->total_earnings ?? 'N/A' }}</div></div>
        </div>
    </div>
    
    <div class="section">
        <div class="section-title">Performance</div>
        <div class="content">
            <div class="info-row"><div class="label">Productivity Score:</div><div class="value">{{ $employee->productivity ?? 0 }}%</div></div>
        </div>
    </div>
    
    <div class="footer">
        <p>Confidential Report - Generated on {{ $report_date->format('F d, Y \a\t H:i') }}</p>
        <p>Page 1 of 1</p>
    </div>
</body>
</html>