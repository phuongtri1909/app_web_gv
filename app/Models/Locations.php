<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_member_id',
        'business_field_id',
        'name',
        'address_address',
        'address_latitude',
        'address_longitude',
        'description',
        'link_video',
        'status',

    ];
    
    public function businessField()
    {
        return $this->belongsTo(BusinessField::class, 'business_field_id');
    }

    public function businessMember()
    {
        return $this->belongsTo(BusinessMember::class, 'business_member_id');
    }

    public function locationProducts()
    {
        return $this->hasMany(LocationProduct::class, 'location_id');
    }

}
