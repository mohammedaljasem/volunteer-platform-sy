<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\Channels\DatabaseChannel;
use App\Channels\CustomDatabaseChannel;

class CustomNotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Override Laravel's default DatabaseChannel with our custom one
        $this->app->bind(DatabaseChannel::class, function ($app) {
            return new CustomDatabaseChannel();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Define the table for notifications
        config(['database.notifications.table' => 'laravel_notifications']);
    }
}
