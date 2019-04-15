<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kind extends Model
{
    protected $fillable = [
        'name', 
    ];

    public function media()
    {
        return $this->morphedByMany(Meida::class, 'kindable');
    }

    public function albums()
    {
        return $this->morphedByMany(Album::class, 'kindable');
    }
}
