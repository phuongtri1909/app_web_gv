<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessPromotionalIntroduction extends Model
{
    use HasFactory;

    protected $table = 'business_promotional_introduction';
    protected $fillable = [
        'representative_name',
        'birth_year',
        'gender',
        'phone_number',
        'address',
        'business_address',
        'business_name',
        'license',
        'business_field_id',
        'business_code',
        'email',
        'social_channel',
        'logo',
        'product_image',
        'product_video',
    ];

    public function businessField()
    {
        return $this->belongsToMany(BusinessField::class, 'business_field_business', 'business_id', 'business_field_id');
    }
    public function location()
    {
        return $this->hasMany(Locations::class, 'business_code_id', 'business_code');
    }
}
