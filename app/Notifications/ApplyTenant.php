<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplyTenant extends Notification
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
            ->subject('A.P.S_ONE Tenant Application was Successfully Submitted!')

            ->greeting('Hi ' . $this->tenantApplication->full_name . ',')
            ->line('Thank you for submitting your tenancy application. We are currently reviewing the details and will be in touch with you shortly.')
           
            ->line('Application ID: ' . $this->tenantApplication->id)
            ->line('Applicant Information:')
            ->line('Full Name: ' . $this->tenantApplication->full_name)
            ->line('Email: ' . $this->tenantApplication->email)
            ->line('Contact: ' . $this->tenantApplication->contact)
            ->line('Business: ' . $this->tenantApplication->business)
            ->line('Domain: ' . $this->tenantApplication->domain)
            ->line('Subscription Plan: ' . $this->tenantApplication->subscription)

            ->line('Thank you for applying.');
    }
}
