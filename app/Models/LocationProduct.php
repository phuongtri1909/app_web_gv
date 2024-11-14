<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationProduct extends Model
{
    use HasFactory;

    protected $table = 'location_products';

    protected $fillable = [
        'location_id',
        'file_path',
        'media_type',
    ];

    public function location()
    {
        return $this->belongsTo(Locations::class, 'location_id');
    }
}
