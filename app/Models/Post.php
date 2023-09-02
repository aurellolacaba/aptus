<?php

namespace App\Models;

use App\Notifications\PostLiked;
use App\Traits\Likable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes, HasUuids, Likable;
    // selectRaw
    // setRelation 
    // guest0738810j

    protected $guarded = [];

    protected $appends = ['is_liked', 'diff_for_humans'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'photoable');
    }

    public function scopeUserNewsFeed($query, $user = null){
        $user = $user ?: auth()->user();

        $followingIds= $user->followings()->pluck('id');
        $followingIds[] = $user->id;

        return $query->whereIn('user_id', $followingIds);
    }

    public function getPostUrlAttribute()
    {
        return url("/posts/{$this->id}");
    }

    public function getDiffForHumansAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
