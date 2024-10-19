<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['category_id','name', 'phone', 'email', 'content', 'view', 'count_answer', 'follow'];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    public function category()
    {
        return $this->belongsTo(CategoryQuestion::class);
    }
}
