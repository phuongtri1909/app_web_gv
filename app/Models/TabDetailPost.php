<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TabDetailPost extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'name',

    ];

    protected $table = 'tabs_detail_posts';

    protected $fillable = ['name'];

    // Quan hệ với bảng news_tab_content_detail_posts
    public function newsTabContentDetails()
    {
        return $this->hasMany(NewsTabContentDetailPost::class, 'tab_id');
    }
}
