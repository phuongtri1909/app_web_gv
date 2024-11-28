<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessStartPromotionInvestment extends Model
{
    use HasFactory;

    protected $table = 'business_start_promotion_investment';

    protected $fillable = [
        'name',
        'birth_year',
        'gender',
        'phone',
        'startup_address',
        'business_field',
        'startup_activity_info',
        'business_support_needs_id',
        'status',
    ];
    

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
    public function supportNeeds()
    {
        return $this->belongsTo(BusinessSupportNeed::class, 'business_support_needs_id');
    }
}
