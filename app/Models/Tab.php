<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Tab extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'title',
    ];

    protected $table = 'tabs';
    protected $fillable = [
        'title',
        'slug',
        'key_page',
    ];

    public function imgContents()
    {
        return $this->hasMany(TabImgContent::class, 'tab_id');
    }

    public function drops()
    {
        return $this->hasMany(TabDrop::class, 'tab_id');
    }

    public function projects()
    {
        return $this->hasMany(TabProject::class, 'tab_id');
    }

    public function customs()
    {
        return $this->hasMany(TabCustom::class, 'tab_id');
    }
    public function parentsChildren()
    {
        return $this->hasMany(ParentsChild::class, 'tab_id');
    }
}
