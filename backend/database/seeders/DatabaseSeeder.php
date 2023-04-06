<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        $this->call([
            TrashTypeSeeder::class,
            LitterSeeder::class,
            EventSeeder::class,
            CompanySeeder::class,
            PrizeSeeder::class,
            PrizeCodeSeeder::class,
        ]);
    }
}
