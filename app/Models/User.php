<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory;

    /**
     * Define default attributes.
     */
    protected function defaults(): array
    {
        return [
            'role_id' => null,
            'wants_manager' => false,
        ];
    }

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Mutator for hashing passwords.
     */
    public function setPasswordAttribute($password): void
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Define relationships.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Computed property to check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role?->code === Role::ADMIN_CODE;
    }
}
