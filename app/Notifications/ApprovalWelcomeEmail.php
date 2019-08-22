<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ApprovalWelcomeEmail extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Audio For VATSIM - Welcome to the Beta Team')
            ->greeting("Hello, $notifiable->name_first!")
            ->line('Thanks for signing up for the Audio for VATSIM beta.')
            ->line('We are pleased to invite you to join the testing team.')
            ->line('For instructions on how to join please go to https://afv-beta.vatsim.net for more info.')
            ->line('Regards,')
            ->salutation('The Audio For VATSIM Team');
    }
}
