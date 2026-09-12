<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payroll Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="border-b pb-4 mb-4">
                    <h3 class="text-lg font-semibold">{{ $payroll->employee->user->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $payroll->employee->employee_code }} | {{ $payroll->employee->department }} | {{ $payroll->employee->designation }}</p>
                    <p class="text-sm text-gray-500">Payroll Month: <span class="font-medium">{{ $payroll->month }}</span></p>
                </div>

                <table class="w-full text-sm mb-4">
                    <tr class="border-b">
                        <td class="py-2 text-gray-600">Basic Salary</td>
                        <td class="py-2 text-right font-medium">Rs. {{ number_format($payroll->basic_salary, 2) }}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 text-gray-600">Allowances</td>
                        <td class="py-2 text-right font-medium text-green-600">+ Rs. {{ number_format($payroll->allowances, 2) }}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 text-gray-600">Other Deductions</td>
                        <td class="py-2 text-right font-medium text-red-600">- Rs. {{ number_format($payroll->deductions, 2) }}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 text-gray-600">No-Pay Deduction ({{ $payroll->no_pay_days }} days)</td>
                        <td class="py-2 text-right font-medium text-red-600">- Rs. {{ number_format($payroll->no_pay_deduction, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="py-3 font-bold text-lg">Net Salary</td>
                        <td class="py-3 text-right font-bold text-lg text-blue-600">Rs. {{ number_format($payroll->net_salary, 2) }}</td>
                    </tr>
                </table>

                <div class="mb-4">
                    <span class="px-2 py-1 rounded text-xs {{ $payroll->status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ ucfirst($payroll->status) }}
                    </span>
                </div>

                <div class="flex space-x-3">
                    <a href="{{ route('payrolls.edit', $payroll) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                        Edit
                    </a>
                    <a href="{{ route('payrolls.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                        Back to List
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>