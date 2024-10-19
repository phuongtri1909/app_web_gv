<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Tuition extends Model
{
    use HasFactory,HasTranslations;
    public $translatable = ['title'];

    protected $fillable = [
        'numerical_order',
        'title',
    ];

    public function content_tuition()
    {
        return $this->hasMany(ContentTuition::class);
    }


}
