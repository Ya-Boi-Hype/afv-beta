<?php

namespace App\Events;

use App\Models\Approval;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserExpressedInterest
{
    use Dispatchable, SerializesModels;

    /** @var Approval */
    public $approval;

    /**
     * Create a new event instance.
     *
     * @param Approval $approval
     */
    public function __construct(Approval $approval)
    {
        $this->approval = $approval;
    }

    public function getApproval(): Approval
    {
        return $this->approval;
    }
}
