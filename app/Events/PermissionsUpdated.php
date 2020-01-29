<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PermissionsUpdated
{
    use Dispatchable, SerializesModels;

    public $user;
    public $permissions;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $permissions)
    {
        $this->user = $user;
        $this->permissions = $permissions;
    }
}
