<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Movie::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->value('id'), // Lấy ngẫu nhiên id của Category
            'title' => fake()->words(3, true), // Dùng `fake()` thay vì `$this->faker`
            'image' => 'posters/' . fake()->uuid() . '.jpg',
            'storyline' => fake()->realTextBetween(200, 400),
            'rating' => fake()->randomFloat(1, 0, 5), // randomFloat cần có số chữ số sau dấu thập phân
            'language' => strtoupper(fake()->languageCode()),
            'release_date' => fake()->date(),
            'director' => fake()->name(),
            'maturity_rating' => fake()->randomElement(['PG-13', 'NC-17', 'R', 'G']),
            'running_time' => fake()->time('H:i:s', '2:30:00'),
        ];
    }
}
