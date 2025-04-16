<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RejectTenant extends Notification
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

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('A.P.S_ONE Tenant Application was Regretfully Rejected')

            ->greeting('Hi ' . $this->tenantApplication->full_name . ',')
            ->line('Thank you for submitting your tenancy application. After careful consideration, we regret to inform you that your application has not been successful at this time.')

            ->line('Application ID: ' . $this->tenantApplication->id)
            ->line('Applicant Information:')
            ->line('Full Name: ' . $this->tenantApplication->full_name)
            ->line('Email: ' . $this->tenantApplication->email)
            ->line('Contact: ' . $this->tenantApplication->contact)
            ->line('Business: ' . $this->tenantApplication->business)
            ->line('Domain: ' . $this->tenantApplication->domain)
            ->line('Subscription Plan: ' . $this->tenantApplication->subscription)

            ->line('Thank you again for your interest in A.P.S_ONE');
    }
}
