<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessFeedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'opinion',
        'suggestions',
        'owner_full_name',
        'birth_year',
        'gender',
        'phone',
        'residential_address',
        'business_name',
        'business_address',
        'email',
        'fanpage',
        'business_license',
        'attached_images',
    ];
}
