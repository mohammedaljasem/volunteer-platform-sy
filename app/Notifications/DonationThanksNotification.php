<?php

namespace App\Notifications;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DonationThanksNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $donation;

    /**
     * Create a new notification instance.
     */
    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('شكرًا على تبرعك')
                    ->greeting('مرحبًا ' . $notifiable->name)
                    ->line('نود أن نشكرك على تبرعك السخي لحملة "' . $this->donation->ad->title . '".')
                    ->line('مبلغ التبرع: ' . $this->donation->amount . ' ل.س')
                    ->line('بفضل دعمك، نحن أقرب إلى تحقيق هدفنا.')
                    ->action('عرض الحملة', url('/ads/' . $this->donation->ad_id))
                    ->line('شكرًا لمساهمتك في مجتمعنا!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'donation_id' => $this->donation->id,
            'ad_id' => $this->donation->ad_id,
            'ad_title' => $this->donation->ad->title,
            'amount' => $this->donation->amount,
            'message' => 'شكرًا على تبرعك بمبلغ ' . $this->donation->amount . ' ل.س لحملة "' . $this->donation->ad->title . '".',
            'type' => 'donation_thanks',
        ];
    }
}
