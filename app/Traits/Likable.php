<?php

namespace App\Traits;

use App\Models\User;
use App\Notifications\PostLiked;

trait Likable {

    public function likes()
    {
        return $this->morphToMany(User::class, 'likable');
    }

    public function toggleLike($user = null)
    {   
        $user = $user ?: auth()->user();

        if ($this->is_liked) {
            $this->likes()->detach($user);
        } else {
            $this->likes()->attach($user);
        }
    }

    public function getIsLikedAttribute() 
    {
        // return $this->likes()->where('user_id', auth()->id())->exists();

        return $this->likes->contains('id', auth()->id());
    }

}