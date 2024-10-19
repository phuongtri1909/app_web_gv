<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class TabProject extends Model
{
    use HasFactory,HasTranslations;

    public $translatable = [
            'project_name',
            'content'
    ];

    protected $table = 'tabs_projects';
    protected $fillable = [
        'tab_id',
        'image',
        'date',
        'project_name',
        'type',
        'content',
        'slug'
    ];

    public function tab()
    {
        return $this->belongsTo(Tab::class, 'tab_id');
    }

    public function images()
    {
        return $this->hasMany(TabProjectImage::class, 'tab_project_id');
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['project_name'] = $value;
        $this->attributes['slug'] = Str::slug($value);

    }
    public function setContentAttribute($value)
    {

        if (is_null($value) || (is_array($value) && count(array_filter($value)) === 0)) {
            $this->attributes['content'] = null;
            return;
        }

        if (is_array($value)) {

            $filteredContent = array_filter($value, function($content) {
                return !empty($content);
            });


            if (empty($filteredContent)) {
                $this->attributes['content'] = null;
            } else {

                $this->attributes['content'] = json_encode($filteredContent);
            }
        } else {
           
            $this->attributes['content'] = null;
        }
    }

}
