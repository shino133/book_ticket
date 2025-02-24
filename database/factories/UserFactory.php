<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Mã hóa mật khẩu an toàn hơn
            'remember_token' => Str::random(10),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->optional()->lastName(),
            'wants_manager' => fake()->boolean(),
            'role_id' => fn(array $attributes) =>
                $attributes['wants_manager']
                    ? Role::firstWhere('code', Role::CUSTOMER_CODE)?->id
                    : Role::inRandomOrder()->first()?->id,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
