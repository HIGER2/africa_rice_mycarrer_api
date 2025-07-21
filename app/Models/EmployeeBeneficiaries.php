<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeBeneficiary extends Model
{
    use HasFactory;
    protected $fillable = [
        'employeeId', 'full_name', 'relationship', 'birthday',
        'address', 'email', 'percentage_share'
    ];
}
