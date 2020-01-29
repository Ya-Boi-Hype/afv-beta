<?php

namespace Tests\Unit;

use App\Events\UserExpressedInterest;
use App\Listeners\SendInterestConfirmationEmail;
use App\Models\Approval;
use App\Notifications\InterestConfirmationEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UserRequestTest extends TestCase
{
    use RefreshDatabase;

    private $approval;

    public function setUp(): void
    {
        parent::setUp();

        $this->approval = factory(Approval::class)->create();
    }

    /** @test */
    public function a_notification_is_fired_when_a_request_is_made()
    {
        Notification::fake();

        $event = \Mockery::mock(UserExpressedInterest::class, [$this->approval]);
        $listener = app()->make(SendInterestConfirmationEmail::class);
        $listener->handle($event);

        Notification::assertSentTo($this->approval->user, InterestConfirmationEmail::class);
    }
}
