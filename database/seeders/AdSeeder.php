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
        // Campaña 1
        Ad::create([
            'title' => 'حملة إغاثة المتضررين من الزلزال',
            'description' => 'حملة لجمع التبرعات وتوزيع المساعدات للمتضررين من الزلزال في شمال سوريا',
            'company_id' => 1, // فريق سوريا التطوعي
            'goal_amount' => 5000000,
            'current_amount' => 2000000,
            'start_date' => '2025-03-20',
            'end_date' => '2025-04-20',
            'status' => 'نشطة',
        ]);

        // Campaña 2
        Ad::create([
            'title' => 'حملة تشجير المناطق المتضررة',
            'description' => 'حملة لزراعة الأشجار في المناطق المتضررة من الحرائق في سوريا',
            'company_id' => 2, // منظمة الأمل السورية
            'goal_amount' => 3000000,
            'current_amount' => 1500000,
            'start_date' => '2025-04-01',
            'end_date' => '2025-05-01',
            'status' => 'نشطة',
        ]);

        // Campaña 3
        Ad::create([
            'title' => 'حملة دعم التعليم',
            'description' => 'حملة لتوفير المستلزمات المدرسية للطلاب المحتاجين في المناطق النائية',
            'company_id' => 1, // فريق سوريا التطوعي
            'goal_amount' => 2000000,
            'current_amount' => 500000,
            'start_date' => '2025-05-01',
            'end_date' => '2025-06-01',
            'status' => 'نشطة',
        ]);

        // Campaña 4
        Ad::create([
            'title' => 'حملة الرعاية الصحية',
            'description' => 'حملة لتوفير الأدوية والمستلزمات الطبية للمرضى المحتاجين',
            'company_id' => 3, // فريق الخير التطوعي
            'goal_amount' => 4000000,
            'current_amount' => 1000000,
            'start_date' => '2025-06-01',
            'end_date' => '2025-07-01',
            'status' => 'قادمة',
        ]);
    }
} 