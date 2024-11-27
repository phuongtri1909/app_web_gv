<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBusiness extends Model
{
    use HasFactory;
    protected $fillable = [
        'business_member_id',
        'category_product_id',
        'name_product',
        'slug',
        'description',
        'price',
        'price_member',
        'product_avatar',
        'related_confirmation_document'
    ];

    public function businessMember()
    {
        return $this->belongsTo(BusinessMember::class, 'business_member_id');
    }

    public function categoryProduct()
    {
        return $this->belongsTo(CategoryProductBusiness::class, 'category_product_id');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
}
