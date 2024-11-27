<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessFairRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_member_id',
        'business_license',
        'representative_full_name',
        'birth_year',
        'gender',
        'phone_zalo',
        'products',
        'product_images',
        'booth_count',
        'discount_percentage',
        'is_join_stage_promotion',
        'is_join_charity',
        'status',
        'news_id',
    ];

    /**
     * Relationship with BusinessRegistration (belongsTo).
     */
    public function businessMember()
    {
        return $this->belongsTo(BusinessMember::class, 'business_member_id');
    }

    /**
     * Relationship with News (belongsTo).
     */
    public function news()
    {
        return $this->belongsTo(News::class, 'news_id');
    }
}
