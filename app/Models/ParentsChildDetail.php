<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentsChildDetail extends Model
{
    use HasFactory;
    protected $table = 'parents_child_detail';
    protected $fillable = [
        'parents_child_id',
        'image',
    ];
    public function parentsChild()
    {
        return $this->belongsTo(ParentsChild::class, 'parents_child_id');
    }
}
