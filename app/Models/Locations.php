<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'business_field_id', //lấy data từ bảng business_fields dùng để lấy ngành nghề kinh doanh
        'name',
        'address_address',
        'address_latitude',
        'address_longitude',
        'description',
        'image',
        'status',
    ];
    
    public function businessField()
    {
        return $this->belongsTo(BusinessField::class, 'business_field_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

}
