<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address_address',
        'address_latitude',
        'address_longitude',
    ];
    public function businessPromotionalIntroductions()
    {
        return $this->belongsTo(BusinessPromotionalIntroduction::class, 'business_code_id', 'business_code'); 
    }
}
