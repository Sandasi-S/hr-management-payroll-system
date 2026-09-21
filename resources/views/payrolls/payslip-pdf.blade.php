<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payslip</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            padding: 0;
            margin: 0;
        }
        .container {
            padding: 30px 40px;
        }
        .header {
            background-color: #4338ca;
            color: white;
            padding: 25px 40px;
            margin: -30px -40px 25px -40px;
        }
        .header h1 {
            font-size: 22px;
            margin: 0;
            letter-spacing: 0.5px;
        }
        .header p {
            margin: 6px 0 0 0;
            font-size: 12px;
            opacity: 0.9;
        }
        .payslip-title {
            text-align: center;
            margin-bottom: 25px;
        }
        .payslip-title h2 {
            font-size: 16px;
            color: #4338ca;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .info-box {
            background-color: #f8f9fc;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 15px 20px;
            margin-bottom: 25px;
        }
        .info-table {
            width: 100%;
        }
        .info-table td {
            padding: 5px 0;
            font-size: 12px;
        }
        .info-label {
            color: #6b7280;
            width: 140px;
        }
        .info-value {
            font-weight: bold;
            color: #111827;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-paid {
            background-color: #d1fae5;
            color: #065f46;
        }
        table.salary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.salary-table thead td {
            background-color: #4338ca;
            color: white;
            padding: 10px 15px;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        table.salary-table tbody td {
            padding: 12px 15px;
            border-bottom: 1px solid #e5e7eb;
        }
        table.salary-table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .amount {
            text-align: right;
        }
        .amount-positive {
            color: #059669;
        }
        .amount-negative {
            color: #dc2626;
        }
        .total-row td {
            background-color: #eef2ff !important;
            font-weight: bold;
            font-size: 15px;
            color: #4338ca;
            border-top: 2px solid #4338ca;
            border-bottom: none;
            padding: 15px !important;
        }
        .footer {
            margin-top: 50px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
        }
        .footer p {
            margin: 3px 0;
        }
    </style>
</head>
<body>

    <div class="container">

        <div class="header">
            <h1>HR Management &amp; Payroll System</h1>
            <p>Employee Payslip</p>
        </div>

        <div class="payslip-title">
            <h2>Payslip for {{ \Carbon\Carbon::createFromFormat('Y-m', $payroll->month)->format('F Y') }}</h2>
        </div>

        <div class="info-box">
            <table class="info-table">
                <tr>
                    <td class="info-label">Employee Name</td>
                    <td class="info-value">{{ $payroll->employee->user->name }}</td>
                    <td class="info-label">Employee Code</td>
                    <td class="info-value">{{ $payroll->employee->employee_code }}</td>
                </tr>
                <tr>
                    <td class="info-label">Department</td>
                    <td class="info-value">{{ $payroll->employee->department }}</td>
                    <td class="info-label">Designation</td>
                    <td class="info-value">{{ $payroll->employee->designation }}</td>
                </tr>
                <tr>
                    <td class="info-label">Payment Status</td>
                    <td colspan="3">
                        <span class="status-badge {{ $payroll->status === 'paid' ? 'status-paid' : 'status-pending' }}">
                            {{ ucfirst($payroll->status) }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>

        <table class="salary-table">
            <thead>
                <tr>
                    <td colspan="2">Salary Breakdown</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Basic Salary</td>
                    <td class="amount">Rs. {{ number_format($payroll->basic_salary, 2) }}</td>
                </tr>
                <tr>
                    <td>Allowances</td>
                    <td class="amount amount-positive">+ Rs. {{ number_format($payroll->allowances, 2) }}</td>
                </tr>
                <tr>
                    <td>Other Deductions</td>
                    <td class="amount amount-negative">- Rs. {{ number_format($payroll->deductions, 2) }}</td>
                </tr>
                <tr>
                    <td>No-Pay Deduction ({{ $payroll->no_pay_days }} day(s) absent)</td>
                    <td class="amount amount-negative">- Rs. {{ number_format($payroll->no_pay_deduction, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td>NET SALARY</td>
                    <td class="amount">Rs. {{ number_format($payroll->net_salary, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>This is a computer-generated payslip and does not require a signature.</p>
            <p>Generated on {{ now()->format('d M Y, h:i A') }}</p>
        </div>

    </div>

</body>
</html>