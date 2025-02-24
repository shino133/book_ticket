<?php

namespace App\Models;

class Room extends Model
{
    /**
     * Define relationships.
     */
    public function shows()
    {
        return $this->hasMany(Show::class);
    }
}
