<?php

namespace Database\Seeders;

use App\Models\Ad;
use Illuminate\Database\Seeder;

class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Campaign 1
        Ad::create([
            'title' => 'حملة إغاثة المتضررين من الزلزال',
            'description' => 'حملة لجمع التبرعات وتوزيع المساعدات للمتضررين من الزلزال في شمال سوريا',
            'company_id' => 1, // فريق سوريا التطوعي
            'goal_amount' => 5000000,
            'current_amount' => 2000000,
            'start_date' => '2023-03-20',
            'end_date' => '2023-12-20',
            'status' => 'نشطة',
            'category' => 'إغاثة',
        ]);

        // Campaign 2
        Ad::create([
            'title' => 'حملة تشجير المناطق المتضررة',
            'description' => 'حملة لزراعة الأشجار في المناطق المتضررة من الحرائق في سوريا',
            'company_id' => 2, // منظمة الأمل السورية
            'goal_amount' => 3000000,
            'current_amount' => 1500000,
            'start_date' => '2023-04-01',
            'end_date' => '2023-12-01',
            'status' => 'نشطة',
            'category' => 'بيئة',
        ]);

        // Campaign 3
        Ad::create([
            'title' => 'حملة دعم التعليم',
            'description' => 'حملة لتوفير المستلزمات المدرسية للطلاب المحتاجين في المناطق النائية',
            'company_id' => 1, // فريق سوريا التطوعي
            'goal_amount' => 2000000,
            'current_amount' => 500000,
            'start_date' => '2023-05-01',
            'end_date' => '2023-11-01',
            'status' => 'نشطة',
            'category' => 'تعليم',
        ]);

        // Campaign 4
        Ad::create([
            'title' => 'حملة الرعاية الصحية للأطفال',
            'description' => 'حملة لتوفير الرعاية الصحية والأدوية للأطفال المحتاجين في المناطق الريفية',
            'company_id' => 2, // منظمة الأمل السورية
            'goal_amount' => 4000000,
            'current_amount' => 1000000,
            'start_date' => '2023-06-15',
            'end_date' => '2023-12-15',
            'status' => 'نشطة',
            'category' => 'صحة',
        ]);

        // Campaign 5
        Ad::create([
            'title' => 'حملة كفالة الأيتام',
            'description' => 'حملة لكفالة الأيتام وتوفير احتياجاتهم من مأكل ومشرب وملبس وتعليم',
            'company_id' => 1, // فريق سوريا التطوعي
            'goal_amount' => 6000000,
            'current_amount' => 3000000,
            'start_date' => '2023-07-01',
            'end_date' => '2023-12-31',
            'status' => 'نشطة',
            'category' => 'أيتام',
        ]);

        // Campaign 6
        Ad::create([
            'title' => 'مشروع بناء مدرسة',
            'description' => 'مشروع لبناء مدرسة جديدة في منطقة نائية لخدمة الأطفال الذين يعانون من صعوبة الوصول للتعليم',
            'company_id' => 2, // منظمة الأمل السورية
            'goal_amount' => 10000000,
            'current_amount' => 4000000,
            'start_date' => '2023-08-01',
            'end_date' => '2024-01-31',
            'status' => 'نشطة',
            'category' => 'مشاريع خيرية',
        ]);
    }
} 