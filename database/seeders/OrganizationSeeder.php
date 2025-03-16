<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear organizaciones
        $organizations = [
            [
                'name' => 'فريق سوريا التطوعي',
                'description' => 'فريق تطوعي يهدف لمساعدة المحتاجين في سوريا',
                'verified' => true,
                'contact_email' => 'info@syria-volunteers.org',
            ],
            [
                'name' => 'مؤسسة الأمل للعمل الإنساني',
                'description' => 'مؤسسة إنسانية تعمل في مجال الإغاثة والتنمية في سوريا',
                'verified' => true,
                'contact_email' => 'contact@hope-foundation.org',
            ],
            [
                'name' => 'جمعية العطاء الخيرية',
                'description' => 'جمعية خيرية تهتم بتقديم المساعدات للفقراء والمحتاجين',
                'verified' => true,
                'contact_email' => 'info@ataa-charity.org',
            ],
        ];

        foreach ($organizations as $org) {
            Organization::create($org);
        }

        // Crear usuarios administradores para cada organización
        $orgAdmins = [
            [
                'name' => 'أحمد سليمان',
                'email' => 'ahmed@syria-volunteers.org',
                'password' => Hash::make('password123'),
                'organization_id' => 1,
            ],
            [
                'name' => 'فاطمة محمد',
                'email' => 'fatima@hope-foundation.org',
                'password' => Hash::make('password123'),
                'organization_id' => 2,
            ],
            [
                'name' => 'عمر خالد',
                'email' => 'omar@ataa-charity.org',
                'password' => Hash::make('password123'),
                'organization_id' => 3,
            ],
        ];

        foreach ($orgAdmins as $admin) {
            $organizationId = $admin['organization_id'];
            unset($admin['organization_id']);
            
            $user = User::create($admin);
            $user->assignRole('منظمة');
            $user->givePermissionTo(['create-job-offer', 'manage-volunteers']);
            
            // Asociar usuario con organización
            $user->organizations()->attach($organizationId, ['role' => 'admin']);
        }
    }
}
