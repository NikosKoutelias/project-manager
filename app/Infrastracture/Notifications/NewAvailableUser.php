<?php

namespace App\Infrastracture\Notifications;

use App\Models\ValueObjects\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAvailableUser extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private $sender, private $message)
    {
        //
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
            ->subject("New User from Registration Process")
            ->line('The following user was created:')
            ->line('Name: '. $this->message->name)
            ->line('email: '. $this->message->email)
            ->line('role: '. $this->message->role->toString())
            ->line('id: '. $this->message->id);
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
