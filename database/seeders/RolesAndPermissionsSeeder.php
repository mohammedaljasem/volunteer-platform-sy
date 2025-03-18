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
            // صلاحيات الحملات
            'create-campaign',
            'edit-campaign',
            'delete-campaign',
            'view-campaigns',
            'join-campaign',
            'manage-volunteers',
            
            // صلاحيات عامة
            'view-reports',
            'donate-to-campaign',
            'comment-on-campaign',
            'create-job-offer',
            'request-participation',
            
            // صلاحيات الأدمن الخاصة
            'manage-all',
            'delete-any-campaign',     // حذف أي حملة بغض النظر عن المالك
            'edit-any-campaign',       // تعديل أي حملة بغض النظر عن المالك
            'delete-any-user',         // حذف أي مستخدم
            'edit-any-user',           // تعديل بيانات أي مستخدم
            'manage-organizations',    // إدارة المنظمات (إضافة، تعديل، حذف)
            'manage-teams',            // إدارة فرق التطوع
            'manage-donations',        // إدارة التبرعات
            'manage-local-ads',        // إدارة الإعلانات المحلية
            'verify-organizations',    // التحقق من المنظمات
            'access-admin-panel',      // الوصول إلى لوحة الأدمن
        ];

        foreach ($permissions as $permission) {
            // التحقق من وجود الصلاحية
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
            'request-participation',
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
            'create-job-offer',
        ]);
        
        // Admin role - له كل الصلاحيات
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        
        // إعطاء الأدمن جميع الصلاحيات الموجودة في النظام
        $adminRole->givePermissionTo(Permission::all());
    }
}
