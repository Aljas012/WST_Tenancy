<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApprovedTenant extends Notification
{
    use Queueable;

    protected $tenant;
    protected $tenantInfo;
    protected $password;

    public function __construct($tenant, $password)
    {
        $this->tenant = $tenant;
        $this->password = $password;
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
            ->subject('A.P.S_ONE Tenant Application is Approved!')

            ->greeting('Hi ' . $this->tenant->full_name . ',')
            ->line('Congratulations! Your application has been successfully approved.')

            ->line('Application ID: ' . $this->tenant->id)
            ->line('Your domain is: ' . $this->tenant->domain . '.localhost:8000')
            ->line('Subscription Plan: ' . $this->tenant->subscription)
            ->line('Subscription Started: ' . ($this->tenant->subscription_start_date ?? 'Not Set'))
            ->line('Subscription will end: ' . ($this->tenant->subscription_end_date ?? 'Deadline Free'))

            ->line('------------------------')
            ->line('Your login credentials:')
            ->line('Email: ' . $this->tenant->email)
            ->line('Password: ' . $this->password)
            ->line('------------------------')
            
            ->line('Thank you for choosing our service!');
    }
}
