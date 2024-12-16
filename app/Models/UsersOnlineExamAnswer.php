<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersOnlineExamAnswer extends Model
{
    use HasFactory;

    protected $table = 'users_online_exam_answer';
    protected $fillable = ['users_online_exam_id', 'question_id', 'status', 'submission_time', 'start_time'];

    public function userExam()
    {
        return $this->belongsTo(UsersOnlineExam::class, 'users_online_exam_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
