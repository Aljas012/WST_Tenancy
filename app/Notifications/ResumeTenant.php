<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResumeTenant extends Notification
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
            ->subject('Your A.P.S_ONE Tenant Status Has Been Successfully Resumed')

            ->greeting('Hi ' . $this->tenantApplication->full_name . ',')
            ->line('We are pleased to inform you that your Tenant Status has been successfully resumed.')
           
            ->line('Application ID: ' . $this->tenantApplication->id)
            ->line('Tenant Information:')
            ->line('Business: ' . $this->tenantApplication->business)
            ->line('Domain: ' . $this->tenantApplication->domain)
            ->line('Subscription Plan: ' . $this->tenantApplication->subscription)

            ->line('Thank you for your continued interest.');
    }
}
