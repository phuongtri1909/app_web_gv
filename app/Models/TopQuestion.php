<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'questioned_by',
        'answered_by',
        'linkUrl',
        'attachment'
    ];
}
