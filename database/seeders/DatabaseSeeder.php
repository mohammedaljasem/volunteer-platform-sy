<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JobOffer;
use App\Models\City;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            LocationsSeeder::class,
            WalletSeeder::class,
            LocalAdSeeder::class,
        ]);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'مدير النظام',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'), // كلمة المرور للاختبار فقط
                'phone' => '0912345678',
                'notification_preference' => 'email',
            ]
        );
        
        // Assign the 'admin' role to the admin user
        $admin->assignRole('admin');

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

        $this->seedJobOffers();

        // إضافة سجلات لجدول ad_participants للاختبار
        DB::table('ad_participants')->insert([
            [
                'user_id' => 1, // تأكد من تعديل هذه القيمة إلى معرف مستخدم حقيقي في نظامك
                'ad_id' => 1,   // تأكد من تعديل هذه القيمة إلى معرف حملة حقيقية في نظامك
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'ad_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * إضافة بيانات فرص تطوع تجريبية
     */
    private function seedJobOffers(): void
    {
        // التأكد من وجود منظمة واحدة على الأقل
        $organization = Organization::first();
        if (!$organization) {
            $organization = Organization::create([
                'name' => 'منظمة سوريا للتطوع',
                'description' => 'منظمة تسعى لتنسيق جهود التطوع في سوريا',
                'email' => 'info@syria-volunteer.org',
                'phone' => '0912345678',
                'logo' => null,
                'verified' => true,
            ]);
        }

        // التأكد من وجود مدينة واحدة على الأقل
        $city = City::first();
        if (!$city) {
            $city = City::create([
                'name' => 'دمشق',
            ]);
        }

        // إضافة فرص تطوع تجريبية
        $jobOffers = [
            [
                'title' => 'مساعدة في توزيع المساعدات الغذائية',
                'description' => 'نبحث عن متطوعين للمساعدة في توزيع المساعدات الغذائية على العائلات المتضررة في دمشق',
                'requirements' => 'القدرة على العمل لمدة 4 ساعات يومياً لمدة أسبوع، العمل ضمن فريق، الالتزام بالمواعيد',
                'organization_id' => $organization->id,
                'status' => 'متاح',
                'city_id' => $city->id,
                'deadline' => now()->addDays(10),
                'start_date' => now()->addDays(15),
            ],
            [
                'title' => 'متطوعون للتدريس المجاني للأطفال',
                'description' => 'فرصة تطوع لتدريس الأطفال المتأخرين دراسياً في المناطق النائية',
                'requirements' => 'خبرة في التدريس، مهارات في التعامل مع الأطفال، القدرة على السفر للمناطق النائية',
                'organization_id' => $organization->id,
                'status' => 'متاح',
                'city_id' => $city->id,
                'deadline' => now()->addDays(20),
                'start_date' => now()->addDays(30),
            ],
            [
                'title' => 'متطوعون للمساعدة في ترميم مدرسة',
                'description' => 'نبحث عن متطوعين للمساعدة في ترميم وإعادة تأهيل مدرسة متضررة في ريف دمشق',
                'requirements' => 'خبرة في أعمال البناء والترميم، القدرة على العمل في ظروف صعبة، متاح للعمل لمدة أسبوعين',
                'organization_id' => $organization->id,
                'status' => 'متاح',
                'city_id' => $city->id,
                'deadline' => now()->addDays(5),
                'start_date' => now()->addDays(10),
            ],
        ];

        foreach ($jobOffers as $offerData) {
            JobOffer::updateOrCreate(
                ['title' => $offerData['title']],
                $offerData
            );
        }

        echo "تمت إضافة فرص التطوع بنجاح!\n";
    }
}
