<?php

namespace App\Listeners;

use App\Events\PermissionsUpdated;
use App\Models\User;
use App\Notifications\PermissionsUpdatedEmail;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SendPermissionsUpdatedMail
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PermissionsUpdated $event)
    {
        /*try {
            $user = User::findOrFail($event->user);
        } catch (ModelNotFoundException $e) {
            return;
        }

        if (! count($event->permissions)) {
            return;
        } else {
            $user->notify(new PermissionsUpdatedEmail($event->permissions));
        }*/
    }
}
