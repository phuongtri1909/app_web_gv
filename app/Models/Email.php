<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;
    protected $table = 'emails';
    protected $fillable = ['type', 'key_name', 'bank_name', 'email', 'template_id'];

    public function template()
    {
        return $this->belongsTo(EmailTemplate::class, 'template_id');
    }
}
