<?php

namespace Database\Factories;

use App\Models\Prize;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PrizeCode>
 */
class PrizeCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $prize = Prize::inRandomOrder()->first();
        return [
            'prize_id' => $prize->id,
            'code' => $this->faker->regexify('[A-Z]{5}[0-4]{3}'),
            'is_redeemed' => $this->faker->boolean,
        ];
    }
}
