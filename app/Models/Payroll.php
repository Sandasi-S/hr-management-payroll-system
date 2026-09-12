<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'month',
        'basic_salary',
        'allowances',
        'deductions',
        'no_pay_days',
        'no_pay_deduction',
        'net_salary',
        'status',
    ];

    protected $casts = [
        'basic_salary' => 'decimal:2',
        'allowances' => 'decimal:2',
        'deductions' => 'decimal:2',
        'no_pay_deduction' => 'decimal:2',
        'net_salary' => 'decimal:2',
    ];

    // Relationship: Payroll belongs to an Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}