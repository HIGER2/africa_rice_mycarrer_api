<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeePayroll extends Model
{
    use HasFactory;
     protected $fillable = [
        'employeeId',
        'basic_salary',
        'salary_currency',
        'salary_frequency',
        'transport_allowance',
        'housing_allowance',
        'dependent_allowance',
        'installation_allowance',
        'arrival_shipping_allowance',
        'departure_shipping_allowance',
        'health_insurance',
        'social_contribution',
        'life_insurance',
        'salary_taxes',
        'home_leave',
        'flight_ticket',
        'installation_assistance',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employeeId');
    }
}
