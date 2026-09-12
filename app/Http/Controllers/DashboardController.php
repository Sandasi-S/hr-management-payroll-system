<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Payroll;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = Employee::where('status', 'active')->count();

        $pendingLeaves = Leave::where('status', 'pending')->count();

        $todayPresent = Attendance::whereDate('date', Carbon::today())
                                   ->where('status', 'present')
                                   ->count();

        $todayAbsent = Attendance::whereDate('date', Carbon::today())
                                  ->where('status', 'absent')
                                  ->count();

        $currentMonth = Carbon::now()->format('Y-m');
        $monthlyPayrollCost = Payroll::where('month', $currentMonth)->sum('net_salary');

        $recentLeaves = Leave::with('employee.user')
                              ->where('status', 'pending')
                              ->latest()
                              ->take(5)
                              ->get();

        return view('dashboard', compact(
            'totalEmployees',
            'pendingLeaves',
            'todayPresent',
            'todayAbsent',
            'monthlyPayrollCost',
            'recentLeaves'
        ));
    }
}