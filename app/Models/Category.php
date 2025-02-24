<?php

namespace App\Models;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['title'];

    /**
     * Predefined categories.
     *
     * @var array<string>
     */
    public const CATEGORIES = ['Action', 'Drama', 'Comedy', 'Romance', 'Horror'];
}
