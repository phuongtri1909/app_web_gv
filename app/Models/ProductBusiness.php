<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBusiness extends Model
{
    use HasFactory;
    protected $fillable = [
        'business_id',
        'category_product_id',
        'name_product',
        'slug',
        'description',
        'price',
        'product_story',
        'product_avatar',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function categoryProduct()
    {
        return $this->belongsTo(CategoryProductBusiness::class, 'category_product_id');
    }
}
