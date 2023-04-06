<?php

namespace Database\Seeders;

use App\Models\PrizeCode;
use Illuminate\Database\Seeder;

class PrizeCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PrizeCode::factory(50)->create();
    }
}
