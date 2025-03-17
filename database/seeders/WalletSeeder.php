<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Log;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $count = 0;

        foreach ($users as $user) {
            // تخطي المستخدمين الذين لديهم محفظة بالفعل
            if (Wallet::where('user_id', $user->id)->exists()) {
                continue;
            }

            // إنشاء محفظة جديدة للمستخدم
            Wallet::create([
                'user_id' => $user->id,
                'balance' => 1000, // رصيد افتراضي 1000 ليرة سورية
            ]);

            $count++;
        }

        Log::info("تم إنشاء {$count} محفظة جديدة للمستخدمين");
        $this->command->info("تم إنشاء {$count} محفظة جديدة للمستخدمين");
    }
}
