<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsDigitalTransformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'news_id',
        'digital_transformation_id'
    ];

    public function news()
    {
        return $this->belongsTo(News::class);
    }

    public function digitalTransformation()
    {
        return $this->belongsTo(DigitalTransformation::class);
    }
}
