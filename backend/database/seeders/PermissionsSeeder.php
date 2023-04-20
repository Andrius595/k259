<?php

namespace Database\Seeders;

use App\Config\PermissionsConfig;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => PermissionsConfig::ADMIN]);
        $companyAdminRole = Role::firstOrCreate(['name' => PermissionsConfig::COMPANY_ADMIN]);
        $userRole = Role::firstOrCreate(['name' => PermissionsConfig::USER]);

        foreach (PermissionsConfig::ADMIN_PERMISSIONS as $adminPermission) {
            $permission = Permission::firstOrCreate(['name' => $adminPermission]);
            $adminRole->givePermissionTo($permission);
        }

        foreach (PermissionsConfig::COMPANY_ADMIN_PERMISSIONS as $companyAdminPermission) {
            $permission = Permission::firstOrCreate(['name' => $companyAdminPermission]);
            $companyAdminRole->givePermissionTo($permission);
        }

        foreach (PermissionsConfig::USER_PERMISSIONS as $userPermission) {
            $permission = Permission::firstOrCreate(['name' => $userPermission]);
            $userRole->givePermissionTo($permission);
        }
    }
}
