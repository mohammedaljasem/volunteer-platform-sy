<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Models\Wallet;
use Illuminate\Auth\Events\Login;
use App\Models\Message;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // إنشاء محفظة لكل مستخدم بعد تسجيل الدخول
        Event::listen(Login::class, function (Login $event) {
            $user = $event->user;
            if ($user) {
                // التحقق من وجود محفظة للمستخدم أو إنشاء واحدة جديدة
                Wallet::firstOrCreate(
                    ['user_id' => $user->id],
                    ['balance' => 0]
                );
            }
        });
        View::composer('*', function ($view) {
            if (auth()->check()) {
                $userId = auth()->id();
    
                $unreadCount = Message::whereHas('conversation.users', function ($q) use ($userId) {
                        $q->where('user_id', $userId);
                    })
                    ->where('user_id', '!=', $userId)
                    ->whereDoesntHave('reads', function ($q) use ($userId) {
                        $q->where('user_id', $userId);
                    })
                    ->count();
    
                $view->with('unreadMessageCount', $unreadCount);
            }
        });
    }
}
