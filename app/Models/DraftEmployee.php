<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class DraftEmployee extends Model
{
    protected $fillable = [
        'firstName',
        'uuid',
        'lastName',
        'date_of_birth',
        'recrutement_id',
        'country_of_birth',
        'gender',
        'nationality_1',
        'nationality_2',
        'indentity_number',
        'social_security_number',
        'permanent_address',
        'country_of_residence',
        'town_of_residence',
        'phone',
        'personal_email', 
        'marital_status', 
        'number_of_children',
        'family_living_with_staff', 
        'family_residence_location', 
        'spouse_works', 
        'spouse_workplace',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }

    public function dependents(): HasMany {
        return $this->hasMany(EmployeeDependents::class);
    }

    public function emergencyContacts(): HasMany {
        return $this->hasMany(EmployeeEmergencyContacts::class);
    }

    public function beneficiaries(): HasMany {
        return $this->hasMany(EmployeeBeneficiary::class);
    }
}
