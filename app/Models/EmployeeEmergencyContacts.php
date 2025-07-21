<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeEmergencyContacts extends Model
{
    use HasFactory;
     protected $fillable = [
        'employeeId', 'name', 'relationship', 'address', 'telephone', 'email'
    ];
}
