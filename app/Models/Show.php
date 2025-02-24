<?php

namespace App\Models;

class Show extends Model
{
    /**
     * Define default attributes.
     */
    protected function defaults(): array
    {
        return [
            'remaining_seats' => 0,
        ];
    }

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Define relationships.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function reservationsSeats()
    {
        return $this->reservations->pluck('seat_number');
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * Handle cascading deletion of related models.
     */
    protected static function booted()
    {
        static::deleting(function ($resource) {
            $resource->reservations()->delete();
        });
    }
}
