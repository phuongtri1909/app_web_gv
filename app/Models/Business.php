<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $table = 'businesses';

    protected $fillable = [
        'business_member_id',
        'description',
        'avt_businesses',
        'status',
    ];

    public function businessMember()
    {
        return $this->belongsTo(BusinessMember::class, 'business_member_id', 'id');
    }

    public function businessMembers()
    {
        return $this->hasMany(BusinessMember::class, 'business_id', 'id');
    }
}
