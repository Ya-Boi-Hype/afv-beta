<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Events\UserExpressedInterest;

class UserRequestController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (auth()->user()->has_request) {
            return redirect()->route('home')->withError(['Nope!', 'You already have a request to join the beta.']);
        }

        // create an approval which is pending
        $approval = Approval::create(['user_id' => auth()->id()]);

        event(new UserExpressedInterest($approval));

        return redirect()->route('home')->withSuccess(['Registration complete!', 'Your request has been saved.']);
    }

    /**
     * Set as available for next event.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setAsAvailable(Request $request)
    {
        $approval = auth()->user()->approval;
        $approval->setAsAvailable();

        return redirect()->back()->withSuccess(['Availability Recorded', 'You will NOT receive a confirmation email for this action.']);
    }

    public function instApprove(Request $request)
    {
        if (! auth()->user()->has_request) {
            $approval = Approval::create(['user_id' => auth()->id()]);
        } else {
            $approval = auth()->user()->approval;
        }

        if ($approval->approved) {
            return redirect()->route('home')->withError(['Nope!', 'You\'re already approved']);
        }

        try {
            $approval->approve();
        } catch (\Exception $e) {
            Log::error(auth()->user()->full_name.' ('.auth()->user()->id.') insta-approval has failed with code: '.$e->getCode());

            return redirect()->route('home')->withError(['Uh oh...', 'Something didn\'t quite go right...']);
        }

        Log::info(auth()->user()->full_name.' ('.auth()->user()->id.') has insta-approved himself');

        return redirect()->route('home')->withSuccess(['Magic Wizard!', 'Did you just... approve yourself?']);
    }
}
