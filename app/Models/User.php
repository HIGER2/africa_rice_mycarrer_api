<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
        return $this->belongsTo(User::class, 'employeeId', 'supervisorId');
    }

    public function objectives()
    {
        return $this->hasMany(Objective::class, 'objectiveId', 'employeeId');
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'evaluationId', 'employeeId');
    }
}
