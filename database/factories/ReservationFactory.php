<?php

namespace Database\Factories;

use App\Models\Show;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \App\Models\Reservation::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        // Lấy suất chiếu còn chỗ ngẫu nhiên
        $show = Show::where('remaining_seats', '>', 1)->inRandomOrder()->first();
        $user = User::inRandomOrder()->first();

        if (!$show || !$user) {
            return []; // Tránh lỗi nếu không có dữ liệu
        }

        // Giảm số ghế còn lại trong suất chiếu
        $seatNumber = fake()->numberBetween(0, $show->room->size - 1);
        $show->decrement('remaining_seats');

        return [
            'show_id' => $show->id,
            'user_id' => $user->id,
            'seat_number' => $seatNumber,
        ];
    }
}

