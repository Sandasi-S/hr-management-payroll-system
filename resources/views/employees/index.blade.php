<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employee Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">All Employees</h3>
                    <a href="{{ route('employees.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        + Add Employee
                    </a>
                </div>

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3 border">Code</th>
                            <th class="p-3 border">Name</th>
                            <th class="p-3 border">Email</th>
                            <th class="p-3 border">Department</th>
                            <th class="p-3 border">Designation</th>
                            <th class="p-3 border">Status</th>
                            <th class="p-3 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employees as $employee)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3 border">{{ $employee->employee_code }}</td>
                                <td class="p-3 border">{{ $employee->user->name }}</td>
                                <td class="p-3 border">{{ $employee->user->email }}</td>
                                <td class="p-3 border">{{ $employee->department }}</td>
                                <td class="p-3 border">{{ $employee->designation }}</td>
                                <td class="p-3 border">
                                    <span class="px-2 py-1 rounded text-xs {{ $employee->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ ucfirst($employee->status) }}
                                    </span>
                                </td>
                                <td class="p-3 border space-x-2">
                                    <a href="{{ route('employees.show', $employee) }}" class="text-blue-600 hover:underline">View</a>
                                    <a href="{{ route('employees.edit', $employee) }}" class="text-yellow-600 hover:underline">Edit</a>
                                    <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-3 text-center text-gray-500">No employees found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>