<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'tabs_img_content_id',
        'type',
        'file_path',
    ];

    public function tabImgContent()
    {
        return $this->belongsTo(TabImgContent::class, 'tabs_img_content_id');
    }
}
