<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientError;
use GuzzleHttp\Exception\ServerError;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Exception\TransferException;

class AfvApiController extends Controller
{
    //////////////////////////////////////////////////////
    // This class/controller handles all requests to    //
    // the AFV Voice server. Used for approvals,        //
    // transceivers & positions.                        //
    //////////////////////////////////////////////////////

    private static $apiVersion = 1;
    private static $timeout = 5; // In seconds
    private static $debug = true;

    protected static $client; // \GuzzleHttp\Client instance
    protected static $bearer; // Token to authenticate to API

    /**
     * Gets authentication token.
     *
     * @param $impersonate Act as another user or not | Default true
     * @throws Exception
     */
    protected static function init($impersonate = true) // Can't use __constructor on static classes
    {
        $baseUri = sprintf('%sapi/v%d/', config('afv.api'), self::$apiVersion);
        $client = new \GuzzleHttp\Client([
            'base_uri' => $baseUri,
            'timeout' => self::$timeout,
        ]);

        self::$bearer = Cache::remember('bearerServer', now()->addHours(1), function () use ($client) {
            try {
                $response = $client->request('POST', 'auth', [
                    'json' => [
                        'Username' => config('afv.user'),
                        'Password' => config('afv.pass'),
                        'NetworkVersion' => config('afv.networkVersion'),
                    ],
                ]);
            } catch (TransferException | ClientError | ServerError $e) {
                throw new \Exception('Failed to authenticate (1.1)', $e->getResponse()->getStatusCode());
            }

            if ($response->getStatusCode() != 200) {
                throw new \Exception('Failed to authenticate (1.1)', $response->getStatusCode());
            }

            return (string) $response->getBody();
        });

        // Set global client with default authentication header
        self::$client = new \GuzzleHttp\Client([
            'base_uri' => $baseUri,
            'timeout' => self::$timeout,
            'headers' => ['Authorization' => 'Bearer '.self::$bearer],
        ]);

        if ($impersonate) {
            if(is_numeric($impersonate)){
                $cid = $impersonate;
            } else {
                $cid = auth()->user()->id;
            }
            self::impersonate($cid, $baseUri);
        }
    }

    /**
     * Enables the webserver to act as the given user.
     *
     * @param $cid User to impersonate
     * @throws Exception
     */
    private static function impersonate($cid, $baseUri)
    {
        self::$bearer = Cache::remember('bearer'.$cid, now()->addHours(1), function () use ($cid) {
            try {
                $response = self::$client->request('POST', 'auth/impersonate', ['json' => ['Username' => (string) $cid]]);
            } catch (TransferException | ClientError | ServerError $e) {
                throw new \Exception('Failed to authenticate (2.1)', $e->getResponse()->getStatusCode());
            }
            if ($response->getStatusCode() != 200) {
                throw new \Exception('Failed to authenticate (2.2)', $response->getStatusCode());
            }

            return (string) $response->getBody();
        });

        // Set global client with default authentication header
        self::$client = new \GuzzleHttp\Client([
            'base_uri' => $baseUri,
            'timeout' => self::$timeout,
            'headers' => ['Authorization' => 'Bearer '.self::$bearer],
        ]);
    }

    /**
     * Submits a GET Request.
     *
     * @param $endpoint Endpoint to submit the request to
     * @param $data Content to be sent with the request
     * @throws Exception
     * @return string
     */
    public static function doGET($endpoint, $data = [], $impersonate = true)
    {
        self::init($impersonate);

        try {
            $response = self::$client->request('GET', $endpoint, ['json' => $data]);
        } catch (TransferException | ClientError | ServerError $e) {
            throw new \Exception((string) $e->getResponse()->getReasonPhrase(), $e->getResponse()->getStatusCode());
        }
        if ($response->getStatusCode() != 200) {
            throw new \Exception($response->getBody(), $response->getStatusCode());
        }

        return (string) $response->getBody();
    }

    /**
     * Submits a POST Request.
     *
     * @param $endpoint Endpoint to submit the request to
     * @param $data Content to be sent with the request
     * @throws Exception
     * @return string
     */
    public static function doPOST($endpoint, $data = [], $impersonate = true)
    {
        self::init($impersonate);

        try {
            $response = self::$client->request('POST', $endpoint, ['json' => $data]);
        } catch (TransferException | ClientError | ServerError $e) {
            throw new \Exception((string) $e->getResponse()->getReasonPhrase(), $e->getResponse()->getStatusCode());
        }
        if ($response->getStatusCode() != 200) {
            throw new \Exception($response->getBody(), $response->getStatusCode());
        }

        return (string) $response->getBody();
    }

    /**
     * Submits a PUT Request.
     *
     * @param $endpoint Endpoint to submit the request to
     * @param $data Content to be sent with the request
     * @throws Exception
     * @return string
     */
    public static function doPUT($endpoint, $data = [], $impersonate = true)
    {
        self::init($impersonate);

        try {
            $response = self::$client->request('PUT', $endpoint, ['json' => $data]);
        } catch (TransferException | ClientError | ServerError $e) {
            throw new \Exception((string) $e->getResponse()->getReasonPhrase(), $e->getResponse()->getStatusCode());
        }
        if ($response->getStatusCode() != 200) {
            throw new \Exception($response->getBody(), $response->getStatusCode());
        }

        return (string) $response->getBody();
    }

    /**
     * Submits a DELETE Request.
     *
     * @param $endpoint Endpoint to submit the request to
     * @param $data Content to be sent with the request
     * @throws Exception
     * @return string
     */
    public static function doDELETE($endpoint, $data = [], $impersonate = true)
    {
        self::init($impersonate);

        try {
            $response = self::$client->request('DELETE', $endpoint, ['json' => $data]);
        } catch (TransferException | ClientError | ServerError $e) {
            throw new \Exception((string) $e->getResponse()->getReasonPhrase(), $e->getResponse()->getStatusCode());
        }
        if ($response->getStatusCode() != 200) {
            throw new \Exception($response->getBody(), $response->getStatusCode());
        }

        return (string) $response->getBody();
    }

    /**
     * Gets the permissions of the given user.
     *
     * @param $cid User to get the permissions of
     * @throws Exception
     * @return array
     */
    public static function getPermissions($cid)
    {
        $endpoint = 'users/'.$cid.'/permissions';
        $response = self::doGET($endpoint, [], false); // Initialize with the server token (not the authenticated user's)
        return json_decode($response);
    }
}
