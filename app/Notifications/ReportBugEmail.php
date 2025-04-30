<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportBugEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    protected $tenantData;
    protected $bugReport;

    public function __construct($centralTenant, $bugReport)
    {
        $this->tenantData = $centralTenant;
        $this->bugReport = $bugReport;
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
            ->subject('Reported Bug')
            ->greeting('Hello Central Team,')

            ->line('A bug has been reported from:')
            ->line('ID: ' . $this->tenantData->id)
            ->line('Tenant: ' . $this->tenantData->full_name)
            ->line('Email: ' . $this->tenantData->email)
            ->line('Business: ' . $this->tenantData->business)

            ->line('---')
            ->line($this->bugReport)
            ->line('---')

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
