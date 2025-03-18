<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ad;
use App\Models\Organization;
use App\Models\Location;
use App\Models\User;
use App\Models\Company;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء شركة تجريبية إذا لم تكن موجودة
        $company = Company::firstOrCreate(
            ['name' => 'شركة سوريا للتطوع'],
            [
                'description' => 'شركة رائدة في مجال الأعمال التطوعية في سوريا',
                'verified' => true,
            ]
        );

        // بيانات تجريبية للحملات التطوعية (الإعلانات) مع إحداثيات
        $ads = [
            [
                'title' => 'حملة إعادة إعمار حلب',
                'description' => 'حملة لإعادة إعمار المناطق المتضررة في مدينة حلب',
                'status' => 'نشطة',
                'company_id' => $company->id,
                'category' => 'إغاثة',
                'goal_amount' => 10000,
                'current_amount' => 5000,
                'start_date' => now(),
                'end_date' => now()->addMonths(3),
                'latitude' => 36.2021,
                'longitude' => 37.1343
            ],
            [
                'title' => 'دعم المشردين في دمشق',
                'description' => 'حملة لدعم العائلات المشردة في دمشق وضواحيها',
                'status' => 'نشطة',
                'company_id' => $company->id,
                'category' => 'مساعدات إنسانية',
                'goal_amount' => 5000,
                'current_amount' => 2000,
                'start_date' => now(),
                'end_date' => now()->addMonths(2),
                'latitude' => 33.5138,
                'longitude' => 36.2765
            ],
            [
                'title' => 'إعادة تأهيل المدارس في حمص',
                'description' => 'إعادة تأهيل المدارس المتضررة في مدينة حمص لاستقبال الطلاب',
                'status' => 'نشطة',
                'company_id' => $company->id,
                'category' => 'تعليم',
                'goal_amount' => 8000,
                'current_amount' => 3000,
                'start_date' => now(),
                'end_date' => now()->addMonths(4),
                'latitude' => 34.7324,
                'longitude' => 36.7137
            ],
            [
                'title' => 'توزيع المواد الغذائية في اللاذقية',
                'description' => 'حملة لتوزيع المواد الغذائية على العائلات المحتاجة في اللاذقية',
                'status' => 'نشطة',
                'company_id' => $company->id,
                'category' => 'غذاء',
                'goal_amount' => 3000,
                'current_amount' => 1500,
                'start_date' => now(),
                'end_date' => now()->addMonths(1),
                'latitude' => 35.5317,
                'longitude' => 35.7914
            ],
            [
                'title' => 'مساعدة كبار السن في طرطوس',
                'description' => 'تقديم الدعم والرعاية لكبار السن في مدينة طرطوس',
                'status' => 'نشطة',
                'company_id' => $company->id,
                'category' => 'رعاية صحية',
                'goal_amount' => 4000,
                'current_amount' => 2000,
                'start_date' => now(),
                'end_date' => now()->addMonths(2),
                'latitude' => 34.8897,
                'longitude' => 35.8866
            ]
        ];

        // إنشاء الإعلانات
        foreach ($ads as $adData) {
            Ad::firstOrCreate(
                ['title' => $adData['title']],
                $adData
            );
        }

        // بيانات تجريبية للمنظمات
        $organizations = [
            [
                'name' => 'منظمة الإغاثة السورية',
                'description' => 'منظمة تهتم بتقديم المساعدات الإنسانية للمتضررين',
                'verified' => true,
                'latitude' => 33.5074,
                'longitude' => 36.3124,
                'contact_email' => 'info@syria-relief.org'
            ],
            [
                'name' => 'جمعية التكافل الاجتماعي',
                'description' => 'جمعية خيرية تهدف إلى تحقيق التكافل الاجتماعي بين أفراد المجتمع',
                'verified' => true,
                'latitude' => 36.1963,
                'longitude' => 37.2153,
                'contact_email' => 'info@takaful.org'
            ],
            [
                'name' => 'مؤسسة بناء المستقبل',
                'description' => 'مؤسسة تهتم بتأهيل الشباب وتدريبهم على المهارات المختلفة',
                'verified' => true,
                'latitude' => 34.7298,
                'longitude' => 36.7328,
                'contact_email' => 'info@future-building.org'
            ],
            [
                'name' => 'جمعية رعاية الأيتام',
                'description' => 'جمعية تهتم برعاية الأيتام وتوفير احتياجاتهم',
                'verified' => true,
                'latitude' => 35.5345,
                'longitude' => 35.8021,
                'contact_email' => 'info@orphans-care.org'
            ],
            [
                'name' => 'منظمة الصحة والتنمية',
                'description' => 'منظمة تهتم بتقديم الخدمات الصحية وتعزيز التنمية المجتمعية',
                'verified' => true,
                'latitude' => 34.8921,
                'longitude' => 35.8723,
                'contact_email' => 'info@health-dev.org'
            ]
        ];

        // إنشاء المنظمات ومواقعها
        foreach ($organizations as $orgData) {
            $latitude = $orgData['latitude'];
            $longitude = $orgData['longitude'];
            
            unset($orgData['latitude']);
            unset($orgData['longitude']);
            
            $organization = Organization::firstOrCreate(
                ['name' => $orgData['name']],
                $orgData
            );
            
            // إنشاء موقع للمنظمة
            Location::firstOrCreate(
                ['organization_id' => $organization->id],
                [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'organization_id' => $organization->id
                ]
            );
        }
    }
}
