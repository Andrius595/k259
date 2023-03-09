<?php

namespace Database\Seeders;

use App\Models\Litter;
use App\Models\TrashType;
use Illuminate\Database\Seeder;

class LitterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Litter::factory()
            ->count(50)
            ->create()
            ->each(function (Litter $litter) {
                $trashTypes = TrashType::all()->random(3);
                $litter->trashTypes()->attach($trashTypes);
            });
    }
}
