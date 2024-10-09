<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objective extends Model
{
    use HasFactory;

    protected $primaryKey = 'objectiveId';
    public $timestamps = false;
    protected $fillable = [
        'objectiveId',
        'status',
        'objectiveYear',
        'employeeId',
        'supervisorId',
        'evaluationStatus',
        'selfEvaluationStatus',
        'reviewStatus',
        'selfReviewStatus',
        'createdAt',
        'updatedAt',
        'deletedAt',
        'title',
        'description',
        'successConditions',
        'deadline',
        'kpi',
        'grade',
        'comment',
        'selfComment',
        'midtermSelfComment',
        'midtermComment',
    ];
}
