<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;
use Spatie\Translatable\HasTranslations;

class Language extends Model
{
    use HasFactory,HasTranslations;

    public $translatable = ['name'];
    protected $fillable = ['name','locale','flag'];
}
