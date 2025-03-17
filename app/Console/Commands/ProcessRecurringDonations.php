<?php

namespace App\Console\Commands;

use App\Models\Donation;
use App\Models\Ad;
use App\Models\Wallet;
use App\Models\UserPoint;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Notifications\DonationThanksNotification;

class ProcessRecurringDonations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'donations:process-recurring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'معالجة التبرعات المتكررة الشهرية بشكل تلقائي';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('بدء معالجة التبرعات المتكررة...');
        
        // الحصول على التبرعات المتكررة النشطة
        $recurringDonations = Donation::where('is_recurring', true)
            ->groupBy('user_id', 'ad_id')
            ->selectRaw('MAX(id) as id, user_id, ad_id, payment_method, amount')
            ->get();
            
        $this->info("تم العثور على {$recurringDonations->count()} تبرعات متكررة للمعالجة");
        
        foreach ($recurringDonations as $donationInfo) {
            // الحصول على التبرع الأصلي
            $originalDonation = Donation::find($donationInfo->id);
            
            // تخطي إذا كان التبرع الأصلي غير موجود
            if (!$originalDonation) {
                $this->warn("تبرع غير موجود بالمعرف: {$donationInfo->id}");
                continue;
            }
            
            // التحقق من أن الحملة لا تزال نشطة
            $ad = Ad::find($originalDonation->ad_id);
            if (!$ad || $ad->status !== 'نشطة') {
                $this->warn("الحملة غير نشطة أو غير موجودة: {$originalDonation->ad_id}");
                continue;
            }
            
            // التحقق من طريقة الدفع وإجراء العملية المناسبة
            try {
                if ($originalDonation->payment_method === 'محفظة') {
                    // التحقق من محفظة المستخدم
                    $wallet = Wallet::where('user_id', $originalDonation->user_id)->first();
                    
                    // التحقق من كفاية الرصيد
                    if (!$wallet || $wallet->balance < $originalDonation->amount) {
                        $this->warn("رصيد غير كافٍ للمستخدم: {$originalDonation->user_id} للتبرع المتكرر");
                        continue;
                    }
                    
                    // خصم المبلغ من المحفظة
                    $wallet->withdraw($originalDonation->amount);
                }
                
                // إنشاء تبرع جديد
                $newDonation = new Donation([
                    'user_id' => $originalDonation->user_id,
                    'ad_id' => $originalDonation->ad_id,
                    'amount' => $originalDonation->amount,
                    'payment_method' => $originalDonation->payment_method,
                    'date' => now(),
                    'is_recurring' => true, // لا يزال تبرع متكرر
                    'is_auto_processed' => true // للإشارة إلى أنه تمت معالجته تلقائيًا
                ]);
                
                $newDonation->save();
                
                // تحديث المبلغ الحالي للحملة
                $ad->current_amount += $originalDonation->amount;
                
                // التحقق إذا وصلنا للمبلغ المستهدف أو تجاوزناه
                if ($ad->current_amount >= $ad->goal_amount) {
                    $ad->status = 'مكتملة';
                }
                
                $ad->save();
                
                // منح نقاط للمستخدم (10 نقاط لكل 100 وحدة من المبلغ)
                $pointsToAward = max(10, floor($originalDonation->amount / 100) * 10);
                
                UserPoint::create([
                    'user_id' => $originalDonation->user_id,
                    'points' => $pointsToAward,
                    'earned_date' => now(),
                    'source' => 'recurring_donation_' . $newDonation->id,
                ]);
                
                // إرسال إشعار شكر للمستخدم (اختياري)
                $user = User::find($originalDonation->user_id);
                if ($user) {
                    $user->notify(new DonationThanksNotification($newDonation));
                }
                
                $this->info("تم معالجة التبرع المتكرر بنجاح للمستخدم: {$originalDonation->user_id} للحملة: {$ad->title}");
            } catch (\Exception $e) {
                $this->error("خطأ أثناء معالجة التبرع المتكرر للمستخدم: {$originalDonation->user_id}");
                Log::error("خطأ في معالجة التبرع المتكرر: " . $e->getMessage());
            }
        }
        
        $this->info('اكتملت معالجة التبرعات المتكررة بنجاح');
        
        return Command::SUCCESS;
    }
}
