<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Storage;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'name',
        'avatar',
        'background',
        'birthday',
        'gender',
        'description',
        'role_id',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // user following
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'follow_id');
    }

    // my follower
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'follow_id', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    // reporting
    public function reportings()
    {
        return $this->hasMany(Report::class);
    }

    // be reported
    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function ranking()
    {
        return $this->morphTo(Ranking::class, 'rankingable');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getAvatarAttribute($value)
    {
        // if (checkExistsRemoteImage($this->attributes['avatar'])) {
        //     return $this->attributes['avatar'];
        // }

        if (!Storage::disk('local')->exists($this->attributes['avatar']) || empty($this->attributes['avatar'])) {
            return config('setting.images.user_avatar_default');
        }

        return Storage::url($this->attributes['avatar']);
    }
}
