<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use Illuminate\Http\Request;

class ApprovalController extends Controller
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
        $approval = Approval::pending()->where('user_id', $cid); // See if user has a pending approval

        if ($approval == null) { // If user hasn't got a pending approval
             $approval = Approval::where('user_id', $cid); // See if user has any approval (pending or not)
             if (! $approval) {
                 return redirect()->back()->withError('User not found.')->withApprove('');
             } // User not found
            else {
                return redirect()->back()->withError('User is already approved.')->withApprove('');
            } // Can't approve an alreay approved user
        } else {
            $approval = $approval->first();
        } // Get the approval

        $afvAuth = AfvApiController::approveCIDs([$cid]);
        if ($afvAuth == 200) {
            $approval->setAsApproved();
            return redirect()->back()->withSuccess('User successfully approved!')->withApprove('');
        } else {
            return redirect()->back()->withError($afvAuth)->withApprove('');
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
        $approval = Approval::approved()->where('user_id', $cid); // See if user is approved

        if ($approval == null) { // If user is not approved
             $approval = Approval::where('user_id', $cid); // See if it exists
             if (! $approval) {
                 return redirect()->back()->withError('User not found.');
             } // User not found
            else {
                return redirect()->back()->withError('User is not approved.');
            } // Can't revoke a non-approved user
        } else {
            $approval = $approval->first();
        } // Get the approval

        $afvAuth = AfvApiController::revokeCIDs([$cid]);
        if ($afvAuth == 200) {
            $approval->setAsPending();
            return redirect()->back()->withSuccess('User approval revoked!');
        } else {
            return redirect()->back()->withError($afvAuth);
        }

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
        $qty = $request->input('qty', 0);
        if (! $qty) {
            return redirect()->back()->withApprove('');
        }

        $pending = Approval::pending()->take($request->input('qty', 0))->inRandomOrder()->get();

        // No approvals pending
        if (! $pending->count()) {
            return redirect()->back()->withError('No pending approvals')->withApprove('');
        }

        $cids = array();
        foreach ($pending as $approval) {
            if (! $approval->user) {
                continue;
            } else {
                $cids[] = $approval->user->id;
            }
        }

        $afvAuth = AfvApiController::approveCIDs($cids);
        if ($afvAuth == 200) {
            $approval->setAsApproved();
            return redirect()->back()->withSuccess('Users successfully approved!')->withApprove('');
        } else {
            return redirect()->back()->withError($afvAuth)->withApprove('');
        }
    }

    public function sync()
    {
        $afvAuth = AfvApiController::syncApprovals();
        if ($afvAuth == 200) {
            return redirect()->back()->withSuccess('Users successfully submitted!');
        } else {
            return redirect()->back()->withError($afvAuth);
        }
    }
}
