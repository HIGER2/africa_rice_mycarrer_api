<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;
     use HasFactory;

     protected $table = 'employees';

    protected $primaryKey = 'employeeId';

    // public $incrementing = false;
    // protected $keyType = 'string';

    public $timestamps = false;
    protected $fillable = [
        'employeeId',
        'role',
        'firstName',
        'lastName',
        'jobTitle',
        'email',
        'supervisorId',
        'matricule',
        'personalEmail',
        'phone2',
        'phone',
        'address',
        'password',
        'category',
        'grade',
        'bgLevel',
        'deletedAt',
        'secretKey',
        
        'date_of_birth', 
        'country_of_birth', 
        'gender',
        'nationality_1', 
        'nationality_2', 
        'passport_number', 
        'social_security_number',
        'permanent_address', 
        'country_of_residence', 
        'town_of_residence',
        'marital_status', 

        'number_of_children',

        'family_living_with_staff', 
        'family_residence_location', 

        'spouse_works', 
        'spouse_workplace'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function supervisor()
    {
        return $this->belongsTo(Staff::class, 'supervisorId', 'employeeId');
    }

    public function objectives()
    {
        return $this->hasMany(Objective::class, 'objectiveId', 'employeeId');
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'evaluationId', 'employeeId');
    }

     public function dependents(): HasMany {
        return $this->hasMany(EmployeeDependents::class,'employeeId');
    }

    public function emergencyContacts(): HasMany {
        return $this->hasMany(EmployeeEmergencyContacts::class,'employeeId');
    }

    public function beneficiaries(): HasMany {
        return $this->hasMany(EmployeeBeneficiary::class,'employeeId');
    }
    
        public function contract() {
            return $this->hasOne(EmployeeContract::class, 'employeeId');
        }

        public function payroll() {
            return $this->hasOne(EmployeePayroll::class, 'employeeId');
        }

        public function position() {
            return $this->hasOne(employeeRecruitment::class, 'employeeId');
        }

}
