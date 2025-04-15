<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PausedTenant extends Notification
{
    use Queueable;

    public $tenantApplication;

    public function __construct($tenantApplication)
    {
        $this->tenantApplication = $tenantApplication;
    }

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
            ->subject('Your A.P.S_ONE Tenant Status is Currently on Paused')

            ->greeting('Hi ' . $this->tenantApplication->full_name . ',')
            ->line('Your tenancy application has been temporarily paused, possibly due to an outstanding payment or related issue. Please contact us for further assistance to resume the process.')
           
            ->line('Tenant Information:')
            ->line('Application ID: ' . $this->tenantApplication->id)
            ->line('Business: ' . $this->tenantApplication->business)
            ->line('Domain: ' . $this->tenantApplication->domain)
            ->line('Subscription Plan: ' . $this->tenantApplication->subscription)

            ->line('We appreciate your interest and look forward to assisting you further.');
    }
}
