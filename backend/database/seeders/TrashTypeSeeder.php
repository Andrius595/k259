<?php

namespace Database\Seeders;

use App\Models\TrashType;
use Illuminate\Database\Seeder;

class TrashTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trashTypes = [
            'Plastikas',
            'Stiklas',
            'Popierius',
            'Metalas',
            'Mediena',
            'Maisto atliekos',
            'Tekstilė',
            'Statybinės medžiagos',
            'Elektronika',
            'Kita',
        ];

        foreach ($trashTypes as $trashType) {
            TrashType::create([
                'title' => $trashType,
            ]);
        }
    }
}
