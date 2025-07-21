<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDependents extends Model
{
    use HasFactory;
    protected $fillable = [
        'employeeId', 'full_name', 'relation', 'gender', 'date_of_birth',
        'nationality', 'residence_or_school'
    ];
}
