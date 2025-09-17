<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create sample roles
        $roles = [
            [
                'name' => 'Super Admin',
                'guard_name' => 'web',
                'permissions' => 'all' // Will get all permissions
            ],
            [
                'name' => 'Admin',
                'guard_name' => 'web',
                'permissions' => [
                    'manage-users', 'create-users', 'edit-users', 'view-users',
                    'manage-roles', 'view-roles',
                    'view-permissions',
                    'view-dashboard', 'view-analytics',
                    'manage-settings'
                ]
            ],
            [
                'name' => 'Manager',
                'guard_name' => 'web',
                'permissions' => [
                    'view-users', 'edit-users',
                    'view-roles',
                    'view-permissions',
                    'view-dashboard', 'view-analytics'
                ]
            ],
            [
                'name' => 'User',
                'guard_name' => 'web',
                'permissions' => [
                    'view-dashboard'
                ]
            ],
        ];

        foreach ($roles as $roleData) {
            $role = Role::create([
                'name' => $roleData['name'],
                'guard_name' => $roleData['guard_name']
            ]);

            // Assign permissions to role
            if ($roleData['permissions'] === 'all') {
                // Give all permissions to Super Admin
                $role->givePermissionTo(Permission::all());
            } elseif (is_array($roleData['permissions'])) {
                // Give specific permissions to role
                foreach ($roleData['permissions'] as $permissionName) {
                    $permission = Permission::where('name', $permissionName)->first();
                    if ($permission) {
                        $role->givePermissionTo($permission);
                    }
                }
            }
        }

        $this->command->info('Sample roles with permissions created successfully!');
    }
}