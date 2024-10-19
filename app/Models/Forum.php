<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Forum extends Model
{
    use HasFactory,HasTranslations;
    public $translatable = [
        'title'
    ];
    protected $table = 'forum';

    protected $fillable = ['image', 'key_page', 'active', 'title'];
}

