<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;

    protected $table = 'competition';

    protected $fillable = ['title', 'start_date', 'end_date', 'status', 'time_limit', 'banner','type'];

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'competition_id');
    }
}
