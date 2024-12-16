<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackImages extends Model
{
    use HasFactory;

    protected $fillable = [
        'feedback_id',
        'imageUrl',
    ];

    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }

}
