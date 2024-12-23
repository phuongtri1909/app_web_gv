<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessField extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug','icon','unit_id'];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
