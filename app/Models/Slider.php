<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Slider extends Model
{
    use HasFactory,HasTranslations;
    public $translatable = [
        'slider_title',
        'title',
        'subtitle',
        'description',
    ];
    protected $fillable = [
        'slider_title',
        'title',
        'subtitle',
        'description',
        'image_slider',
        'learn_more_url',
        'active',
        'key_page',
    ];
}

