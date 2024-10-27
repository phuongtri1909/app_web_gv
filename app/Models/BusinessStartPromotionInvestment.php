<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessStartPromotionInvestment extends Model
{
    use HasFactory;

    protected $table = 'business_start_promotion_investment';

    protected $fillable = [
        'business_id',
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
