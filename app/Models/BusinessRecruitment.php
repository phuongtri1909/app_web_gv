<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessRecruitment extends Model
{
    use HasFactory;

    protected $table = 'business_recruitment';
    protected $fillable = [
        'business_name',
        'business_code',
        'category_business_id',
        'head_office_address',
        'phone',
        'fax',
        'email',
        'representative_name',
        'gender',
        'recruitment_info',
        'status'
    ];

    public function categoryBusiness()
    {
        return $this->belongsTo(CategoryBusiness::class, 'category_business_id');
    }
}
