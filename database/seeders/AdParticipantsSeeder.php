<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdParticipantsSeeder extends Seeder
{
    /**
     * بذرة للمشاركات في الحملات التطوعية
     */
    public function run(): void
    {
        // الحصول على معرفات المستخدمين والحملات الموجودة
        $users = DB::table('users')->pluck('id')->toArray();
        $ads = DB::table('ads')->pluck('id')->toArray();
        
        // إذا كانت هناك حملات ومستخدمين، نضيف سجلات مشاركة
        if (!empty($users) && !empty($ads)) {
            $data = [];
            
            // أضف مستخدمين مختلفين لحملات مختلفة
            foreach ($users as $i => $userId) {
                // اختر حملتين لكل مستخدم (إذا توفر عدد كاف من الحملات)
                for ($j = 0; $j < min(2, count($ads)); $j++) {
                    $adIndex = ($i + $j) % count($ads);
                    
                    $data[] = [
                        'user_id' => $userId,
                        'ad_id' => $ads[$adIndex],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
            
            // نحقق من أن السجلات ليست فارغة
            if (!empty($data)) {
                // تجنب إدخال السجلات المكررة
                $existing = DB::table('ad_participants')
                    ->select('user_id', 'ad_id')
                    ->get()
                    ->map(fn($item) => $item->user_id . '-' . $item->ad_id)
                    ->toArray();
                
                $filtered = array_filter($data, function($item) use ($existing) {
                    $key = $item['user_id'] . '-' . $item['ad_id'];
                    return !in_array($key, $existing);
                });
                
                if (!empty($filtered)) {
                    DB::table('ad_participants')->insert($filtered);
                }
            }
        }
    }
} 