<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance Management') }}
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
                    <h3 class="text-lg font-semibold">All Attendance Records</h3>
                    <a href="{{ route('attendances.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        + Record Attendance
                    </a>
                </div>

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3 border">Employee</th>
                            <th class="p-3 border">Date</th>
                            <th class="p-3 border">Check In</th>
                            <th class="p-3 border">Check Out</th>
                            <th class="p-3 border">Status</th>
                            <th class="p-3 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attendances as $attendance)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3 border">{{ $attendance->employee->user->name }}</td>
                                <td class="p-3 border">{{ $attendance->date->format('d M Y') }}</td>
                                <td class="p-3 border">{{ $attendance->check_in ?? '-' }}</td>
                                <td class="p-3 border">{{ $attendance->check_out ?? '-' }}</td>
                                <td class="p-3 border">
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
                                </td>
                                <td class="p-3 border space-x-2">
                                    <a href="{{ route('attendances.show', $attendance) }}" class="text-blue-600 hover:underline">View</a>
                                    <a href="{{ route('attendances.edit', $attendance) }}" class="text-yellow-600 hover:underline">Edit</a>
                                    <form action="{{ route('attendances.destroy', $attendance) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-3 text-center text-gray-500">No attendance records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>