<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create sample permissions
        $permissions = [
            // User Management
            'manage-users',
            'create-users',
            'edit-users',
            'delete-users',
            'view-users',
            
            // Role Management
            'manage-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',
            'view-roles',
            
            // Permission Management
            'manage-permissions',
            'create-permissions',
            'edit-permissions',
            'delete-permissions',
            'view-permissions',
            
            // Dashboard
            'view-dashboard',
            'view-analytics',
            
            // System Settings
            'manage-settings',
            'view-logs',
            'backup-system',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        $this->command->info('Sample permissions created successfully!');
    }
}