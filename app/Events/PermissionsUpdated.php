<?php

namespace App\Events;

use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

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
        Log::info('Permissions Updated Event');
        $this->user = $user;
        $this->permissions = $permissions;
    }
}
