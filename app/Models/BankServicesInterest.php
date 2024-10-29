<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BankServicesInterest extends Model
{
    protected $table = 'bank_services_interest';

    protected $fillable = ['name','avt_bank_services','slug','bank_id'];

    // public function customerInterests()
    // {
    //     return $this->hasMany(CustomerInterest::class);
    // }
    public function businessCapitalNeed(){
        return $this->hasMany(BusinessCapitalNeed::class);
    }
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
    public function setTitleAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function tabContentDetails()
    {
        return $this->hasMany(NewsTabContentDetailPost::class, 'bank_service_id');
    }

}
