<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Employee') }}
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

                <form action="{{ route('employees.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Password</label>
                        <input type="password" name="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Employee Code</label>
                        <input type="text" name="employee_code" value="{{ old('employee_code') }}" placeholder="e.g., EMP001" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">NIC</label>
                        <input type="text" name="nic" value="{{ old('nic') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Address</label>
                        <textarea name="address" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('address') }}</textarea>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Department</label>
                        <input type="text" name="department" value="{{ old('department') }}" placeholder="e.g., IT, HR, Finance" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Designation</label>
                        <input type="text" name="designation" value="{{ old('designation') }}" placeholder="e.g., Software Engineer" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Basic Salary</label>
                        <input type="number" step="0.01" name="basic_salary" value="{{ old('basic_salary') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Join Date</label>
                        <input type="date" name="join_date" value="{{ old('join_date') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Status</label>
                        <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="flex items-center space-x-3">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Save Employee
                        </button>
                        <a href="{{ route('employees.index') }}" class="text-gray-600 hover:underline">Cancel</a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>