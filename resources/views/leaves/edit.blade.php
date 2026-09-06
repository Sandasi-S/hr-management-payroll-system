<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Leave Request') }}
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

                <form action="{{ route('leaves.update', $leave) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Employee</label>
                        <select name="employee_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id', $leave->employee_id) == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->employee_code }} - {{ $employee->user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Leave Type</label>
                        <select name="leave_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="sick" {{ $leave->leave_type === 'sick' ? 'selected' : '' }}>Sick Leave</option>
                            <option value="annual" {{ $leave->leave_type === 'annual' ? 'selected' : '' }}>Annual Leave</option>
                            <option value="casual" {{ $leave->leave_type === 'casual' ? 'selected' : '' }}>Casual Leave</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date', $leave->start_date->format('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">End Date</label>
                        <input type="date" name="end_date" value="{{ old('end_date', $leave->end_date->format('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Reason (Optional)</label>
                        <textarea name="reason" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('reason', $leave->reason) }}</textarea>
                    </div>

                    <div class="flex items-center space-x-3">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Update Leave Request
                        </button>
                        <a href="{{ route('leaves.index') }}" class="text-gray-600 hover:underline">Cancel</a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>