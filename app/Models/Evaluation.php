<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $primaryKey = 'evaluationId';
    // public $incrementing = false;
    // protected $keyType = 'string';

    public $timestamps = false;
    protected $fillable = [
        'evaluationId',
        'employeeId',
        'supervisorId',
        'supervisorJobTitle',
        'evaluationYear',
        'evaluationStatus',
        'updatedAt',
        'createdAt',
        'efficiency',
        'efficiencyRating',
        'competency',
        'competencyRating',
        'commitment',
        'commitmentRating',
        'initiative',
        'initiativeRating',
        'respect',
        'respectRating',
        'leadership',
        'leadershipRating',
        'overall',
        'overallRating',
        'selfEvaluationStatus',
        'selfEfficiency',
        'selfCompetency',
        'selfCommitment',
        'selfInitiative',
        'selfRespect',
        'selfLeadership',
        'selfOverall',
    ];
}
