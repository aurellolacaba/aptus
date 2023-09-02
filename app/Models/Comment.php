<?php

namespace App\Models;

use App\Traits\Likable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes, HasUuids, Likable;

    protected $fillable = ['user_id', 'body'];

    protected $touches = ['commentable'];

    protected $appends = ['is_liked', 'diff_for_humans'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function replies()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getDiffForHumansAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
