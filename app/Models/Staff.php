<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory,HasTranslations;

    public $translatable = ['position', 'description'];

    protected $fillable = ['full_name', 'position', 'description', 'image','branch_id'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}

