<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customerName',
        'phone',
        'imageUrl',
    ];

    public function answers()
    {
        return $this->hasMany(Customer::class, 'customer_id');
    }

    public function usersOnlineExamAnswers()
    {
        return $this->hasMany(UsersOnlineExamAnswer::class, 'customer_id');
    }
}
