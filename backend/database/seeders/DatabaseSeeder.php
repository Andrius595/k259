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
        $users = User::factory(10)->create();

        $this->call([
            PermissionsSeeder::class,
            TrashTypeSeeder::class,
            LitterSeeder::class,
            EventSeeder::class,
            CompanySeeder::class,
            PrizeSeeder::class,
            PrizeCodeSeeder::class,
        ]);

        $userRole = Role::firstOrCreate(['name' => PermissionsConfig::USER]);

        foreach ($users as $user) {
            $user->assignRole($userRole);
        }

        $admin = User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@admin.com',
            ]);

        $admin->assignRole(PermissionsConfig::ADMIN);
    }
}
