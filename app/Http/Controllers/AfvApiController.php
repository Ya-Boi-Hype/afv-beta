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

    private static $api = 'api/v1/';
    protected static $base; // Base URL
    protected static $bearer; // Token to authenticate to API

    /**
     * Gets authentication token.
     *
     * @throws Exception
     */
    protected static function init() // Can't use __constructor on static classes
    {
        self::$base = config('afv.api') . self::$api; // Sets base API URL
        $url = self::$base.'auth'; // Endpoint to be accessed
        $content = json_encode([
            'Username' => config('afv.user'),
            'Password' => config('afv.pass'),
            'NetworkVersion' => config('afv.networkVersion'),
        ]);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true); // POST Request
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the actual content of response
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: '.strlen($content),
        ]);
        // Send the request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 200) {
            self::$bearer = $response;
            self::actAs(auth()->user()->id);
        } else {
            throw new \Exception('Failed to authenticate (1)', $httpCode);
        }
    }

    /**
     * Enables the webserver to act as the given user.
     *
     * @param $cid User to impersonate
     * @throws Exception
     */
    private static function actAs($cid)
    {
        // $cid = (CID to act as for testing);
        $url = self::$base.'auth/impersonate';
        $content = json_encode(['Username' => (string) $cid]);
        $ch = curl_init(); // Start cURL
        curl_setopt($ch, CURLOPT_URL, $url); // DESTINATION
        curl_setopt($ch, CURLOPT_POST, true); // POST Request
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content); // CONTENT
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the actual content of response
        curl_setopt($ch, CURLOPT_HTTPHEADER, [ // HEADERS
            'Content-Type: application/json',
            'Content-Length: '.strlen($content),
            'Authorization: Bearer '.self::$bearer,
        ]);
        $response = curl_exec($ch); // Send the request
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get response code
        curl_close($ch); // End cURL

        if ($httpCode != 200) {
            throw new \Exception('Failed to authenticate (2)', $httpCode);
        } else {
            self::$bearer = $response;
        }
    }

    /**
     * Submits a GET Request.
     *
     * @param $endpoint Endpoint to submit the request to
     * @param $data Content to be sent with the request
     * @throws Exception
     * @return string
     */
    public static function doGET($endpoint)
    {
        self::init();
        $url = self::$base.$endpoint;
        $ch = curl_init(); // Start cURL
        curl_setopt($ch, CURLOPT_URL, $url); // DESTINATION
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the actual content of response
        curl_setopt($ch, CURLOPT_HTTPHEADER, [ // HEADERS
            'Authorization: Bearer '.self::$bearer,
        ]);
        $response = curl_exec($ch); // Send the request
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get response code
        curl_close($ch); // End cURL

        if ($httpCode == 200) {
            return $response;
        } else {
            throw new \Exception($response, $httpCode);
        }
    }

    /**
     * Submits a POST Request.
     *
     * @param $endpoint Endpoint to submit the request to
     * @param $data Content to be sent with the request
     * @throws Exception
     * @return string
     */
    public static function doPOST($endpoint, $data = [])
    {
        self::init();
        $url = self::$base.$endpoint;
        $content = json_encode($data);
        $ch = curl_init(); // Start cURL
        curl_setopt($ch, CURLOPT_URL, $url); // DESTINATION
        curl_setopt($ch, CURLOPT_POST, true); // POST Request
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the actual content of response
        curl_setopt($ch, CURLOPT_HTTPHEADER, [ // HEADERS
            'Content-Type: application/json',
            'Content-Length: '.strlen($content),
            'Authorization: Bearer '.self::$bearer,
        ]);
        $response = curl_exec($ch); // Send the request
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get response code
        curl_close($ch); // End cURL

        if ($httpCode == 200) {
            return $response;
        } else {
            throw new \Exception($response, $httpCode);
        }
    }

    /**
     * Submits a PUT Request.
     *
     * @param $endpoint Endpoint to submit the request to
     * @param $data Content to be sent with the request
     * @throws Exception
     * @return string
     */
    public static function doPUT($endpoint, $data = [])
    {
        self::init();
        $url = self::$base.$endpoint;
        $content = json_encode($data);
        $ch = curl_init(); // Start cURL
        curl_setopt($ch, CURLOPT_URL, $url); // DESTINATION
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); // TYPE
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content); // CONTENT
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the actual content of response
        curl_setopt($ch, CURLOPT_HTTPHEADER, [ // HEADERS
            'Content-Type: application/json',
            'Content-Length: '.strlen($content),
            'Authorization: Bearer '.self::$bearer,
        ]);
        $response = curl_exec($ch); // Send the request
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get response code
        curl_close($ch); // End cURL

        if ($httpCode == 200) {
            return $response;
        } else {
            throw new \Exception($response, $httpCode);
        }
    }

    /**
     * Submits a DELETE Request.
     *
     * @param $endpoint Endpoint to submit the request to
     * @param $data Content to be sent with the request
     * @throws Exception
     * @return string
     */
    public static function doDELETE($endpoint, $data = [])
    {
        self::init();
        $url = self::$base.$endpoint;
        $content = json_encode($data);
        $ch = curl_init(); // Start cURL
        curl_setopt($ch, CURLOPT_URL, $url); // DESTINATION
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE'); // TYPE
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content); // CONTENT
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the actual content of response
        curl_setopt($ch, CURLOPT_HTTPHEADER, [ // HEADERS
            'Content-Type: application/json',
            'Content-Length: '.strlen($content),
            'Authorization: Bearer '.self::$bearer,
        ]);
        $response = curl_exec($ch); // Send the request
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get response code
        curl_close($ch); // End cURL

        if ($httpCode == 200) {
            return $response;
        } else {
            throw new \Exception($response, $httpCode);
        }
    }
}
