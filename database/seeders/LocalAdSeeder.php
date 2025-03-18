<?php

namespace Database\Seeders;

use App\Models\LocalAd;
use App\Models\User;
use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalAdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // التأكد من وجود مستخدمين
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create([
                'name' => 'مستخدم اختبار',
                'email' => 'test@example.com',
            ]);
        }

        // التأكد من وجود مدن
        $city = City::first();
        if (!$city) {
            $city = City::create(['name' => 'دمشق']);
        }

        // إضافة إعلانات محلية للاختبار
        $localAds = [
            [
                'title' => 'مساعدة عائلة متضررة في حي التضامن',
                'description' => 'نبحث عن متطوعين للمساعدة في ترميم منزل عائلة متضررة في حي التضامن في دمشق',
                'status' => 'معلق',
                'user_id' => $user->id,
                'city_id' => $city->id,
                'expires_at' => now()->addDays(30),
                'category' => 'مساعدة إنسانية',
                'contact_info' => '0987654321',
            ],
            [
                'title' => 'جمع تبرعات ملابس للأطفال',
                'description' => 'نقوم بجمع تبرعات ملابس للأطفال المحتاجين في المناطق المتضررة',
                'status' => 'نشط',
                'user_id' => $user->id,
                'city_id' => $city->id,
                'expires_at' => now()->addDays(15),
                'category' => 'تبرعات عينية',
                'contact_info' => '0912345678',
            ],
            [
                'title' => 'دروس تقوية مجانية',
                'description' => 'نقدم دروس تقوية مجانية للطلاب المتأخرين دراسياً في مادتي الرياضيات والفيزياء',
                'status' => 'معلق',
                'user_id' => $user->id,
                'city_id' => $city->id,
                'expires_at' => now()->addDays(60),
                'category' => 'تعليم',
                'contact_info' => '0954321098',
            ],
        ];

        foreach ($localAds as $adData) {
            LocalAd::updateOrCreate(
                ['title' => $adData['title']],
                $adData
            );
        }

        echo "تمت إضافة الإعلانات المحلية بنجاح!\n";
    }
} 