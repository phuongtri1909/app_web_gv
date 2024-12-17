<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CategoryMarket extends Model
{
    use HasFactory;

    protected $table = 'category_market';

    protected $fillable = [
        'name',
        'slug',
        'banner',
    ];

    public function setTitleAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function businessHouseholds()
    {
        return $this->hasMany(BusinessHousehold::class, 'category_market_id');
    }
}
