<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $randomUser = User::all()->random();
        return [
            'user_id' => $randomUser->id,
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'starting_at' => $this->faker->dateTime,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'image_path' => $this->faker->imageUrl,
            'has_ended' => $this->faker->boolean,
        ];
    }
}
