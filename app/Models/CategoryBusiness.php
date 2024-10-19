<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryBusiness  extends Model
{
    use HasFactory;

    protected $table = 'category_business';

    protected $fillable = [
        'name'
    ];
    public function businesses()
    {
        return $this->hasMany(Business::class, 'category_business_id');
    }


}
