<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessField extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function businessApplications()
    {
        return $this->belongsToMany(BusinessPromotionalIntroduction::class, 'business_field_business'); 
    }
}
