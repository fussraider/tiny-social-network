<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'entity', 'entity_id', 'from_user_id'
    ];

    public function entity(){
        return $this->belongsTo('App\\' . $this->entity);
    }

    public function owner(){
        return $this->belongsTo(User::class, 'id', 'from_user_id');
    }
}
