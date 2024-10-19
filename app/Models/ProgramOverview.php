<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProgramOverview extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'title_program',
        'short_description',
        'long_description',
    ];

    protected $table = 'program_overview';

    protected $fillable = [
        'category_id',
        'title_program',
        'short_description',
        'long_description',
        'img_program',
    ];

    // Thiết lập quan hệ với model CategoryProgram
    public function category()
    {
        return $this->belongsTo(CategoryProgram::class, 'category_id');
    }
}
