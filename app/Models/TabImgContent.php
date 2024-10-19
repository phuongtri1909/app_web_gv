<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TabImgContent extends Model
{
    use HasFactory,HasTranslations;

    public $translatable = [
        'title',
        'content',
    ];
    protected $table = 'tabs_img_contents';
    protected $fillable = [
        'tab_id',
        'title',
        'content',
        'image',
        'section_type'
    ];


    public function tab()
    {
        return $this->belongsTo(Tab::class, 'tab_id');
    }
    public function mediaItems()
    {
        return $this->hasMany(MediaItem::class, 'tabs_img_content_id');
    }
}
