<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run the roles and permissions seeder first
        $this->call([
            RolesAndPermissionsSeeder::class,
            OrganizationSeeder::class,
            CompanySeeder::class,
            AdSeeder::class,
            JobOfferSeeder::class,
        ]);

        // Create a test user
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '0987654321',
            'notification_preference' => 'email',
        ]);

        // Assign the 'مستخدم' role to the test user
        $user->assignRole('مستخدم');

        // Create a test volunteer team
        $team = User::factory()->create([
            'name' => 'Test Team',
            'email' => 'team@example.com',
            'phone' => '0123456789',
            'notification_preference' => 'email',
        ]);

        // Assign the 'فرقة تطوعية' role to the test team
        $team->assignRole('فرقة تطوعية');

        // Create a test organization
        $org = User::factory()->create([
            'name' => 'Test Organization',
            'email' => 'org@example.com',
            'phone' => '0567891234',
            'notification_preference' => 'email',
        ]);

        // Assign the 'منظمة' role to the test organization
        $org->assignRole('منظمة');

        // إضافة المدن السورية
        $cities = [
            'دمشق',
            'حلب',
            'حمص',
            'حماة',
            'اللاذقية',
            'طرطوس',
            'دير الزور',
            'الرقة',
            'الحسكة',
            'درعا',
            'السويداء',
            'القنيطرة',
            'إدلب',
        ];
        
        foreach ($cities as $cityName) {
            \App\Models\City::create(['name' => $cityName]);
        }
    }
}
