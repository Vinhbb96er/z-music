<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'album_id',
        'region_id',
        'user_id',
        'url',
        'name',
        'type',
        'lyrics',
        'artist_name',
        'cover_image',
        'views',
        'status',
    ];

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
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

    public function album()
    {
        return $this->belongsTo(Album::class);
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

    public function getNameAttribute()
    {
        return ucwords($this->attributes['name']);
    }
}
