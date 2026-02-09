<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Slip - {{ $slip_number ?: 'New Slip' }}</title>
    @php
    function numberToWords($amount) {
        $ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 
                 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 
                 'Eighteen', 'Nineteen'];
        $tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
        
        $amount = round($amount);
        if ($amount == 0) {
            return 'Zero';
        }
        
        $words = '';
        
        if ($amount >= 1000000000) {
            $billions = intval($amount / 1000000000);
            $words .= numberToWords($billions) . ' Billion ';
            $amount %= 1000000000;
        }
        
        if ($amount >= 1000000) {
            $millions = intval($amount / 1000000);
            $words .= numberToWords($millions) . ' Million ';
            $amount %= 1000000;
        }
        
        if ($amount >= 1000) {
            $thousands = intval($amount / 1000);
            $words .= numberToWords($thousands) . ' Thousand ';
            $amount %= 1000;
        }
        
        if ($amount >= 100) {
            $hundreds = intval($amount / 100);
            $words .= $ones[$hundreds] . ' Hundred ';
            $amount %= 100;
        }
        
        if ($amount >= 20) {
            $tensDigit = intval($amount / 10);
            $onesDigit = $amount % 10;
            $words .= $tens[$tensDigit];
            if ($onesDigit > 0) {
                $words .= ' ' . $ones[$onesDigit];
            }
        } elseif ($amount > 0) {
            $words .= $ones[$amount];
        }
        
        return trim($words);
    }
    
    // Calculate earnings from employee data
    $employeeCurrency = $employee->salary_currency ?? 'TZS';
    $totalEarningsTZS = 0;
    $totalEarningsUSD = 0;
    
    if (($employee->salary ?? 0) > 0) {
        if ($employeeCurrency === 'TZS') {
            $totalEarningsTZS += $employee->salary;
        } else {
            $totalEarningsUSD += $employee->salary;
        }
    }
    if (($employee->allowances ?? 0) > 0) {
        $allowCurrency = $employee->allowances_currency ?? $employeeCurrency;
        if ($allowCurrency === 'TZS') {
            $totalEarningsTZS += $employee->allowances;
        } else {
            $totalEarningsUSD += $employee->allowances;
        }
    }
    if (($employee->bonus ?? 0) > 0) {
        $bonusCurrency = $employee->bonus_currency ?? $employeeCurrency;
        if ($bonusCurrency === 'TZS') {
            $totalEarningsTZS += $employee->bonus;
        } else {
            $totalEarningsUSD += $employee->bonus;
        }
    }
    if (($employee->commission ?? 0) > 0) {
        $commCurrency = $employee->commission_currency ?? $employeeCurrency;
        if ($commCurrency === 'TZS') {
            $totalEarningsTZS += $employee->commission;
        } else {
            $totalEarningsUSD += $employee->commission;
        }
    }
    
    // Get exchange rate from settings
    $exchangeRate = \App\Models\Setting::get('usd_exchange_rate', 2500);
    @endphp
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 9px;
            line-height: 1.3;
            color: #1a1a1a;
            background: #f5f5f5;
        }
        
        .salary-slip-container {
            width: 297mm;
            min-height: 210mm;
            margin: 5px auto;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            padding: 10px;
        }
        
        /* Read-only styles */
        .read-only {
            border: none;
            background: transparent;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }
        
        /* Editable styles */
        .editable {
            border: 1px dashed transparent;
            padding: 2px 4px;
            transition: all 0.2s;
            background: transparent;
            width: 100%;
            font-family: 'Poppins', sans-serif;
            font-size: inherit;
        }
        
        .editable:hover, .editable:focus {
            border-color: #1a7f37;
            background: #f8fdf9;
            outline: none;
        }
        
        /* Print styles */
        @media print {
            body {
                background: white;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .salary-slip-container {
                box-shadow: none;
                margin: 0;
                padding: 8px;
            }
            
            .no-print {
                display: none !important;
            }
            
            .editable {
                border: none !important;
                background: transparent !important;
                padding: 0;
            }
            
            .read-only {
                border: none !important;
                background: transparent !important;
            }
        }
        
        /* Header */
        .header {
            background: linear-gradient(135deg, #1a7f37 0%, #145a2a 100%);
            color: white;
            padding: 12px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 6px 6px 0 0;
            min-height: 70px;
        }
        
        .company-section {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1.5;
            min-width: 0;
            overflow: visible;
        }
        
        .company-logo {
            width: 55px;
            height: 55px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }
        
        .company-logo img {
            max-width: 50px;
            max-height: 50px;
            object-fit: contain;
        }
        
        .company-logo-placeholder {
            font-size: 22px;
            font-weight: 700;
            color: #1a7f37;
            font-family: 'Poppins', sans-serif;
        }
        
        .company-info {
            flex: 1;
            min-width: 0;
            overflow: visible;
        }
        
        .company-name {
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-family: 'Poppins', sans-serif;
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: visible;
            color: white;
        }
        
        .company-address {
            font-size: 11px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            white-space: nowrap;
            overflow: visible;
            color: rgba(255, 255, 255, 0.95);
        }
        
        .header-center {
            text-align: center;
            flex: 0.8;
        }
        
        .salary-slip-title {
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-family: 'Poppins', sans-serif;
        }
        
        .header-right {
            text-align: right;
            flex: 0.7;
        }
        
        .header-field-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            min-width: 140px;
        }
        
        .header-field {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(255,255,255,0.15);
            padding: 5px 10px;
            border-radius: 4px;
        }
        
        .header-label {
            font-size: 10px;
            font-weight: 600;
            opacity: 1;
            text-transform: uppercase;
            font-family: 'Poppins', sans-serif;
        }
        
        .header-value {
            font-size: 10px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            margin-left: 8px;
        }
        
        .header-divider {
            height: 2px;
            background: #1a7f37;
            margin: 8px 0;
            border-radius: 1px;
        }
        
        /* Tables */
        .section-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 8px;
            border-radius: 6px;
            overflow: hidden;
        }
        
        .section-table th,
        .section-table td {
            padding: 6px 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        
        .section-table th {
            background: #1a7f37;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 8px;
            font-family: 'Poppins', sans-serif;
        }
        
        .section-table td:first-child {
            width: 40%;
        }
        
        .section-table .amount-cell {
            text-align: right;
            font-family: 'Poppins', sans-serif;
            width: 30%;
            font-weight: 500;
        }
        
        .section-table .currency-cell {
            text-align: center;
            width: 12%;
            font-size: 8px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
        }
        
        .section-table .total-row {
            background: #e8f5e9;
            font-weight: 600;
        }
        
        .section-table .total-row td {
            border-top: 2px solid #1a7f37;
        }
        
        /* Employee Info Table */
        .employee-table {
            margin-bottom: 6px;
        }
        
        .employee-table td {
            padding: 4px 8px;
            font-size: 9px;
        }
        
        .employee-table td:first-child {
            width: 35%;
            color: #666;
            font-size: 7px;
            text-transform: uppercase;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            background: #fafafa;
        }
        
        /* Summary Card */
        .summary-card {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            border: 2px solid #1a7f37;
            border-radius: 6px;
            padding: 10px 12px;
            margin-top: 6px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 4px 0;
        }
        
        .summary-row:not(:last-child) {
            border-bottom: 1px solid rgba(26, 127, 55, 0.2);
        }
        
        .summary-label {
            font-size: 10px;
            color: #333;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
        }
        
        .summary-value {
            font-size: 11px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
        }
        
        .summary-total {
            background: linear-gradient(135deg, #1a7f37 0%, #145a2a 100%);
            color: white;
            margin: 8px -12px -10px;
            padding: 10px 12px;
            border-radius: 0 0 4px 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .summary-total .summary-label {
            font-size: 12px;
            font-weight: 700;
            color: white;
            font-family: 'Poppins', sans-serif;
        }
        
        .summary-total .summary-value {
            font-size: 14px;
            font-weight: 700;
            color: white;
            font-family: 'Poppins', sans-serif;
        }
        
        /* Signature Section */
        .signature-section {
            margin-top: 8px;
            display: flex;
            justify-content: flex-end;
        }
        
        .signature-box {
            width: 150px;
            text-align: center;
        }
        
        .signature-line {
            width: 120px;
            border-bottom: 2px solid #333;
            margin: 0 auto 5px;
        }
        
        .signature-image {
            width: 110px;
            height: 40px;
            margin: 0 auto 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px dashed #ddd;
            background: #fafafa;
            border-radius: 4px;
        }
        
        .signature-image img {
            max-width: 105px;
            max-height: 35px;
            object-fit: contain;
        }
        
        .signature-label {
            font-size: 8px;
            color: #666;
            text-transform: uppercase;
            font-family: 'Poppins', sans-serif;
        }
        
        /* Footer */
        .footer {
            padding: 6px 0;
            border-top: 2px solid #1a7f37;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 15px;
            font-size: 8px;
            color: #666;
            margin-top: 8px;
        }
        
        .footer-note {
            flex: 1;
        }
        
        .footer-note-input {
            width: 100%;
            border: none;
            border-bottom: 1px dashed transparent;
            font-family: 'Poppins', sans-serif;
            font-size: 8px;
            color: #666;
            background: transparent;
        }
        
        .footer-note-input:hover, .footer-note-input:focus {
            border-bottom-color: #1a7f37;
            outline: none;
        }
        
        .print-date {
            white-space: nowrap;
        }
        
        /* Exchange Rate Input */
        .exchange-rate-section {
            margin-top: 6px;
            padding: 6px 8px;
            background: #f8f9fa;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .exchange-rate-label {
            font-size: 8px;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            white-space: nowrap;
        }
        
        .exchange-rate-input {
            width: 80px;
            padding: 3px 6px;
            border: 1px dashed #1a7f37;
            border-radius: 4px;
            font-size: 9px;
            font-family: 'Poppins', sans-serif;
            text-align: right;
        }
        
        .exchange-rate-input:hover, .exchange-rate-input:focus {
            border-color: #1a7f37;
            background: #fff;
            outline: none;
        }
        
        /* Action Buttons */
        .action-buttons {
            position: fixed;
            top: 15px;
            right: 15px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            z-index: 1000;
        }
        
        .action-btn {
            padding: 8px 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 11px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            font-family: 'Poppins', sans-serif;
        }
        
        .action-btn-primary {
            background: linear-gradient(135deg, #1a7f37 0%, #145a2a 100%);
            color: white;
        }
        
        .action-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(26, 127, 55, 0.3);
        }
        
        .action-btn-secondary {
            background: white;
            color: #333;
        }
        
        .action-btn-secondary:hover {
            background: #f5f5f5;
            transform: translateY(-2px);
        }
        
        /* Dynamic Row Buttons */
        .add-row-btn {
            background: none;
            border: 1px dashed #1a7f37;
            color: #1a7f37;
            padding: 3px 8px;
            font-size: 8px;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 4px;
            transition: all 0.2s;
            font-family: 'Poppins', sans-serif;
        }
        
        .add-row-btn:hover {
            background: #1a7f37;
            color: white;
        }
        
        .remove-row-btn {
            background: #dc3545;
            color: white;
            border: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 12px;
            line-height: 1;
            transition: all 0.2s;
        }
        
        .remove-row-btn:hover {
            background: #c82333;
        }
        
        .remove-row-btn.hidden {
            visibility: hidden;
        }
        
        /* Amount in Words */
        .amount-in-words {
            margin-top: 6px;
            padding: 6px 10px;
            background: #f1f8e9;
            border-radius: 4px;
            font-size: 9px;
            font-style: italic;
            color: #333;
            border-left: 3px solid #1a7f37;
            font-family: 'Poppins', sans-serif;
        }
        
        /* Currency Badge */
        .currency-badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 7px;
            font-weight: 600;
            border-radius: 3px;
            text-transform: uppercase;
            font-family: 'Poppins', sans-serif;
        }
        
        .currency-badge-usd {
            background: #e3f2fd;
            color: #1565c0;
        }
        
        .currency-badge-tzs {
            background: #ffebee;
            color: #c62828;
        }
        
        /* Two column layout */
        .two-column {
            display: flex;
            gap: 12px;
        }
        
        .column-left {
            flex: 1.1;
            min-width: 280px;
        }
        
        .column-right {
            flex: 0.9;
        }
        
        /* Section title */
        .section-title {
            font-size: 11px;
            font-weight: 700;
            color: #1a7f37;
            margin-bottom: 6px;
            padding-bottom: 3px;
            border-bottom: 2px solid #1a7f37;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>
    <!-- Action Buttons -->
    <div class="action-buttons no-print">
        <button class="action-btn action-btn-primary" onclick="downloadPDF()">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
            </svg>
            Download PDF
        </button>
        <button class="action-btn action-btn-primary" onclick="downloadImage()">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Download Image
        </button>
        <button class="action-btn action-btn-secondary" onclick="printSlip()">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Print
        </button>
    </div>
    
    <div class="salary-slip-container" id="salarySlip">
        <!-- Header -->
        <div class="header">
            <div class="company-section">
                <div class="company-logo" id="companyLogoContainer">
                    @if(!empty($company_logo) && file_exists(public_path($company_logo)))
                        <img src="{{ asset($company_logo) }}" alt="Company Logo">
                    @else
                        <div class="company-logo-placeholder">{{ substr($company_name ?: 'LOGO', 0, 1) }}</div>
                    @endif
                </div>
                <div class="company-info">
                    <div class="company-name">{{ $company_name ?: 'COMPANY NAME' }}</div>
                    <div class="company-address">{{ $company_address ?: 'Company Address' }}</div>
                </div>
            </div>
            
            <div class="header-center">
                <div class="salary-slip-title">Salary Slip</div>
            </div>
            
            <div class="header-right">
                <div class="header-field-group">
                    <div class="header-field">
                        <span class="header-label">Period</span>
                        <span class="header-value" id="payPeriod">{{ $pay_period ?: date('F Y') }}</span>
                    </div>
                    <div class="header-field">
                        <span class="header-label">Slip No</span>
                        <span class="header-value" id="slipNumber">{{ $slip_number ?: 'SLIP-' . strtoupper(uniqid()) }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="header-divider"></div>
        
        <!-- Main Content -->
        <div class="two-column">
            <!-- Left Column -->
            <div class="column-left">
                <div class="section-title">Employee Information</div>
                <table class="section-table employee-table">
                    <tr>
                        <td>Employee Name</td>
                        <td><input type="text" class="read-only" id="employeeName" value="{{ $employee->name ?? '' }}" readonly></td>
                    </tr>
                    <tr>
                        <td>Employee ID</td>
                        <td><input type="text" class="read-only" id="employeeId" value="{{ $employee->employee_id ?? '' }}" readonly></td>
                    </tr>
                    <tr>
                        <td>Department</td>
                        <td><input type="text" class="read-only" id="department" value="{{ $employee->department ?? '' }}" readonly></td>
                    </tr>
                    <tr>
                        <td>Job Title</td>
                        <td><input type="text" class="read-only" id="jobTitle" value="{{ $employee->profession ?? '' }}" readonly></td>
                    </tr>
                    <tr>
                        <td>Join Date</td>
                        <td><input type="text" class="read-only" id="joinDate" value="{{ isset($employee->join_date) ? $employee->join_date->format('d/m/Y') : '' }}" readonly></td>
                    </tr>
                </table>
                
                <div class="section-title" style="margin-top: 8px;">Earnings</div>
                <table class="section-table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th style="text-align: right;">Amount</th>
                            <th style="text-align: center;">Currency</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(($employee->salary ?? 0) > 0)
                        <tr>
                            <td><span class="read-only">Basic Salary</span></td>
                            <td class="amount-cell">{{ number_format($employee->salary, 2) }}</td>
                            <td class="currency-cell"><span class="currency-badge currency-badge-{{ strtolower($employeeCurrency) }}">{{ $employeeCurrency }}</span></td>
                        </tr>
                        @endif
                        @if(($employee->allowances ?? 0) > 0)
                        <tr>
                            <td><span class="read-only">Allowances</span></td>
                            <td class="amount-cell">{{ number_format($employee->allowances, 2) }}</td>
                            <td class="currency-cell"><span class="currency-badge currency-badge-{{ strtolower($employee->allowances_currency ?? $employeeCurrency) }}">{{ $employee->allowances_currency ?? $employeeCurrency }}</span></td>
                        </tr>
                        @endif
                        @if(($employee->bonus ?? 0) > 0)
                        <tr>
                            <td><span class="read-only">Bonus</span></td>
                            <td class="amount-cell">{{ number_format($employee->bonus, 2) }}</td>
                            <td class="currency-cell"><span class="currency-badge currency-badge-{{ strtolower($employee->bonus_currency ?? $employeeCurrency) }}">{{ $employee->bonus_currency ?? $employeeCurrency }}</span></td>
                        </tr>
                        @endif
                        @if(($employee->commission ?? 0) > 0)
                        <tr>
                            <td><span class="read-only">Commission</span></td>
                            <td class="amount-cell">{{ number_format($employee->commission, 2) }}</td>
                            <td class="currency-cell"><span class="currency-badge currency-badge-{{ strtolower($employee->commission_currency ?? $employeeCurrency) }}">{{ $employee->commission_currency ?? $employeeCurrency }}</span></td>
                        </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td><strong>TOTAL (TZS)</strong></td>
                            <td class="amount-cell"><strong id="totalEarningsTZS">{{ number_format($totalEarningsTZS, 2) }}</strong></td>
                            <td></td>
                        </tr>
                        <tr class="total-row">
                            <td><strong>TOTAL (USD)</strong></td>
                            <td class="amount-cell"><strong id="totalEarningsUSD">{{ number_format($totalEarningsUSD, 2) }}</strong></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
                
                <!-- Summary Card -->
                <div class="summary-card">
                    <div class="summary-row">
                        <span class="summary-label">Total Earnings (TZS)</span>
                        <span class="summary-value" id="summaryTZS">{{ number_format($totalEarningsTZS, 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Total Earnings (USD)</span>
                        <span class="summary-value" id="summaryUSD">{{ number_format($totalEarningsUSD, 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Total Deductions</span>
                        <span class="summary-value" id="summaryDeductions">0.00</span>
                    </div>
                    <div class="summary-total">
                        <span class="summary-label">NET SALARY</span>
                        <span class="summary-value" id="netSalary">0.00</span>
                    </div>
                </div>
                
                <div class="amount-in-words">
                    <strong>Amount in Words:</strong> <span id="wordsText">Zero</span>
                </div>
            </div>
            
            <!-- Right Column -->
            <div class="column-right">
                <div class="section-title">Deductions</div>
                <table class="section-table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th style="text-align: right;">Amount</th>
                            <th style="text-align: center;">Currency</th>
                            <th style="width: 20px;" class="no-print"></th>
                        </tr>
                    </thead>
                    <tbody id="deductionRows">
                        @if(isset($deductions_rows) && count($deductions_rows) > 0)
                            @foreach($deductions_rows as $row)
                            <tr>
                                <td><input type="text" class="editable" value="{{ $row['description'] }}"></td>
                                <td class="amount-cell"><input type="number" class="editable" value="{{ $row['amount'] }}" step="0.01" onchange="calculateTotals()"></td>
                                <td class="currency-cell">
                                    @if(($row['currency'] ?? 'TZS') == 'USD')
                                        <span class="currency-badge currency-badge-usd">USD</span>
                                    @else
                                        <span class="currency-badge currency-badge-tzs">TZS</span>
                                    @endif
                                </td>
                                <td class="no-print"><button class="remove-row-btn" onclick="removeRow(this)">×</button></td>
                            </tr>
                            @endforeach
                        @else
                        <tr>
                            <td><input type="text" class="editable" value="PAYE Tax" placeholder="Description"></td>
                            <td class="amount-cell"><input type="number" class="editable deduction-amount" value="0" step="0.01" onchange="calculateTotals()"></td>
                            <td class="currency-cell">
                                <span class="currency-badge currency-badge-tzs">TZS</span>
                            </td>
                            <td class="no-print"><button class="remove-row-btn" onclick="removeRow(this)">×</button></td>
                        </tr>
                        <tr>
                            <td><input type="text" class="editable" value="NHIF" placeholder="Description"></td>
                            <td class="amount-cell"><input type="number" class="editable deduction-amount" value="0" step="0.01" onchange="calculateTotals()"></td>
                            <td class="currency-cell">
                                <span class="currency-badge currency-badge-tzs">TZS</span>
                            </td>
                            <td class="no-print"><button class="remove-row-btn" onclick="removeRow(this)">×</button></td>
                        </tr>
                        <tr>
                            <td><input type="text" class="editable" value="NSSF" placeholder="Description"></td>
                            <td class="amount-cell"><input type="number" class="editable deduction-amount" value="0" step="0.01" onchange="calculateTotals()"></td>
                            <td class="currency-cell">
                                <span class="currency-badge currency-badge-tzs">TZS</span>
                            </td>
                            <td class="no-print"><button class="remove-row-btn" onclick="removeRow(this)">×</button></td>
                        </tr>
                        <tr>
                            <td><input type="text" class="editable" value="Other Deductions" placeholder="Description"></td>
                            <td class="amount-cell"><input type="number" class="editable deduction-amount" value="0" step="0.01" onchange="calculateTotals()"></td>
                            <td class="currency-cell">
                                <span class="currency-badge currency-badge-tzs">TZS</span>
                            </td>
                            <td class="no-print"><button class="remove-row-btn hidden" onclick="removeRow(this)">×</button></td>
                        </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td><strong>TOTAL</strong></td>
                            <td class="amount-cell"><strong id="totalDeductions">0.00</strong></td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
                <button class="add-row-btn no-print" onclick="addDeductionRow()">+ Add Deduction</button>
                
                <!-- Exchange Rate Section -->
                <div class="exchange-rate-section">
                    <label class="exchange-rate-label">USD Exchange Rate to TZS:</label>
                    <input type="number" class="exchange-rate-input" id="exchangeRate" value="{{ $exchangeRate }}" min="1" step="1" onchange="calculateTotals()">
                </div>
                
                <!-- Signature -->
                <div class="signature-section">
                    <div class="signature-box">
                        <div class="signature-image" id="signatureImage">
                            @if(!empty($hr_finance_signature) && file_exists(public_path($hr_finance_signature)))
                                <img src="{{ asset($hr_finance_signature) }}" alt="HR/Finance Signature">
                            @else
                                <span style="color: #999; font-size: 8px; font-family: 'Poppins', sans-serif;">Signature</span>
                            @endif
                        </div>
                        <div class="signature-line"></div>
                        <div class="signature-label">HR / Finance</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="footer-note">
                <input type="text" class="footer-note-input" placeholder="This is an official salary slip. For any queries, please contact HR department.">
            </div>
            <div class="print-date">Print Date: <span id="printDate">{{ date('d/m/Y') }}</span></div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        // Initial values from PHP
        const totalEarningsTZS = {{ $totalEarningsTZS }};
        const totalEarningsUSD = {{ $totalEarningsUSD }};
        
        // Number to Words function
        function numberToWords(amount) {
            const ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 
                         'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 
                         'Eighteen', 'Nineteen'];
            const tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
            
            amount = Math.round(amount);
            if (amount === 0) return 'Zero';
            
            let words = '';
            
            if (amount >= 1000000000) {
                const billions = Math.floor(amount / 1000000000);
                words += numberToWords(billions) + ' Billion ';
                amount %= 1000000000;
            }
            
            if (amount >= 1000000) {
                const millions = Math.floor(amount / 1000000);
                words += numberToWords(millions) + ' Million ';
                amount %= 1000000;
            }
            
            if (amount >= 1000) {
                const thousands = Math.floor(amount / 1000);
                words += numberToWords(thousands) + ' Thousand ';
                amount %= 1000;
            }
            
            if (amount >= 100) {
                const hundreds = Math.floor(amount / 100);
                words += ones[hundreds] + ' Hundred ';
                amount %= 100;
            }
            
            if (amount >= 20) {
                const tensDigit = Math.floor(amount / 10);
                const onesDigit = amount % 10;
                words += tens[tensDigit];
                if (onesDigit > 0) words += ' ' + ones[onesDigit];
            } else if (amount > 0) {
                words += ones[amount];
            }
            
            return words.trim();
        }
        
        // Calculate totals
        function calculateTotals() {
            const exchangeRate = parseFloat(document.getElementById('exchangeRate').value) || 2500;
            let totalDeductions = 0;
            
            document.querySelectorAll('.deduction-amount').forEach(input => {
                totalDeductions += parseFloat(input.value) || 0;
            });
            
            // Calculate net salary (grand total in TZS)
            const grandTotal = totalEarningsTZS + (totalEarningsUSD * exchangeRate);
            const netSalary = grandTotal - totalDeductions;
            
            // Update displays
            document.getElementById('totalDeductions').textContent = totalDeductions.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('summaryDeductions').textContent = totalDeductions.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('netSalary').textContent = netSalary.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('wordsText').textContent = numberToWords(netSalary);
        }
        
        // Add deduction row
        function addDeductionRow() {
            const tbody = document.getElementById('deductionRows');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><input type="text" class="editable" placeholder="Description"></td>
                <td class="amount-cell"><input type="number" class="editable deduction-amount" value="0" step="0.01" onchange="calculateTotals()"></td>
                <td class="currency-cell"><span class="currency-badge currency-badge-tzs">TZS</span></td>
                <td class="no-print"><button class="remove-row-btn" onclick="removeRow(this)">×</button></td>
            `;
            tbody.appendChild(row);
        }
        
        // Remove row
        function removeRow(btn) {
            const row = btn.closest('tr');
            const tbody = row.closest('tbody');
            if (tbody.querySelectorAll('tr').length > 1) {
                row.remove();
                calculateTotals();
            } else {
                row.querySelector('td:first-child input').value = '';
                row.querySelector('.deduction-amount').value = '0';
                calculateTotals();
            }
        }
        
        // Print
        function printSlip() {
            window.print();
        }
        
        // Download PDF
        function downloadPDF() {
            window.print();
        }
        
        // Download Image
        function downloadImage() {
            const element = document.getElementById('salarySlip');
            html2canvas(element, {
                scale: 2,
                useCORS: true,
                logging: false
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = 'salary-slip-' + document.getElementById('slipNumber').textContent + '.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        }
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            const exchangeRate = parseFloat(document.getElementById('exchangeRate').value) || 2500;
            const grandTotal = totalEarningsTZS + (totalEarningsUSD * exchangeRate);
            document.getElementById('netSalary').textContent = grandTotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('wordsText').textContent = numberToWords(grandTotal);
        });
    </script>
</body>
</html>
