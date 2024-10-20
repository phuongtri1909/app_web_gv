<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerInterest extends Model
{
    protected $table = 'customer_interest';

    protected $fillable = ['name', 'phone_number', 'interest_id', 'bank_services_id', 'financial_support_id'];

    public function financialSupport()
    {
        return $this->belongsTo(FinancialSupport::class);
    }

    public function personalBusinessInterest()
    {
        return $this->belongsTo(PersonalBusinessInterest::class, 'interest_id');
    }

    public function bankServicesInterest()
    {
        return $this->belongsTo(BankServicesInterest::class, 'bank_services_id');
    }
}
