<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employee Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Employee Code</p>
                        <p class="font-medium">{{ $employee->employee_code }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <span class="px-2 py-1 rounded text-xs {{ $employee->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($employee->status) }}
                        </span>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Full Name</p>
                        <p class="font-medium">{{ $employee->user->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium">{{ $employee->user->email }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">NIC</p>
                        <p class="font-medium">{{ $employee->nic ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Phone</p>
                        <p class="font-medium">{{ $employee->phone ?? '-' }}</p>
                    </div>

                    <div class="col-span-2">
                        <p class="text-sm text-gray-500">Address</p>
                        <p class="font-medium">{{ $employee->address ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Department</p>
                        <p class="font-medium">{{ $employee->department }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Designation</p>
                        <p class="font-medium">{{ $employee->designation }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Basic Salary</p>
                        <p class="font-medium">Rs. {{ number_format($employee->basic_salary, 2) }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Join Date</p>
                        <p class="font-medium">{{ $employee->join_date->format('d M Y') }}</p>
                    </div>
                </div>

                <div class="mt-6 flex space-x-3">
                    <a href="{{ route('employees.edit', $employee) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                        Edit
                    </a>
                    <a href="{{ route('employees.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                        Back to List
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>