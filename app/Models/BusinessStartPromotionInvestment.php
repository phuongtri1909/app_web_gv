<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessStartPromotionInvestment extends Model
{
    use HasFactory;

    protected $table = 'business_start_promotion_investment';

    protected $fillable = [
        'representative_name',
        'birth_year',
        'gender',
        'phone',
        'address',
        'business_address',
        'business_name',
        'business_field',
        'business_code',
        'email',
        'fanpage',
        'business_support_needs_id'
    ];

    public function supportNeeds()
    {
        return $this->belongsTo(BusinessSupportNeed::class, 'business_support_needs_id');
    }
}
