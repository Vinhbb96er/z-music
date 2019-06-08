<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeekyView extends Model
{
     protected $fillable = [
        'weeky_viewable_id',
        'weeky_viewable_type',
        'views',
        'date',
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }
}
