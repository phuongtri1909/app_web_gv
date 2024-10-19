<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class AdmissionProcess extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['title', 'content'];
    protected $fillable = [
        'title',
        'content',
    ];

    public function admission_process_detail()
    {
        return $this->hasMany(AdmissionProcessDetail::class);
    }
}
