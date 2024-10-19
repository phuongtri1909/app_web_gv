<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CategoryQuestion extends Model
{
    use HasFactory,HasTranslations;

    public $translatable = [
        'name',
    ];

    protected $table = 'categories_questions';
    protected $fillable = ['name'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
