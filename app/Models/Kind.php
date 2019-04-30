<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kind extends Model
{
    protected $fillable = [
        'name',
        'cover_image'
    ];

    protected $appends = [
        'category_type'
    ];

    public function media()
    {
        return $this->morphedByMany(Media::class, 'kindable');
    }

    public function albums()
    {
        return $this->morphedByMany(Album::class, 'kindable');
    }

    public function getCategoryTypeAttribute()
    {
        return config('setting.category_type.kind');
    }
}
