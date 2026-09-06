<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'leave_type',
        'start_date',
        'end_date',
        'reason',
        'status',
        'approved_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Relationship: Leave belongs to an Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Relationship: Leave was approved by a User (admin/HR)
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}