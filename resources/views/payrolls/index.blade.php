<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payroll Management') }}
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

                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">All Payroll Records</h3>
                    <a href="{{ route('payrolls.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        + Generate Payroll
                    </a>
                </div>

                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3 border">Employee</th>
                            <th class="p-3 border">Month</th>
                            <th class="p-3 border">Basic Salary</th>
                            <th class="p-3 border">Allowances</th>
                            <th class="p-3 border">Deductions</th>
                            <th class="p-3 border">No-Pay Days</th>
                            <th class="p-3 border">Net Salary</th>
                            <th class="p-3 border">Status</th>
                            <th class="p-3 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payrolls as $payroll)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3 border">{{ $payroll->employee->user->name }}</td>
                                <td class="p-3 border">{{ $payroll->month }}</td>
                                <td class="p-3 border">Rs. {{ number_format($payroll->basic_salary, 2) }}</td>
                                <td class="p-3 border">Rs. {{ number_format($payroll->allowances, 2) }}</td>
                                <td class="p-3 border">Rs. {{ number_format($payroll->deductions, 2) }}</td>
                                <td class="p-3 border">{{ $payroll->no_pay_days }}</td>
                                <td class="p-3 border font-semibold">Rs. {{ number_format($payroll->net_salary, 2) }}</td>
                                <td class="p-3 border">
                                    <span class="px-2 py-1 rounded text-xs {{ $payroll->status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ ucfirst($payroll->status) }}
                                    </span>
                                </td>
                                <td class="p-3 border space-x-2">
                                    <a href="{{ route('payrolls.show', $payroll) }}" class="text-blue-600 hover:underline">View</a>
                                    <a href="{{ route('payrolls.edit', $payroll) }}" class="text-yellow-600 hover:underline">Edit</a>
                                    <form action="{{ route('payrolls.destroy', $payroll) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="p-3 text-center text-gray-500">No payroll records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>