<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankServicesInterest extends Model
{
    protected $table = 'bank_services_interest';

    protected $fillable = ['name'];

    public function customerInterests()
    {
        return $this->hasMany(CustomerInterest::class);
    }

}
