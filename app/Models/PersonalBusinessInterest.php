<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalBusinessInterest extends Model
{
    protected $table = 'personal_business_interest';


    protected $fillable = ['name'];


    public function customerInterests()
    {
        return $this->hasMany(CustomerInterest::class);
    }

}
