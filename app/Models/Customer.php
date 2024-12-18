<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customerName',
        'phone',
        'imageUrl',
    ];

    public function answers()
    {
        return $this->hasMany(Customer::class, 'customer_id');
    }

    public function hasUserTakenQuiz($quizId)
    {
        return DB::table('users_online_exam_answer')
            ->join('questions', 'users_online_exam_answer.question_id', '=', 'questions.id')
            ->where('questions.quiz_id', $quizId)
            ->where('users_online_exam_answer.customer_id', $this->id)
            ->exists();
    }
}
