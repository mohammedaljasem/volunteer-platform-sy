<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
            City::create(['name' => $cityName]);
        }
    }
} 