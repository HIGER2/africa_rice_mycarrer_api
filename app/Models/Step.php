<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory;
    protected $primaryKey = 'stepId';
    public $timestamps = false;
    protected $fillable = [
        'stepId',
        'name',
        'message',
        'messageFr',
        'active',
        'dateFrom',
        'dateTo',
        'sent',
    ];
}
