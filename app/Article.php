<?php

namespace App;

class Article extends Entity
{
    protected $fillable = [
        'user_id', 'title', 'body'
    ];

    public static function boot()
    {
        parent::boot();
        self::deleting(function($image){
            $image->likes()->each(function($like){
                $like->delete();
            });
        });
    }
}
