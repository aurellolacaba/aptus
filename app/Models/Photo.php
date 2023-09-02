<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $guarded = [];

    protected $appends = ['loading_photo'];

    public function photoable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getLoadingPhotoAttribute(){
        $imageUrl = $this->url;
        $newImageUrl = preg_replace('/(\/photos\/)/', '/20x20/', $imageUrl);

        return url($newImageUrl);
    }
}
