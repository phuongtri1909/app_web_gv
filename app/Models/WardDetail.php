<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WardDetail extends Model
{
    use HasFactory;

    protected $table = 'ward_detail';

    protected $fillable = [
        'ward_govap_id',
        'area',
        'total_households',
    ];
    public function wardGovap()
    {
        return $this->belongsTo(WardGovap::class, 'ward_govap_id');
    }

    public function districts()
    {
        return $this->hasMany(DistrictsGovap::class, 'ward_detail_id');
    }
}
