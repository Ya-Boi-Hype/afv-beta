<?php

namespace App\Events;

use App\Models\User;
use App\Models\Approval;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UserApproved
{
    use Dispatchable, SerializesModels;

    public $approval;

    /**
     * Create a new event instance.
     *
     * @param Approval $approval
     */
    public function __construct(Approval $approval)
    {
        Log::info('User Approved Event');
        $this->approval = $approval;
    }

    public function getUser(): User
    {
        return $this->approval->user;
    }
}
