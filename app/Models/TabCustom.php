<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TabCustom extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'title',
        'description',
        'content',

    ];

    protected $table = 'tabs_custom';
    protected $fillable = [
        'tab_id',
        'title',
        'description',
        'content',
    ];

    public function tab()
    {
        return $this->belongsTo(Tab::class, 'tab_id');
    }
}
