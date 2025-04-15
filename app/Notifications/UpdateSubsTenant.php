<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpdateSubsTenant extends Notification
{
    use Queueable;

    public $tenancy;

    public function __construct($tenancy)
    {
        $this->tenancy = $tenancy;
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
            ->subject('Your A.P.S_ONE Tenant Subscription Has Been Successfully Changed')

            ->greeting('Hi ' . $this->tenancy->full_name . ',')
            ->line('We are pleased to inform you that your Tenant Subscription has been Changed.')
           
            ->line('Application ID: ' . $this->tenancy->id)
            ->line('Tenant Information:')
            ->line('Business: ' . $this->tenancy->business)
            ->line('Domain: ' . $this->tenancy->domain)
            ->line('Subscription Plan: ' . $this->tenancy->subscription)

            ->line('Thank you for your continued interest.');
    }
}
