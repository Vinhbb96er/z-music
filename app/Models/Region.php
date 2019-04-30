<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = [
        'name',
        'cover_image'
    ];

    protected $appends = [
        'category_type'
    ];

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function getCategoryTypeAttribute()
    {
        return config('setting.category_type.region');
    }
}
