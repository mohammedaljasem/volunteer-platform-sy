<?php

// This script will create an admin user

// Import the Composer autoloader
require __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

// Reset cached roles and permissions
app()[PermissionRegistrar::class]->forgetCachedPermissions();

// صلاحيات الأدمن
$adminPermissions = [
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
    'delete-any-campaign',
    'edit-any-campaign',
    'delete-any-user',
    'edit-any-user',
    'manage-organizations',
    'manage-teams',
    'manage-donations',
    'manage-local-ads',
    'verify-organizations',
    'access-admin-panel',
];

// التأكد من وجود الصلاحيات وإنشائها إن لم تكن موجودة
foreach ($adminPermissions as $permName) {
    Permission::firstOrCreate(['name' => $permName]);
}

// Check if admin role exists, if not create it
$adminRole = Role::firstOrCreate(['name' => 'admin']);

// إعطاء دور الأدمن جميع الصلاحيات
$adminRole->syncPermissions(Permission::all());

// Create admin user
$admin = User::firstOrCreate(
    ['email' => 'admin@example.com'],
    [
        'name' => 'مدير النظام',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
        'phone' => '0912345678',
        'notification_preference' => 'email',
    ]
);

// Assign admin role to user
$admin->assignRole('admin');

echo "تم إنشاء حساب الأدمن بنجاح مع كامل الصلاحيات للنظام!\n";
echo "البريد الإلكتروني: admin@example.com\n";
echo "كلمة المرور: password\n";
echo "\nالصلاحيات المعطاة للأدمن:\n";
foreach (Permission::all() as $permission) {
    echo "- " . $permission->name . "\n";
} 