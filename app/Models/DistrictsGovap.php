<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistrictsGovap extends Model
{
    use HasFactory;
    protected $table = 'districts_govap';

    protected $fillable = [
        'ward_detail_id',
        'name',
        'area',
        'total_households',
        'population',
        'secretary_name',
        'head_name',
    ];
    public function wardDetail()
    {
        return $this->belongsTo(WardDetail::class, 'ward_detail_id');
    }

    public function blocks()
    {
        return $this->hasMany(BlocksGovap::class, 'districts_govap_id');
    }

    public function locations()
    {
        return $this->hasMany(Locations::class, 'districts_govap_id');
    }
}
