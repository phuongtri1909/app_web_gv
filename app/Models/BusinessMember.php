<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessMember extends Model
{
    use HasFactory;
    protected $table = 'business_registrations';
    protected $fillable = [
        'business_name',
        'business_code',
        'address',
        'email',
        'phone_zalo',
        'business_field',
        'representative_full_name',
        'representative_phone',
        'status',
    ];

    public function businessField()
    {
        return $this->belongsTo(BusinessField::class, 'business_field');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'business_member_id');
    }
}
