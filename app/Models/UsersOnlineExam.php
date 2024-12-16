<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsersOnlineExam extends Model
{
    use HasFactory;

    protected $table = 'users_online_exams';
    protected $fillable = [
        'identity_card_number',
        'full_name',
        'phone_number',
        'date_of_birth',
        'wards_id',
        'street_number'
    ];

    public function answers()
    {
        return $this->hasMany(UsersOnlineExamAnswer::class, 'users_online_exam_id');
    }

    public function ward()
    {
        return $this->belongsTo(WardGovap::class, 'wards_id');
    }

    public function hasUserTakenQuiz($quizId)
    {
        return DB::table('users_online_exam_answer')
            ->join('questions', 'users_online_exam_answer.question_id', '=', 'questions.id')
            ->where('questions.quiz_id', $quizId)
            ->where('users_online_exam_answer.users_online_exam_id', $this->id)
            ->exists();
    }
}
