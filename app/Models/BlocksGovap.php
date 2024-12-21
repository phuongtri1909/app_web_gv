<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlocksGovap extends Model
{
    use HasFactory;

    protected $table = 'blocks_govap';

    protected $fillable = [
        'districts_govap_id',
        'name',
        'total_households',
    ];

    public function district()
    {
        return $this->belongsTo(DistrictsGovap::class, 'districts_govap_id');
    }
}
