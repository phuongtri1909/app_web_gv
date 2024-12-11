<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'advertisement_id',
        'file_url',
        'type',
        'is_primary',
    ];

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }
}
