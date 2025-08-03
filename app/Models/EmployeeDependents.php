<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EmployeeDependents extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id','uuid','draft_employee_id', 'full_name', 'relation', 'gender', 'date_of_birth',
        'nationality', 'residence_or_school'
    ];
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }
}
