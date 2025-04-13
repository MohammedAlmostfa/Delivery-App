<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    protected $fillable = [
        "image_name",
        "mime_type",
        "image_path",
    ];
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
