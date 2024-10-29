<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class FinancialSupport extends Model
{
    use HasFactory;
    protected $table = 'financial_support';


    protected $fillable = ['name', 'slug','avt_financial_support','url_financial_support','bank_id'];


    // public function customerInterests()
    // {
    //     return $this->hasMany(CustomerInterest::class);
    // }
    public function businessCapitalNeed(){
        return $this->hasMany(BusinessCapitalNeed::class);
    }
    public function tabContentDetails()
    {
        return $this->hasMany(NewsTabContentDetailPost::class, 'financial_support_id');
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

}

