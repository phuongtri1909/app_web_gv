<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessCapitalNeed extends Model
{
    use HasFactory;

    protected $table = 'business_capital_needs';
    protected $fillable = [
        'business_id',
        'interest_rate',
        'finance',
        'mortgage_policy',
        'unsecured_policy',
        'purpose',
        'bank_connection',
        'feedback',
        'status'
    ];
    // public function categoryBusiness()
    // {
    //     return $this->belongsTo(CategoryBusiness::class, 'category_business_id');
    // }
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

}
