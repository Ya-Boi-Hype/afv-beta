<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AfvApiController extends Controller
{
    //////////////////////////////////////////////////////
    // This class/controller handles all requests to    //
    // the AFV Voice server. Used for approvals,        //
    // transceivers & positions.                        //
    //////////////////////////////////////////////////////

    protected static $base; // Base API URL
    protected static $bearer; // Token to authenticate to API

    /**
     * Gets authentication token.
     *
     * @return true on success
     */
    protected static function init()
    {
        self::$base = config('afv.api'); // Sets base URL
        $url = self::$base.'api/v1/auth'; // Endpoint to be accessed
        $content = json_encode([
            'Username' => config('afv.user'),
            'Password' => config('afv.pass'),
            'NetworkVersion' => config('afv.networkVersion'),
        ]);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1); // POST Request
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return the actual content of response
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: '.strlen($content),
        ]);
        // Send the request
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($result) {
            self::$bearer = $result;

            return true;
        }
    }

    /**
     * Submits a PUT Request.
     *
     * @param $endpoint Endpoint to submit the request to
     * @param $data Content to be sent with the request
     * @return true or array
     */
    public static function doPUT($endpoint, $data = [])
    {
        if (! self::init()) {
            return 'AFV Authentication Failed';
        }
        $url = self::$base.$endpoint;
        $content = json_encode($data);
        $ch = curl_init(); // Start cURL
        curl_setopt($ch, CURLOPT_URL, $url); // DESTINATION
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); // TYPE
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content); // CONTENT
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return the actual content of response
        curl_setopt($ch, CURLOPT_HTTPHEADER, [ // HEADERS
            'Content-Type: application/json',
            'Content-Length: '.strlen($content),
            'Authorization: Bearer '.self::$bearer,
        ]);
        $result = curl_exec($ch); // Send the request
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get response code
        curl_close($ch); // End cURL

        return $httpCode;
    }

    /**
     * Submits a POST Request.
     *
     * @param $endpoint Endpoint to submit the request to
     * @param $data Content to be sent with the request
     * @return true or array
     */
    public static function doPOST($endpoint, $data = [])
    {
        if (! self::init()) {
            return 'AFV Authentication Failed';
        }
        $url = self::$base.$endpoint;
        $content = json_encode($data);
        $ch = curl_init(); // Start cURL
        curl_setopt($ch, CURLOPT_URL, $url); // DESTINATION
        curl_setopt($ch, CURLOPT_POST, 1); // POST Request
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return the actual content of response
        curl_setopt($ch, CURLOPT_HTTPHEADER, [ // HEADERS
            'Content-Type: application/json',
            'Content-Length: '.strlen($content),
            'Authorization: Bearer '.self::$bearer,
        ]);
        $result = curl_exec($ch); // Send the request
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get response code
        curl_close($ch); // End cURL

        if ($httpCode != 200) {
            return false;
        } else {
            return $result;
        }
    }
}
