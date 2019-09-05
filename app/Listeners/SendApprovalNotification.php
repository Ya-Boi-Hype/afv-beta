<?php

namespace App\Listeners;

use App\Events\UserApproved;
use Illuminate\Support\Facades\Log;
use App\Notifications\ApprovalWelcomeEmail;

class SendApprovalNotification
{
    /**
     * Handle the event.
     *
     * @param  UserApproved $event
     * @return void
     */
    public function handle(UserApproved $event)
    {
        if ($event->approval->user) { // FIX for imported Approvals from FSExpo with no User
            Log::info($event->approval->user->full_name.' approved');
            $event->approval->user->notify(new ApprovalWelcomeEmail());
        } else {
            Log::info($event->approval->user_id.' approved');
        }
    }
}
