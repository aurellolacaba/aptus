<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfilePicture extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = [];

    public function photo()
    {
        return $this->morphOne(Photo::class, 'photoable');
    }

    // public function getSmall()
    // {
    //     return $this->photo-
    // }
}
