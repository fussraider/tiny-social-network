<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Prophecy\Exception\Doubler\ClassNotFoundException;
use Illuminate\Support\Facades\Storage;

abstract class Entity extends Model
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(Like::class, 'entity_id', 'id')->where('entity', '=', $this->getEntityName());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return string
     */
    protected function getEntityName(): string
    {
        return basename(str_replace('\\', '/', static::class));
    }

    /**
     * @param string $entity
     * @return string
     */
    public static function getChild(string $entity): string
    {
        $class = 'App\\' . ucfirst(strtolower($entity));
        if (in_array(strtolower($entity), ['article', 'image'])) {
            return $class;
        } else
            throw new ClassNotFoundException('The class ' . $class . ' is not found or is not extension of the ' . __CLASS__, $class);
    }
}
