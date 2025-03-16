<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Compañía 1
        Company::create([
            'name' => 'فريق سوريا التطوعي',
            'description' => 'فريق تطوعي يهدف لمساعدة المحتاجين في سوريا',
            'verified' => true,
        ]);

        // Compañía 2
        Company::create([
            'name' => 'منظمة الأمل السورية',
            'description' => 'منظمة غير ربحية تعمل على تقديم المساعدات الإنسانية للمتضررين',
            'verified' => true,
        ]);

        // Compañía 3
        Company::create([
            'name' => 'فريق الخير التطوعي',
            'description' => 'فريق تطوعي يعمل على مساعدة الأيتام والأرامل في سوريا',
            'verified' => false,
        ]);
    }
} 