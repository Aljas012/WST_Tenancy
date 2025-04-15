<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeleteTenant extends Notification
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
            ->subject('Your A.P.S_ONE Tenant Status Has Been Deleted')

            ->greeting('Hi ' . $this->tenancy->full_name . ',')
            ->line('We regret to inform you that your tenant subscription has been deleted. If you have any questions or require further clarification, please do not hesitate to contact us.')
           
            ->line('Application ID: ' . $this->tenancy->id)
            ->line('Tenant Information:')
            ->line('Business: ' . $this->tenancy->business)
            ->line('Domain: ' . $this->tenancy->domain)
            ->line('Subscription Plan: ' . $this->tenancy->subscription)

            ->line('We sincerely appreciate your understanding and thank you for your continued interest.');
    }
}
