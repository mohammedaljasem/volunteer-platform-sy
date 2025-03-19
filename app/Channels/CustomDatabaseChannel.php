<?php

namespace App\Channels;

use Illuminate\Notifications\Channels\DatabaseChannel;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CustomDatabaseChannel extends DatabaseChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return \App\Models\LaravelNotification
     */
    public function send($notifiable, Notification $notification)
    {
        // Get the database connection for Laravel notifications
        $database = $notifiable->routeNotificationFor('database', $notification);
        
        // Format the notification data
        $data = [
            'id' => (string) Str::uuid(),
            'type' => get_class($notification),
            'notifiable_id' => $notifiable->getKey(),
            'notifiable_type' => get_class($notifiable),
            'data' => $this->getData($notifiable, $notification),
            'read_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
        // Insert directly into the laravel_notifications table
        DB::table('laravel_notifications')->insert($data);
        
        return $data;
    }
} 