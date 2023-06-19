<?php

namespace Database\Seeders;

use App\Config\PermissionsConfig;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionsSeeder::class,
            TrashTypeSeeder::class,
        ]);

        $admin = User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@admin.com',
            ]);

        $admin->assignRole(PermissionsConfig::ADMIN);
    }
}
