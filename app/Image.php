<?php

namespace App;

use Illuminate\Support\Facades\Storage;

class Image extends Entity
{
    protected $fillable = [
        'user_id', 'description', 'image'
    ];

    public static function boot()
    {
        parent::boot();
        self::deleting(function($image){
            $image->likes()->each(function($like){
                $like->delete();
            });

            if(Storage::exists('public/images/' . $image->image)){
                Storage::delete('public/images/' . $image->image);
            }
        });
    }
}
