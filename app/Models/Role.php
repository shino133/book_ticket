<?php

namespace App\Models;

class Role extends Model
{
    /**
     * Role codes.
     */
    public const ADMIN_CODE = 1;
    public const MANAGER_CODE = 2;
    public const CUSTOMER_CODE = 3;

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
