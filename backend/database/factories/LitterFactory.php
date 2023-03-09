<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Litter>
 */
class LitterFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $randomUser = User::all()->random();
        return [
            'user_id' => $randomUser->id,
            'size' => $this->faker->numberBetween(1, 3),
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'image_path' => $this->faker->imageUrl(),
            'description' => $this->faker->text,
            'is_accessible_by_car' => $this->faker->boolean,
            'is_located_in_hole' => $this->faker->boolean,
            'is_under_water' => $this->faker->boolean,
            'is_on_the_waterside' => $this->faker->boolean,
            'is_hard_to_reach' => $this->faker->boolean,
            'is_cleaned' => $this->faker->boolean,
        ];
    }
}
