<?php

namespace App\Models;

use App\Helpers\httpHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Recrutement extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'center',
        'uuid',
        'country_duty_station',
        'city_duty_station',
        'position_title',
        'recrutement_id',
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
        'salary_post'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
            $model->date = Carbon::now()->toDateString();
            $model->recrutement_id = httpHelper::generateRecruitmentCode(self::max('id') ?? 0);
        });
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class,'employee_id', 'employeeId');
    }
}
