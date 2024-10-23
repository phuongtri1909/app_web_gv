<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessCapitalNeed extends Model
{
    use HasFactory;

    protected $table = 'business_capital_needs';
    protected $fillable = [
        'business_name',
        'business_code',
        'category_business_id',
        'address',
        'phone',
        'fax',
        'email',
        'representative_name',
        'gender',
        'interest_rate',
        'finance',
        'mortgage_policy',
        'unsecured_policy',
        'purpose',
        'bank_connection',
        'feedback',
        'status'
    ];
    public function categoryBusiness()
    {
        return $this->belongsTo(CategoryBusiness::class, 'category_business_id');
    }

}
