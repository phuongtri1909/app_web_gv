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
    public function usersOnlineExams()
    {
        return $this->hasManyThrough(
            UsersOnlineExam::class, 
            UsersOnlineExamAnswer::class,
            'question_id',      
            'quiz_id',         
            'id',               
            'users_online_exam_id' 
        );
    }
}
