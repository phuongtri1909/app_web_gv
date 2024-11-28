<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessRecruitment extends Model
{
    use HasFactory;

    protected $table = 'business_recruitment';
    protected $fillable = [
        'business_member_id',
        'recruitment_images',
        'recruitment_title',
        'recruitment_content',
        'status',

    ];

    public function businessMember()
    {
        return $this->belongsTo(BusinessMember::class, 'business_member_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }
}
