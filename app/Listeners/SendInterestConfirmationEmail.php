<?php

namespace App\Listeners;

use App\Events\UserExpressedInterest;
use App\Notifications\InterestConfirmationEmail;

class SendInterestConfirmationEmail
{
    /**
     * Handle the event.
     *
     * @param  UserExpressedInterest  $event
     * @return void
     */
    public function handle(UserExpressedInterest $event)
    {
        $event->approval->user->notify(new InterestConfirmationEmail());
    }
}
