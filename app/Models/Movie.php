<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Movie extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'title',
        'image',
        'storyline',
        'rating',
        'language',
        'release_date',
        'director',
        'maturity_rating',
        'running_time',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'release_date' => 'date',
        'running_time' => 'string', // Sử dụng số nguyên thay vì 'datetime'
    ];

    /**
     * Define the relationship with the Category model.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Define the relationship with the Show model.
     */
    public function shows()
    {
        return $this->hasMany(Show::class);
    }

    /**
     * Boot method to handle cascading delete.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($movie) {
            $movie->shows()->delete();
        });
    }


    protected function runningTime(): Attribute
    {
        return Attribute::get(fn ($value) => Carbon::createFromFormat('H:i:s', $value)->format('G \h i\m\i\n'));
    }
}
