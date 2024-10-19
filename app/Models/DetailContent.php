<?php

namespace App\Models;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailContent extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'title',
        'content',
        'tag',
    ];

    protected $table = 'detail_content';

    protected $fillable = [
        'program_id',
        'title',
        'content',
        'img_detail',
        'tag',
        'key_components',
    ];

    // Thiết lập quan hệ với model ProgramOverview
    public function programOverview()
    {
        return $this->belongsTo(ProgramOverview::class, 'program_id');
    }
}
