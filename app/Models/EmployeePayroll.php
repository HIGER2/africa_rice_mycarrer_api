<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class EmployeePayroll extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'basic_salary',
        'uuid',
        'salary_currency',
        'salary_frequency',
        'transport_allowance',
        'housing_allowance',
        'recrutement_id',
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

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
            $model->date = Carbon::now()->toDateString();
        });
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employeeId');
    }
}
