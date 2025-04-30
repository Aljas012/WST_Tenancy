<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionUpgradeRequest extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    protected $tenantData;

    public function __construct($centralTenant)
    {
        $this->tenantData = $centralTenant;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Subscription Upgrade Request')
            ->greeting('Hello Central Team,')
            ->line('A tenant has requested a subscription upgrade.')

            ->line('------------------------')
            ->line('Tenant: ' . $this->tenantData->full_name)
            ->line('Email: ' . $this->tenantData->email)
            ->line('Business: ' . $this->tenantData->business)
            ->line('Subscription: ' . $this->tenantData->subscription)
            ->line('------------------------')

            ->line('Please review and take the necessary action.')
            ->salutation('Regards, Your Tenant App');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
