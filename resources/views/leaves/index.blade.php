<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Leave Management') }}
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
                    <h3 class="text-lg font-semibold">All Leave Requests</h3>
                    <a href="{{ route('leaves.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        + Apply Leave
                    </a>
                </div>

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3 border">Employee</th>
                            <th class="p-3 border">Leave Type</th>
                            <th class="p-3 border">Start Date</th>
                            <th class="p-3 border">End Date</th>
                            <th class="p-3 border">Status</th>
                            <th class="p-3 border">Approved By</th>
                            <th class="p-3 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($leaves as $leave)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3 border">{{ $leave->employee->user->name }}</td>
                                <td class="p-3 border">{{ ucfirst($leave->leave_type) }}</td>
                                <td class="p-3 border">{{ $leave->start_date->format('d M Y') }}</td>
                                <td class="p-3 border">{{ $leave->end_date->format('d M Y') }}</td>
                                <td class="p-3 border">
                                    @php
                                        $colors = [
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'approved' => 'bg-green-100 text-green-700',
                                            'rejected' => 'bg-red-100 text-red-700',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 rounded text-xs {{ $colors[$leave->status] }}">
                                        {{ ucfirst($leave->status) }}
                                    </span>
                                </td>
                                <td class="p-3 border">{{ $leave->approver->name ?? '-' }}</td>
                                <td class="p-3 border space-x-2">
                                    <a href="{{ route('leaves.show', $leave) }}" class="text-blue-600 hover:underline">View</a>

                                    @if ($leave->status === 'pending')
                                        <form action="{{ route('leaves.approve', $leave) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-green-600 hover:underline">Approve</button>
                                        </form>
                                        <form action="{{ route('leaves.reject', $leave) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-red-600 hover:underline">Reject</button>
                                        </form>
                                    @endif

                                    @if ($leave->status === 'pending')
                                        <a href="{{ route('leaves.edit', $leave) }}" class="text-yellow-600 hover:underline">Edit</a>
                                        <form action="{{ route('leaves.destroy', $leave) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-3 text-center text-gray-500">No leave requests found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>