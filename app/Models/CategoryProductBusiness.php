<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProductBusiness extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug'   
    ];

    public function product_businesses()
    {
        return $this->hasMany(ProductBusiness::class);
    }

}
