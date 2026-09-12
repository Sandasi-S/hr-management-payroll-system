<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\PayrollController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'role:admin,hr_manager'])->group(function () {
    Route::resource('employees', EmployeeController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::resource('leaves', LeaveController::class)->parameters(['leaves' => 'leave']);
    Route::patch('/leaves/{leave}/approve', [LeaveController::class, 'approve'])->name('leaves.approve');
    Route::patch('/leaves/{leave}/reject', [LeaveController::class, 'reject'])->name('leaves.reject');
    Route::resource('payrolls', PayrollController::class);
});
