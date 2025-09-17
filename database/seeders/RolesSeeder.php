<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin role with all permissions
        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo(Permission::all());

        // Create Manager role with limited permissions
        $managerRole = Role::create(['name' => 'Manager']);
        $managerRole->givePermissionTo([
            'user_view',
            'user_edit',
            'role_view',
            'permission_view',
            'activity_view',
        ]);

        // Create User role with basic permissions
        $userRole = Role::create(['name' => 'User']);
        $userRole->givePermissionTo([
            'user_view',
            'activity_view',
        ]);
    }
}
