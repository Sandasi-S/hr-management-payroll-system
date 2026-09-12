<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * Display a listing of leave requests.
     */
    public function index()
    {
        $leaves = Leave::with('employee.user', 'approver')->latest()->get();
        return view('leaves.index', compact('leaves'));
    }

    /**
     * Show the form for creating a new leave request.
     */
    public function create()
    {
        $employees = Employee::with('user')->where('status', 'active')->get();
        return view('leaves.create', compact('employees'));
    }

    /**
     * Store a newly created leave request.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'leave_type' => 'required|in:sick,annual,casual',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'reason' => 'nullable|string',
    ]);

    // Prevent overlapping leave requests for the same employee
    $overlapping = Leave::where('employee_id', $validated['employee_id'])
                         ->whereIn('status', ['pending', 'approved'])
                         ->where(function ($query) use ($validated) {
                             $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                                   ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                                   ->orWhere(function ($q) use ($validated) {
                                       $q->where('start_date', '<=', $validated['start_date'])
                                         ->where('end_date', '>=', $validated['end_date']);
                                   });
                         })
                         ->exists();

    if ($overlapping) {
        return back()->withErrors(['start_date' => 'This employee already has a pending or approved leave request that overlaps with these dates.'])->withInput();
    }

    // Status is always 'pending' when first created
    $validated['status'] = 'pending';

    Leave::create($validated);

        return redirect()->route('leaves.index')->with('success', 'Leave request submitted successfully!');
    }

    /**
     * Display the specified leave request.
     */
    public function show(Leave $leave)
    {
        $leave->load('employee.user', 'approver');
        return view('leaves.show', compact('leave'));
    }

    /**
     * Show the form for editing the specified leave request.
     */
    public function edit(Leave $leave)
    {
        if ($leave->status !== 'pending') {
            return redirect()->route('leaves.index')->with('error', 'Only pending leave requests can be edited.');
        }

        $employees = Employee::with('user')->where('status', 'active')->get();
        return view('leaves.edit', compact('leave', 'employees'));
    }

    /**
     * Update the specified leave request.
     */
    public function update(Request $request, Leave $leave)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type' => 'required|in:sick,annual,casual',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
        ]);

        $leave->update($validated);

        return redirect()->route('leaves.index')->with('success', 'Leave request updated successfully!');
    }

    /**
     * Remove the specified leave request.
     */
    public function destroy(Leave $leave)
{
    try {
        $leave->delete();
        return redirect()->route('leaves.index')->with('success', 'Leave request deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('leaves.index')->with('error', 'Delete failed: ' . $e->getMessage());
    }
}

    /**
     * Approve the specified leave request.
     */
    public function approve(Leave $leave)
    {
        $leave->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
        ]);

        return redirect()->route('leaves.index')->with('success', 'Leave request approved!');
    }

    /**
     * Reject the specified leave request.
     */
    public function reject(Leave $leave)
    {
        $leave->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
        ]);

        return redirect()->route('leaves.index')->with('success', 'Leave request rejected!');
    }
}