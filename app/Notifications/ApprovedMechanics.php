<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApprovedMechanics extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $user;
    protected $password;

    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
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
            ->subject('Mechanic Application is Approved!')
            ->greeting('Hi' . $this->user->name)
            ->line('Congratulations! You have been approved as a mechanic.')
            ->line('Here are your login credentials:')

            ->line('-------------')
            ->line('Email: ' . $this->user->email)
            ->line('Password: ' . $this->password)
            ->line('-------------')

            ->line('Thank you for applying as our mechanic!');
        ;
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
