<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CategoryProgram extends Model
{
    use HasFactory,HasTranslations;
    public $translatable = [
        'name_category',
        'desc_category',
    ];

    protected $table = 'categories_program';

    protected $fillable = [
        'key_page',
        'name_category',
        'desc_category',
    ];

    // Thiết lập quan hệ với model ProgramOverview nếu có
    public function programs()
    {
        return $this->hasMany(ProgramOverview::class, 'category_id');
    }
}
