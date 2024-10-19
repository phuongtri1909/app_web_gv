<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Branch extends Model
{
    use HasFactory,HasTranslations;

    public $translatable = ['name','address','title','description'];

    protected $fillable = ['name','adress','location', 'image','phone','title','description'];

    public function personnel()
    {
        return $this->hasMany(Staff::class);
    }
}
