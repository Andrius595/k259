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
            'Plastic',
            'Glass',
            'Paper',
            'Metal',
            'Wood',
            'Food',
            'Textile',
            'Automotive',
            'Construction',
            'Electronics',
            'Construction',
            'Dangerous',
            'Household',
            'Liquid',
            'Animal carcass',
            'Other',
        ];

        foreach ($trashTypes as $trashType) {
            TrashType::create([
                'title' => $trashType,
            ]);
        }
    }
}
