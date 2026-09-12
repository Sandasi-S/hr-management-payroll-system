<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Payroll') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-4 p-4 bg-gray-50 rounded">
                    <p class="text-sm text-gray-500">Employee: <span class="font-medium">{{ $payroll->employee->user->name }}</span></p>
                    <p class="text-sm text-gray-500">Month: <span class="font-medium">{{ $payroll->month }}</span></p>
                    <p class="text-sm text-gray-500">Basic Salary: <span class="font-medium">Rs. {{ number_format($payroll->basic_salary, 2) }}</span></p>
                    <p class="text-sm text-gray-500">No-Pay Days: <span class="font-medium">{{ $payroll->no_pay_days }}</span> (Deduction: Rs. {{ number_format($payroll->no_pay_deduction, 2) }})</p>
                </div>

                <form action="{{ route('payrolls.update', $payroll) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Allowances</label>
                        <input type="number" step="0.01" name="allowances" value="{{ old('allowances', $payroll->allowances) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Other Deductions</label>
                        <input type="number" step="0.01" name="deductions" value="{{ old('deductions', $payroll->deductions) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Status</label>
                        <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="pending" {{ $payroll->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $payroll->status === 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>

                    <div class="flex items-center space-x-3">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Update Payroll
                        </button>
                        <a href="{{ route('payrolls.index') }}" class="text-gray-600 hover:underline">Cancel</a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>