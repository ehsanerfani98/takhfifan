<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $fillable = [
        'filename', 'original_name', 'mime', 'size', 'user_id'
    ];

    public function getUrlAttribute()
    {
        return asset('media-upload/' . $this->filename);
        // return env('APP_URL') . asset('media-upload/' . $this->filename);
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->url;
    }

}
