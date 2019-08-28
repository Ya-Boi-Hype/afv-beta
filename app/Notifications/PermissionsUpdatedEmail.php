<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PermissionsUpdatedEmail extends Notification implements ShouldQueue
{
    use Queueable;

    public $permissions;
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($permissions)
    {
        $this->permissions = $permissions;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $permissions = $this->permissions;
        return (new MailMessage)
            ->subject('Audio For VATSIM - Permissions Updated')
            ->greeting("Hi, $notifiable->name_first!")
            ->markdown('emails.permissions_updated', compact('permissions'));
    }
}
