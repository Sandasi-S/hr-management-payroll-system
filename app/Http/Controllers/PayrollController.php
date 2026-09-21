<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PayrollController extends Controller
{
    /**
     * Display a listing of payroll records.
     */
    public function index()
    {
        $payrolls = Payroll::with('employee.user')->latest()->get();
        return view('payrolls.index', compact('payrolls'));
    }

    /**
     * Show the form for creating a new payroll record.
     */
    public function create()
    {
        $employees = Employee::with('user')->where('status', 'active')->get();
        return view('payrolls.create', compact('employees'));
    }

    /**
     * Store a newly created payroll record (with automatic calculation).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month' => 'required|date_format:Y-m',
            'allowances' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
        ]);

        // Prevent duplicate payroll for same employee in same month
        $exists = Payroll::where('employee_id', $validated['employee_id'])
                          ->where('month', $validated['month'])
                          ->exists();

        if ($exists) {
            return back()->withErrors(['month' => 'Payroll for this employee in this month already exists.'])->withInput();
        }

        $employee = Employee::findOrFail($validated['employee_id']);
        $basicSalary = $employee->basic_salary;
        $allowances = $validated['allowances'] ?? 0;
        $deductions = $validated['deductions'] ?? 0;

        // Calculate no-pay days: count 'absent' attendance records for that month
        $noPayDays = Attendance::where('employee_id', $employee->id)
                                ->where('status', 'absent')
                                ->whereYear('date', substr($validated['month'], 0, 4))
                                ->whereMonth('date', substr($validated['month'], 5, 2))
                                ->count();

        // Calculate per-day salary (assuming 30 working days per month)
        $perDaySalary = $basicSalary / 30;
        $noPayDeduction = $perDaySalary * $noPayDays;

        // Final net salary calculation
        $netSalary = $basicSalary + $allowances - $deductions - $noPayDeduction;

        Payroll::create([
            'employee_id' => $employee->id,
            'month' => $validated['month'],
            'basic_salary' => $basicSalary,
            'allowances' => $allowances,
            'deductions' => $deductions,
            'no_pay_days' => $noPayDays,
            'no_pay_deduction' => $noPayDeduction,
            'net_salary' => $netSalary,
            'status' => 'pending',
        ]);

        return redirect()->route('payrolls.index')->with('success', 'Payroll generated successfully!');
    }

    /**
     * Display the specified payroll record.
     */
    public function show(Payroll $payroll)
    {
        $payroll->load('employee.user');
        return view('payrolls.show', compact('payroll'));
    }

    /**
     * Show the form for editing the specified payroll record.
     */
    public function edit(Payroll $payroll)
    {
        return view('payrolls.edit', compact('payroll'));
    }

    /**
     * Update the specified payroll record (mainly to mark as paid, or adjust allowances/deductions).
     */
    public function update(Request $request, Payroll $payroll)
    {
        $validated = $request->validate([
            'allowances' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,paid',
        ]);

        $allowances = $validated['allowances'] ?? 0;
        $deductions = $validated['deductions'] ?? 0;

        // Recalculate net salary with updated allowances/deductions
        $netSalary = $payroll->basic_salary + $allowances - $deductions - $payroll->no_pay_deduction;

        $payroll->update([
            'allowances' => $allowances,
            'deductions' => $deductions,
            'net_salary' => $netSalary,
            'status' => $validated['status'],
        ]);

        return redirect()->route('payrolls.index')->with('success', 'Payroll updated successfully!');
    }

    /**
     * Remove the specified payroll record.
     */
    public function destroy(Payroll $payroll)
    {
        $payroll->delete();

        return redirect()->route('payrolls.index')->with('success', 'Payroll deleted successfully!');
    }
    /**
     * Download the payslip as a PDF.
     */
    public function downloadPdf(Payroll $payroll)
    {
        $payroll->load('employee.user');
        $pdf = Pdf::loadView('payrolls.payslip-pdf', compact('payroll'));
        return $pdf->download('payslip-' . $payroll->employee->employee_code . '-' . $payroll->month . '.pdf');
    }
}