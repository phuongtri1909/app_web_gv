<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerInterest extends Model
{
    protected $table = 'customer_interest';

    protected $fillable = ['name', 'phone_number', 'financial_support_id','birth_year','gender','residence_address','business_address','company_name','business_field','tax_code','email','fanpage','support_needs','bank_service_id'];

    public function financialSupport()
    {
        return $this->belongsTo(FinancialSupport::class,'financial_support_id');
    }

    // public function personalBusinessInterest()
    // {
    //     return $this->belongsTo(PersonalBusinessInterest::class, 'interest_id');
    // }

    public function bankServicesInterest()
    {
        return $this->belongsTo(BankServicesInterest::class, 'bank_service_id');
    }
}
