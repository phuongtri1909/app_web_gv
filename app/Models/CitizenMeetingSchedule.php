<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CitizenMeetingSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'stt',
        'code',
        'department_id',
        'fullname',
        'description',
        'phone',
        'card_number',
        'address',
        'working_day',
        'customer_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

}
