<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500">Total Employees</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalEmployees }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <p class="text-sm text-gray-500">Pending Leave Requests</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $pendingLeaves }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <p class="text-sm text-gray-500">Present Today</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $todayPresent }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                    <p class="text-sm text-gray-500">Absent Today</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $todayAbsent }}</p>
                </div>

            </div>

            <!-- Monthly Payroll Cost -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-sm text-gray-500">This Month's Total Payroll Cost</p>
                <p class="text-4xl font-bold text-blue-600">Rs. {{ number_format($monthlyPayrollCost, 2) }}</p>
            </div>

            <!-- Recent Pending Leave Requests -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Recent Pending Leave Requests</h3>

                @if ($recentLeaves->isEmpty())
                    <p class="text-gray-500">No pending leave requests.</p>
                @else
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="p-2 border">Employee</th>
                                <th class="p-2 border">Leave Type</th>
                                <th class="p-2 border">Start Date</th>
                                <th class="p-2 border">End Date</th>
                                <th class="p-2 border">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentLeaves as $leave)
                                <tr class="border-b">
                                    <td class="p-2 border">{{ $leave->employee->user->name }}</td>
                                    <td class="p-2 border">{{ ucfirst($leave->leave_type) }}</td>
                                    <td class="p-2 border">{{ $leave->start_date->format('d M Y') }}</td>
                                    <td class="p-2 border">{{ $leave->end_date->format('d M Y') }}</td>
                                    <td class="p-2 border">
                                        <a href="{{ route('leaves.show', $leave) }}" class="text-blue-600 hover:underline">Review</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <!-- Quick Links -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                <div class="flex space-x-4">
                    <a href="{{ route('employees.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Manage Employees
                    </a>
                    <a href="{{ route('attendances.index') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Manage Attendance
                    </a>
                    <a href="{{ route('leaves.index') }}" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                        Manage Leaves
                    </a>
                    <a href="{{ route('payrolls.index') }}" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                        Manage Payroll
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>