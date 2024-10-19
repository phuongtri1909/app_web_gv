<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Answer extends Model
{
    use HasFactory;
    protected $fillable = ['question_id','question_id', 'title', 'content', 'image'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    protected static function booted()
    {
        static::created(function ($answer) {
            try {
                if ($answer->question) {
                    $answer->question->increment('count_answer');
                }
            } catch (\Exception $e) {
                return response()->json(['error' => true, 'message' => __('reply_error')]);
            }
        });

        static::deleted(function ($answer) {
            try {
                if ($answer->question && $answer->question->count_answer > 0) {
                    $answer->question->decrement('count_answer');
                }
            } catch (\Exception $e) {
                return response()->json(['error' => true, 'message' => __('reply_error')]);
            }
        });
    }
    public function category()
    {
        return $this->belongsTo(CategoryQuestion::class);
    }
}


