<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Approval;
use Illuminate\Http\Request;

class AfvApiController extends Controller
{
    //////////////////////////////////////////////////////
    // This class/controller handles all approvals      //
    // in the AFV Auth server. It can do the following: //
    //      - Approve a CID                             //
    //      - Send all approved CIDs                    //
    //      - Revoke a CID                              //
    //////////////////////////////////////////////////////

    protected static $base; // Base API URL
    protected static $bearer; // Token to authenticate to API

    /**
     * Initializes Parameters and gets authenttication token.
     *
     * @return false on error
     */
    public function __construct()
    {
        static::$base = config('afv.api'); // Sets base URL
        $url = self::$base.'api/v1/auth'; // Endpoint to be accessed
        $data = json_encode([
            'Username' => config('afv.user'),
            'Password' => config('afv.pass'),
            'NetworkVersion' => config('afv.networkVersion'),
        ]);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1); // POST Request
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: '.strlen($data),
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Send the request
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode != 200) {
            die('Error Authenticating');
        }
        static::$bearer = $result;
    }

    /**
     * Submits a PUT Request.
     *
     * @param $data Content to be sent with the request
     * @return true or array
     */
    public static function doPUT($endpoint, $data = [])
    {
        $url = self::$base.$endpoint;
        $content = json_encode($data);
        $ch = curl_init(); // Start cURL
        curl_setopt($ch, CURLOPT_URL, $url); // DESTINATION
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); // TYPE
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content); // CONTENT
        curl_setopt($ch, CURLOPT_HTTPHEADER, [ // HEADERS
            'Content-Type: application/json',
            'Content-Length: '.strlen($content),
            'Authorization: Bearer '.self::$bearer,
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); // Send the request
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get response code
        curl_close($ch); // End cURL

        die($result);
    }

    /**
     * Approve a new user.
     *
     * @param $cid CID to approve
     * @return true or array
     */
    public static function approveCIDs($cids)
    {
        $data = [];
        foreach ($cids as $cid) {
            $data[] = ['Username' => (string) $cid, 'Enabled' => true];
        }

        return self::doPUT('api/v1/users/enabled', $data);
    }

    /**
     * Sends all approved CIDs - SYNCs DBs.
     *
     * @return true or array
     */
    public static function syncApprovals()
    {
        $data = [];

        $approved = Approval::approved()->pluck('user_id');
        foreach ($approved as $cid) {
            $data[] = ['Username' => (string) $cid, 'Enabled' => true];
        }

        return self::doPUT('api/v1/users/enabled', $data);
    }

    /**
     * Revoke a user's beta access.
     *
     * @param $cid CID to revoke
     * @return true or array
     */
    public static function revokeCIDs($cids)
    {
        $data = [];
        foreach ($cids as $cid) {
            $data[] = ['Username' => (string) $cid, 'Enabled' => false];
        }

        return self::doPUT('api/v1/users/enabled', $data);
    }
}
