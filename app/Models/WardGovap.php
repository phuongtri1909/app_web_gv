<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WardGovap extends Model
{
    use HasFactory;

    protected $table = 'ward_govap';

    protected $fillable = [
        'name',
        'slug',
    ];

    public function businesses()
    {
        return $this->hasMany(Business::class, 'ward_id');
    }
    public function wardDetail()
    {
        return $this->hasOne(WardDetail::class, 'ward_govap_id');
    }
}
