<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quiz';
    protected $fillable = ['competition_id', 'title', 'status', 'quantity_question'];

    public function competition()
    {
        return $this->belongsTo(Competition::class, 'competition_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'quiz_id');
    }
    public function customer()
    {
        return $this->hasManyThrough(
            Customer::class, 
            UsersOnlineExamAnswer::class,
            'question_id',      
            'quiz_id',         
            'id',               
            'customer_id' 
        );
    }
}
