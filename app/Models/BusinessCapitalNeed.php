<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessCapitalNeed extends Model
{
    use HasFactory;

    protected $table = 'business_capital_needs';
    protected $fillable = [
        'business_member_id',
        'finance',
        'loan_cycle',
        'interest_rate',
        'purpose',
        'bank_connection',
        'support_policy',
        'feedback',
        'email_status',
    ];
    
    public function businessMember()
    {
        return $this->belongsTo(BusinessMember::class, 'business_member_id', 'id');
    }
    
}
