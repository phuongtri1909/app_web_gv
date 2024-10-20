<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;  // Add this import

class News extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'title',
        'content',
    ];

    protected $fillable = ['user_id', 'title', 'content', 'image', 'published_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(CategoryNews::class, 'news_category', 'news_id', 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(TagNews::class, 'news_tag', 'news_id', 'tag_id');
    }


    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
