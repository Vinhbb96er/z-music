<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

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
        'karaoke_lyrics',
        'artist_name',
        'cover_image',
        'views',
        'status',
        'lyrics_contributer_name',
        'path_media',
        'path_image'
    ];

    protected $appends = [
        'kinds_text'
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

    public function weekyViews()
    {
        return $this->morphMany(WeekyView::class, 'weeky_viewable');
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

    public function getKindsTextAttribute()
    {
        return implode(', ', $this->kinds->pluck('name')->all());
    }

    public function getLyricsAttribute()
    {
        return empty($this->attributes['lyrics']) ? trans('admin.empty_lyrics') : $this->attributes['lyrics'];
    }

    public function getKaraokeLyricsAttribute()
    {
        return empty($this->attributes['karaoke_lyrics']) ? '' : json_decode($this->attributes['karaoke_lyrics'], true);
    }

    public function getTypeTextAttribute()
    {
        if ($this->attributes['type'] == 1) {
            return trans('admin.media.type_text.music');
        } else {
            return trans('admin.media.type_text.video');
        }
    }

    public function getCoverImageAttribute()
    {
        if (!Storage::disk('public')->exists($this->attributes['cover_image']) || empty($this->attributes['cover_image'])) {
            return config('setting.images.media_cover_image_default');
        }

        return Storage::url($this->attributes['cover_image']);
    }
}
