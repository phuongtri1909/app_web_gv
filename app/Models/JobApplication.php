<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;
    protected $table = 'job_application';

    protected $fillable = [
        'full_name',
        'birth_year',
        'gender',
        'phone',
        'fax',
        'email',
        'introduction',
        'job_registration',
        'status',
    ];
}
