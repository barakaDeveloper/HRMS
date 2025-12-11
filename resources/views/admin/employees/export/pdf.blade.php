<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title ?? 'Employee Profile' }}</title>

    <!-- Poppins Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: #1f2937;
            line-height: 1.45;
            padding: 28px 40px;
            background: #ffffff;
            font-size: 13px;
        }

        /* Header */
        .document-header {
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 14px;
            margin-bottom: 20px;
        }

        .company-info {
            text-align: right;
            color: #6b7280;
            font-size: 11px;
        }

        .company-info .company-name {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
        }

        /* Profile Section */
        .profile-section {
            display: flex;
            gap: 20px;
            padding: 18px;
            background: #f9fafb;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            margin-bottom: 24px;
        }

        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 12px;
            object-fit: cover;
            border: 3px solid #ffffff;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }

        .employee-name {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 4px;
            letter-spacing: -0.015em;
        }

        .employee-title {
            font-size: 14px;
            color: #3b82f6;
            font-weight: 500;
            margin-bottom: 12px;
        }

        .quick-info {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .info-badge {
            padding: 5px 10px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            font-size: 11px;
        }

        .info-badge .label {
            color: #6b7280;
            margin-right: 4px;
        }

        /* Sections */
        .section {
            margin-bottom: 18px;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 10px;
            border-bottom: 1.6px solid #e5e7eb;
            padding-bottom: 4px;
        }

        .section-icon {
            width: 16px;
            height: 16px;
            background: #3b82f6;
            border-radius: 4px;
        }

        .section-title {
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.04em;
        }

        .card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 14px;
            margin-bottom: 10px;
        }

        /* Table */
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 8px 4px;
            vertical-align: top;
        }

        .info-table td:first-child {
            width: 32%;
            font-weight: 600;
            color: #6b7280;
        }

        .grid-2 {
            display: flex;
            gap: 12px;
        }

        .grid-2 .card {
            flex: 1;
        }

        /* Badges */
        .status-badge {
            padding: 3px 10px;
            border-radius: 9999px;
            font-size: 10px;
            font-weight: 600;
        }

        .status-active { background:#d1fae5; color:#065f46; }
        .status-inactive { background:#fee2e2; color:#991b1b; }
        .status-pending { background:#fef3c7; color:#92400e; }

        /* Financial boxes */
        .highlight-box {
            background: #eff6ff;
            border-left: 5px solid #3b82f6;
            padding: 12px;
            border-radius: 6px;
        }

        .highlight-box .label {
            font-size: 14px;
            color: #0435d9;
            font-weight: 600;
        }

        .highlight-box .value {
            font-size: 15px;
            font-weight: 700;
            color: #1e3a8a;
        }


        /* Footer */
        .document-footer {
            margin-top: 22px;
            padding-top: 14px;
            border-top: 2px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #6b7280;
        }

        .confidential-badge {
            background: #fee2e2;
            color: #991b1b;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: 600;
        }

        @media print {
            body { padding: 20px; }
            .section { page-break-inside: avoid; }
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="document-header">
        <div class="company-info">
            <div class="company-name">{{ config('app.name', 'Company Name') }}</div>
            <div>Human Resources Department</div>
            <div>Employee Records & Documentation</div>
        </div>
    </div>

    <!-- Profile -->
    <div class="profile-section">
        <div>
            @if(!empty($profileImageData))
                <img src="{{ $profileImageData }}" class="avatar">
            @else
                <img src="{{ $employee->profile_photo_url }}" class="avatar">
            @endif
        </div>

        <div class="profile-info">
            <div class="employee-name">{{ $employee->name }}</div>
            <div class="employee-title">{{ $employee->profession }}</div>

            <div class="quick-info">
                <div class="info-badge"><span class="label">ID:</span>{{ $employee->employee_id }}</div>
                <div class="info-badge"><span class="label">Department:</span>{{ $employee->department }}</div>

                <div class="info-badge">
                    <span class="label">Status:</span>
                    @php
                        $status = strtolower($employee->employee_status ?? 'active');
                        $cls = $status === 'active' ? 'status-active' : ($status === 'inactive' ? 'status-inactive' : 'status-pending');
                    @endphp
                    <span class="status-badge {{ $cls }}">{{ $employee->formatted_employee_status ?? $employee->employee_status }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="section">
        <div class="section-header">
            <span class="section-icon"></span><span class="section-title">Contact Information</span>
        </div>

        <div class="card">
            <table class="info-table">
                <tr><td>Email Address</td><td>{{ $employee->email }}</td></tr>
                <tr><td>Phone Number</td><td>{{ $employee->phone ?? 'Not provided' }}</td></tr>
                <tr><td>Physical Address</td><td>{{ $employee->address ?? 'Not provided' }}</td></tr>
                @if(!empty($employee->emergency_contact))
                <tr><td>Emergency Contact</td><td>{{ $employee->emergency_contact }}</td></tr>
                @endif
            </table>
        </div>
    </div>

    <!-- Employment Details -->
    <div class="section">
        <div class="section-header">
            <span class="section-icon"></span><span class="section-title">Employment Details</span>
        </div>

        <div class="grid-2">
            <div class="card">
                <table class="info-table">
                    <tr><td>Employment Type</td><td><strong>{{ $employee->formatted_employment_type ?? $employee->employment_type }}</strong></td></tr>
                    <tr><td>Join Date</td><td>{{ optional($employee->join_date)->format('F d, Y') ?? 'Not specified' }}</td></tr>
                    <tr><td>Years of Service</td>
                        <td>
                            @if($employee->join_date)
                                {{ \Carbon\Carbon::parse($employee->join_date)->diffForHumans(null,true,false,2) }}
                            @else N/A @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Financial -->
    <div class="section">
        <div class="section-header">
            <span class="section-icon"></span><span class="section-title">Financial Details</span>
        </div>

        <div class="grid-2">
            <div class="highlight-box">
                <div class="label">Basic Salary</div>
                <div class="value">{{ $employee->salary_with_symbol ?? $employee->formatted_salary ?? 'Confidential' }}</div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="document-footer">
        <div>
        <span class="confidential-badge">Confidential</span>  
            Sensitive employee information
        </div>
        <div style="text-align:right;">
            Generated on <span style="font-weight:600;color:#374151;">{{ now()->format('F d, Y') }}</span><br>
            Page 1 of 1
        </div>
    </div>

</body>
</html>
