<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'create-campaign',
            'edit-campaign',
            'delete-campaign',
            'view-campaigns',
            'join-campaign',
            'manage-volunteers',
            'view-reports',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        // User role
        $userRole = Role::create(['name' => 'مستخدم']);
        $userRole->givePermissionTo([
            'view-campaigns',
            'join-campaign',
        ]);

        // Volunteer team role
        $teamRole = Role::create(['name' => 'فرقة تطوعية']);
        $teamRole->givePermissionTo([
            'create-campaign',
            'edit-campaign',
            'delete-campaign',
            'view-campaigns',
            'join-campaign',
            'manage-volunteers',
        ]);

        // Organization role
        $orgRole = Role::create(['name' => 'منظمة']);
        $orgRole->givePermissionTo([
            'create-campaign',
            'edit-campaign',
            'delete-campaign',
            'view-campaigns',
            'join-campaign',
            'manage-volunteers',
            'view-reports',
        ]);
    }
}
