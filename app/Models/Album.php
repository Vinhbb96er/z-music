<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Album extends Model
{
    protected $fillable = [
        'user_id',
        'region_id',
        'name',
        'cover_image',
        'status',
        'views',
        'type',
        'path_image'
    ];

    protected $appends = [
        'created_at_date',
        'kinds_text'
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

    public function getCreatedAtDateAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format(trans('F Y'));
    }

    public function getKindsTextAttribute()
    {
        return implode(', ', $this->kinds->pluck('name')->all());
    }

    public function getNameAttribute()
    {
        $name = ucwords($this->attributes['name']);

        if ($this->type == config('setting.album.type.single')) {
            $name .= ' (Single)';
        }

        return $name;
    }
}
