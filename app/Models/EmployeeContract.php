<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class EmployeeContract extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'resno',
        'uuid',
        'position_posno',
        'recrutement_id',
        'type_of_contract',
        'contract_start_date',
        'contract_end_date',
        'probation_end_date_1',
        'probation_end_date_2',
        'bg_level_equivalent',
        'supervisor_posno',
        'position_classification',
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
