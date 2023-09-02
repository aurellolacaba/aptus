<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\Followable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasUuids, Followable;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = ['full_name', 'profile_url', 'avatar'];

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            $model->load([ 'posts', 'comments', ]);

            $model->posts()->each(function($post) {
                $post->delete();
            });
            $model->comments()->each(function($comment) {
                $comment->delete();
            });
        });
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likedPosts()
    {
        return $this->morphedByMany(Post::class, 'likable');
    }

    public function profilePic()
    {
        return $this->hasOne(ProfilePicture::class);
    }

    public function profilePics()
    {
        return $this->hasMany(ProfilePicture::class);
    }

    public function getAvatarAttribute()
    {
        // if ($this->profilePic->photo) {
        //     $imageUrl = $this->profilePic->photo->url;
        //     $smallImageUrl = preg_replace('/(\/photos\/)/', '/120x120/', $imageUrl);

        //     return url($smallImageUrl);
        // }
        return "https://eu.ui-avatars.com/api/?name={$this->first_name}+{$this->last_name}&size=120";
    }

    public function getFullNameAttribute(){
        return "{$this->first_name} {$this->last_name}";
    }

    public function getProfileUrlAttribute(){
        return route('users.show', ['user' => $this->id]);
    }
}
