<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees.
     */
    public function index()
    {
        $employees = Employee::with('user')->latest()->get();
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created employee in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'employee_code' => 'required|string|unique:employees',
            'nic' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'department' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'basic_salary' => 'required|numeric|min:0',
            'join_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        // Create the User account first (login credentials)
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'employee',
        ]);

        // Create the Employee record linked to that User
        Employee::create([
            'user_id' => $user->id,
            'employee_code' => $validated['employee_code'],
            'nic' => $validated['nic'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'department' => $validated['department'],
            'designation' => $validated['designation'],
            'basic_salary' => $validated['basic_salary'],
            'join_date' => $validated['join_date'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee added successfully!');
    }

    /**
     * Display the specified employee.
     */
    public function show(Employee $employee)
    {
        $employee->load('user');
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(Employee $employee)
    {
        $employee->load('user');
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified employee in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $employee->user_id,
            'employee_code' => 'required|string|unique:employees,employee_code,' . $employee->id,
            'nic' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'department' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'basic_salary' => 'required|numeric|min:0',
            'join_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        // Update the linked User account
        $employee->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Update the Employee record
        $employee->update([
            'employee_code' => $validated['employee_code'],
            'nic' => $validated['nic'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'department' => $validated['department'],
            'designation' => $validated['designation'],
            'basic_salary' => $validated['basic_salary'],
            'join_date' => $validated['join_date'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully!');
    }

    /**
     * Remove the specified employee from storage.
     */
    public function destroy(Employee $employee)
    {
        // Deleting the user will also delete the employee record (cascade)
        $employee->user->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully!');
    }
}