<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;


class AboutUs extends Model
{
    use HasFactory,HasTranslations;
    public $translatable = [
        'title_about',
        'subtitle_about',
        'title_detail',
        'subtitle_detail',
        'description',
    ];
    protected $fillable = [
        'title_about',
        'subtitle_about',
        'title_detail',
        'subtitle_detail',
        'description',
        'image',
        'link_url',
    ];


}
