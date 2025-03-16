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
            'donate-to-campaign',
            'comment-on-campaign',
        ];

        foreach ($permissions as $permission) {
            // Verificar si el permiso ya existe
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        // Create roles and assign permissions
        // User role
        $userRole = Role::firstOrCreate(['name' => 'مستخدم']);
        $userRole->givePermissionTo([
            'view-campaigns',
            'join-campaign',
            'donate-to-campaign',
            'comment-on-campaign',
        ]);

        // Volunteer team role
        $teamRole = Role::firstOrCreate(['name' => 'فرقة تطوعية']);
        $teamRole->givePermissionTo([
            'create-campaign',
            'edit-campaign',
            'delete-campaign',
            'view-campaigns',
            'join-campaign',
            'manage-volunteers',
        ]);

        // Organization role
        $orgRole = Role::firstOrCreate(['name' => 'منظمة']);
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
