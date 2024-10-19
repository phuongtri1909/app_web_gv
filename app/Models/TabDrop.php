<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TabDrop extends Model
{
    use HasFactory,HasTranslations;

    public $translatable = [
        'title',
        'content',
    ];

    protected $table = 'tabs_drop';
    protected $fillable = [
        'title',
        'tab_id',
        'image',
        'content',
        'icon',
        'bg_color',
    ];

    public function tab()
    {
        return $this->belongsTo(Tab::class, 'tab_id');
    }
}
