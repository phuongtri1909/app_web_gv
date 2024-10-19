<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TabProjectImage extends Model
{
    use HasFactory;


    protected $table = 'tabs_projects_images';
    
    protected $fillable = [
        'tab_project_id',
        'image',
    ];


    public function project()
    {
        return $this->belongsTo(TabProject::class, 'tab_project_id');
    }
}
