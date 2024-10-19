<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlideProgram extends Model
{
    use HasFactory;

    protected $table = 'slide_program';

    protected $fillable = [
        'program_id',
        'img',
    ];

    // Thiết lập quan hệ với model ProgramOverview
    public function programOverview()
    {
        return $this->belongsTo(ProgramOverview::class, 'program_id');
    }
}
