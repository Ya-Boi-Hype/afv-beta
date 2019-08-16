<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApprovalController_BAK extends Controller
{
    /**
     * Approve a new user.
     *
     * @param $cid CID to approve
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function approve($cid, Request $request)
    {
        try {
            $approval = Approval::pending()->where('user_id', $cid)->firstOrFail(); // See if user has a pending approval
        } catch (ModelNotFoundException $e) {
            if (Approval::where('user_id', $cid)->exists()) {
                return redirect()->back()->withError('User is already approved')->withApprove('');
            } else {
                return redirect()->back()->withError('User has not submitted a request to join the beta')->withApprove('');
            }
        }

        $data = ['Username' => (string) $cid, 'Enabled' => true];

        try {
            AfvApiController::doPUT('users/enabled', [$data]);
            $approval->setAsApproved();
            return redirect()->back()->withSuccess('User successfully approved!')->withApprove('');
        } catch (Exception $e) {
            return redirect()->back()->withError('AFV Server replied with '.$e->getMessage())->withApprove('');
        }
    }

    /**
     * Revoke a user's approval.
     *
     * @param $cid CID to revoke
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function revoke($cid, Request $request)
    {
        try {
            $approval = Approval::approved()->where('user_id', $cid)->firstOrFail(); // User approved?
        } catch (ModelNotFoundException $e) {
            if (Approval::where('user_id', $cid)->exists()) { // User pending?
                return redirect()->back()->withError('Approval is already pending');
            } else {
                return redirect()->back()->withError('User has not submitted a request to join the beta'); // No requests
            }
        }

        $data = ['Username' => (string) $cid, 'Enabled' => false];
        try {
            AfvApiController::doPUT('users/enabled', [$data]);
        } catch (Exception $e) {
            return redirect()->back()->withError($e->getcode().' - '.$e->getMessage())->withApprove('');
        }

        $approval->setAsPending();

        return redirect()->back()->withSuccess('Approval revoked!');
    }

    /**
     * Approves qty random users.
     *
     * @param $qty Quantity of random users to approve
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function random(Request $request)
    {
        $request->validate([
            'qty' => 'required|numeric|min:1',
        ]);

        $qty = $request->input('qty');
        $pending = Approval::pending()->take($qty)->inRandomOrder()->get();
        if (! $pending->count()) { // No approvals pending
            return redirect()->back()->withError('No pending approvals')->withApprove('');
        }

        $cids = $pending->pluck('user_id');
        $data = [];
        foreach ($cids as $cid) {
            $data[] = ['Username' => (string) $cid, 'Enabled' => true];
        }

        try {
            AfvApiController::doPUT('users/enabled', $data);
        } catch (Exception $e) {
            return redirect()->back()->withError($e->getcode().' - '.$e->getMessage())->withApprove('');
        }

        $approval->setAsApproved();

        return redirect()->back()->withSuccess('Users successfully approved!')->withApprove('');
    }

    public function sync()
    {
        $data = [];
        $approved = Approval::approved()->pluck('user_id');
        foreach ($approved as $cid) {
            $data[] = ['Username' => (string) $cid, 'Enabled' => true];
        }

        try {
            AfvApiController::doPUT('users/enabled', $data);
        } catch (Exception $e) {
            return redirect()->back()->withError($e->getcode().' - '.$e->getMessage());
        }

        return redirect()->back()->withSuccess('Users successfully submitted!');
    }
}
