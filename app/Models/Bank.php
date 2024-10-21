<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Bank extends Model
{
    use HasFactory;

    protected $table = 'banks';
    protected $fillable = ['name', 'slug','avt_bank'];

    public function bankServices()
    {
        return $this->hasMany(BankServicesInterest::class);
    }

    public function financialSupports()
    {
        return $this->hasMany(FinancialSupport::class);
    }
    public function setTitleAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
