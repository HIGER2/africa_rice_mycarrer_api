<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeContract extends Model
{
    use HasFactory;
    protected $fillable = [
        'employeeId',
        'resno',
        'position_posno',
        'type_of_contract',
        'contract_start_date',
        'contract_end_date',
        'probation_end_date_1',
        'probation_end_date_2',
        'bg_level_equivalent',
        'supervisor_posno',
        'position_classification',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employeeId');
    }
}
