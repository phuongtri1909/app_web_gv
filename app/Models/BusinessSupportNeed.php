<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSupportNeed extends Model
{
    use HasFactory;
    protected $table = 'business_support_needs';

    protected $fillable = [
        'name',
        'status',
    ];

    public function businessStartPromotionInvestments()
    {
        return $this->hasMany(BusinessStartPromotionInvestment::class, 'business_support_needs_id');
    }
}
