<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdmissionProcessDetail extends Model
{
    use HasFactory, HasTranslations;
    
    public $translatable = ['title', 'content'];

    protected $fillable = [
        'title',
        'content',
        'admission_process_id',
    ];

    public function admission_process()
    {
        return $this->belongsTo(AdmissionProcess::class);
    }
}
