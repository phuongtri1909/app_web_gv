<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Competition extends Model
{
    use HasFactory;

    protected $table = 'competition';

    protected $fillable = ['title', 'start_date', 'end_date', 'status', 'time_limit', 'banner','type'];

    protected $appends = ['calculated_status', 'calculated_status_key'];

    public function getCalculatedStatusAttribute()
    {
        $now = Carbon::now();

        if ($now->lessThan($this->start_date)) {
            return 'Sắp diễn ra';
        } elseif ($now->between($this->start_date, $this->end_date)) {
            return 'Đang diễn ra';
        } elseif ($now->greaterThan($this->end_date)) {
            return 'Đã kết thúc';
        }
        return 'Không xác định';
    }

    public function getCalculatedStatusKeyAttribute()
    {
        $now = Carbon::now();

        if ($now->lessThan($this->start_date)) {
            return 'upcoming';
        } elseif ($now->between($this->start_date, $this->end_date)) {
            return 'ongoing';
        } elseif ($now->greaterThan($this->end_date)) {
            return 'completed';
        }
        return 'unknown';
    }
    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'competition_id');
    }
}
