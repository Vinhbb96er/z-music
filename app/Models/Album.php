<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = [
        'user_id', 
        'region_id', 
        'name',
        'cover_image',
        'status',
    ];

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function kinds()
    {
        return $this->morphToMany(Kind::class, 'kindable');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ranking()
    {
        return $this->morphTo(Ranking::class, 'rankingable');
    }
}
