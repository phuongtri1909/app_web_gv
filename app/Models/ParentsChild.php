<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;
class ParentsChild extends Model
{
    use HasFactory,HasTranslations;

    public $translatable = [
        'title',
        'description',
        'duration'
    ];

    protected $table = 'parents_child';
    protected $fillable = [
        'title', 'description', 'image', 'link' ,'component_type','slug','tab_id','duration'
    ];
    public function tab()
    {
        return $this->belongsTo(Tab::class, 'tab_id');
    }
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
    public function details() 
    {
        return $this->hasMany(ParentsChildDetail::class, 'parents_child_id');
    }
}
