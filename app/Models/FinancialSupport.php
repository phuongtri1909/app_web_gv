<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class FinancialSupport extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'name',
    ];
    protected $table = 'financial_support';


    protected $fillable = ['name', 'slug','avt_financial_support'];


    public function customerInterests()
    {
        return $this->hasMany(CustomerInterest::class);
    }
    public function tabContentDetails()
    {
        return $this->hasMany(NewsTabContentDetailPost::class, 'financial_support_id');
    }
    public function setTitleAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

}

