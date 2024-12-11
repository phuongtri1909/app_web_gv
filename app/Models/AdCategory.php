<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; 
class AdCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
    ];

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }
    public function setTitleAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
