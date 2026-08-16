<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_code',
        'nic',
        'phone',
        'address',
        'department',
        'designation',
        'basic_salary',
        'join_date',
        'status',
    ];

    protected $casts = [
        'join_date' => 'date',
        'basic_salary' => 'decimal:2',
    ];

    // Relationship: Employee belongs to a User (login account)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}