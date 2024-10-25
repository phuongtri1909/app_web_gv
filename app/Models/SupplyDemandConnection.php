<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyDemandConnection extends Model
{
    use HasFactory;

    protected $table = 'business_connect_supply_demand';
    protected $fillable = [
        'owner_full_name',
        'birth_year', 
        'gender',
        'residential_address',
        'business_address',
        'phone',
        'business_code',
        'business_name',
        'business_field',
        'email',
        'fanpage',
        'product_info',
        'product_standard',
        'product_avatar',
        'product_images',
        'product_price',
        'product_price_mini_app',
        'product_price_member',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'birth_year' => 'integer',
        'product_price' => 'decimal:2',
        'product_price_mini_app' => 'decimal:2', 
        'product_price_member' => 'decimal:2',
        'product_images' => 'array',
        'start_date' => 'date',
        'end_date' => 'date'
    ];
}
