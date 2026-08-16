<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Employee</p>
                        <p class="font-medium">{{ $attendance->employee->user->name }} ({{ $attendance->employee->employee_code }})</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        @php
                            $colors = [
                                'present' => 'bg-green-100 text-green-700',
                                'absent' => 'bg-red-100 text-red-700',
                                'late' => 'bg-yellow-100 text-yellow-700',
                            ];
                        @endphp
                        <span class="px-2 py-1 rounded text-xs {{ $colors[$attendance->status] }}">
                            {{ ucfirst($attendance->status) }}
                        </span>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Date</p>
                        <p class="font-medium">{{ $attendance->date->format('d M Y') }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Department</p>
                        <p class="font-medium">{{ $attendance->employee->department }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Check In</p>
                        <p class="font-medium">{{ $attendance->check_in ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Check Out</p>
                        <p class="font-medium">{{ $attendance->check_out ?? '-' }}</p>
                    </div>

                    <div class="col-span-2">
                        <p class="text-sm text-gray-500">Remarks</p>
                        <p class="font-medium">{{ $attendance->remarks ?? '-' }}</p>
                    </div>
                </div>

                <div class="mt-6 flex space-x-3">
                    <a href="{{ route('attendances.edit', $attendance) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                        Edit
                    </a>
                    <a href="{{ route('attendances.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                        Back to List
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>