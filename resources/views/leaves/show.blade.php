<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Leave Request Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Employee</p>
                        <p class="font-medium">{{ $leave->employee->user->name }} ({{ $leave->employee->employee_code }})</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Status</p>
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
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Leave Type</p>
                        <p class="font-medium">{{ ucfirst($leave->leave_type) }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Department</p>
                        <p class="font-medium">{{ $leave->employee->department }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Start Date</p>
                        <p class="font-medium">{{ $leave->start_date->format('d M Y') }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">End Date</p>
                        <p class="font-medium">{{ $leave->end_date->format('d M Y') }}</p>
                    </div>

                    <div class="col-span-2">
                        <p class="text-sm text-gray-500">Reason</p>
                        <p class="font-medium">{{ $leave->reason ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Approved/Rejected By</p>
                        <p class="font-medium">{{ $leave->approver->name ?? '-' }}</p>
                    </div>
                </div>

                <div class="mt-6 flex space-x-3">
                    @if ($leave->status === 'pending')
                        <form action="{{ route('leaves.approve', $leave) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                Approve
                            </button>
                        </form>
                        <form action="{{ route('leaves.reject', $leave) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                Reject
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('leaves.edit', $leave) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                        Edit
                    </a>
                    <a href="{{ route('leaves.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                        Back to List
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>