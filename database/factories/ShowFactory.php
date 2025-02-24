<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\Room;
use App\Models\Show;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShowFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Show::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $room = Room::inRandomOrder()->first();
        $movie = Movie::inRandomOrder()->first();
        $startTime = fake()->dateTimeBetween('-3 hours', 'now');
        $endTime = fake()->dateTimeBetween($startTime, '+3 hours');

        return [
            'movie_id' => $movie?->id,  // Tránh lỗi nếu Movie chưa có dữ liệu
            'room_id' => $room?->id,    // Tránh lỗi nếu Room chưa có dữ liệu
            'price' => fake()->randomFloat(0, 50, 500),
            'date' => fake()->dateTimeBetween('-1 days', '+3 week'),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'remaining_seats' => $room?->size ?? 0,  // Tránh lỗi khi không có Room
        ];
    }
}

