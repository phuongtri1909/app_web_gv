<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessFeedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'opinion',
        'attached_images',
        'business_member_id',
        'status',
    ];
    public function businessMember()
    {
        return $this->belongsTo(BusinessMember::class, 'business_member_id');
    }
}
