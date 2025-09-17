<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Permission management
            'permission_view',
            'permission_create',
            'permission_edit',
            'permission_delete',
            'permission_assign',

            // Role management
            'role_view',
            'role_create',
            'role_edit',
            'role_delete',
            'role_assign_permissions',

            // User management
            'user_view',
            'user_create',
            'user_edit',
            'user_delete',
            'user_manage_roles',

            // Activity management
            'activity_view',
            'activity_manage',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
