<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = [
        'name', 
    ];

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }
}
