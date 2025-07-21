<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class employeeRecruitment extends Model
{
    use HasFactory;
    protected $fillable = [
        'employeeId',
        'center',
        'country_duty_station',
        'city_duty_station',
        'position_title',
        'recruitment_id',
        'contract_from',
        'contract_to',
        'grade',
        'division',
        'program',
        'sub_unit',
        'education_level',
        'resources_type',
        'contract_time',
        'supervisor_name',
        'supervisor_position',
        'recruitment_type',
        'country_of_recruitment',
        'cgiar_workforce_group',
        'cgiar_group',
        'cgiar_appointed',
        'percent_time_other_center',
        'shared_working_arrangement',
        'initiative_lead',
        'initiative_personnel',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employeeId');
    }
}
