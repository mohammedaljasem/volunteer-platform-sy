<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JobOffer;
use App\Models\City;
use App\Models\Organization;
use Carbon\Carbon;

class JobOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
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
                'image' => 'job_offers/default1.jpg',
                'organization_id' => $organization->id,
                'status' => 'متاحة',
                'city_id' => $city->id,
                'deadline' => now()->addDays(10),
                'start_date' => now()->addDays(15),
            ],
            [
                'title' => 'متطوعون للتدريس المجاني للأطفال',
                'description' => 'فرصة تطوع لتدريس الأطفال المتأخرين دراسياً في المناطق النائية',
                'requirements' => 'خبرة في التدريس، مهارات في التعامل مع الأطفال، القدرة على السفر للمناطق النائية',
                'image' => 'job_offers/default2.jpg',
                'organization_id' => $organization->id,
                'status' => 'متاحة',
                'city_id' => $city->id,
                'deadline' => now()->addDays(20),
                'start_date' => now()->addDays(30),
            ],
            [
                'title' => 'متطوعون للمساعدة في ترميم مدرسة',
                'description' => 'نبحث عن متطوعين للمساعدة في ترميم وإعادة تأهيل مدرسة متضررة في ريف دمشق',
                'requirements' => 'خبرة في أعمال البناء والترميم، القدرة على العمل في ظروف صعبة، متاح للعمل لمدة أسبوعين',
                'image' => 'job_offers/default3.jpg',
                'organization_id' => $organization->id,
                'status' => 'متاحة',
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

        $this->command->info('تمت إضافة فرص التطوع بنجاح!');
    }
}
