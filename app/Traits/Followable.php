<?php

namespace App\Traits;

use App\Models\User;

trait Followable {
    
    public function followings()
    {
        return $this->morphedByMany(User::class, 'followable');
    }

    public function followers()
    {
        return $this->morphToMany(User::class, 'followable');
    }

    public function follow($user = null)
    {
        $user = $user ?: auth()->user();

        return $this->followers()->attach($user);
    }

    public function unFollow($user = null)
    {
        $user = $user ?: auth()->user();

        return $this->followers()->detach($user);
    }
}