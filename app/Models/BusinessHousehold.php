<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessHousehold extends Model
{
    use HasFactory;

    protected $fillable = [
        "license_number",
        "date_issued",
        'business_owner_full_name',
        'business_dob',
        'house_number',
        'road_id',
        'signboard',
        'business_field',
        'phone',
        'cccd',
        'address',
        'status',
        'category_market_id',
        'stalls',
    ];

    public function road()
    {
        return $this->belongsTo(Road::class);
    }

    public function categoryMarket()
    {
        return $this->belongsTo(CategoryMarket::class, 'category_market_id');
    }

}
