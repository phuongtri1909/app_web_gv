<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; 
class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_title',
        'slug',
        'ad_description',
        'ad_price',
        'ad_full_name',
        'ad_contact_phone',
        'ad_cccd',
        'category_id',
        'type_id',
        'road_id',
        'ad_start_date',
        'ad_end_date',
        'ad_status',
    ];

    public function category()
    {
        return $this->belongsTo(AdCategory::class);
    }

    public function type()
    {
        return $this->belongsTo(AdType::class);
    }

    public function road()
    {
        return $this->belongsTo(Road::class);
    }

    public function files()
    {
        return $this->hasMany(AdFile::class);
    }
    public function setTitleAttribute($value)
    {
        $this->attributes['ad_title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
