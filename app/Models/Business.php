<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $table = 'businesses';

    protected $fillable = [
        'business_code',
        'business_name',
        'representative_name',
        'phone_number',
        'fax_number',
        'address',
        'ward_id',
        'email',
        'category_business_id',
        'business_license',
        'social_channel',
        'description',
        'avt_businesses',
        'birth_year',
        'gender',
        'business_address',
    ];

    public function ward()
    {
        return $this->belongsTo(WardGovap::class, 'ward_id');
    }
    public function categoryBusiness()
    {
        return $this->belongsTo(CategoryBusiness::class, 'category_business_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'business_id');
    }

    public function products()
    {
        return $this->hasMany(ProductBusiness::class);
    }
}
