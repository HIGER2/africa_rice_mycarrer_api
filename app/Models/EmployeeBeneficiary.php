<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EmployeeBeneficiary extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id','uuid','draft_employee_id', 'full_name', 'relationship', 'birthday',
        'address', 'email', 'percentage_share'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }
}
