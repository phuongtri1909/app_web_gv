<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TagNews extends Model
{
    use HasFactory,HasTranslations;

    public $translatable = [
        'name',
    ];
    protected $table = 'tags';
    protected $fillable = ['name'];

    public function news()
    {
        return $this->belongsToMany(News::class, 'news_tag', 'tag_id', 'news_id');
    }

}
