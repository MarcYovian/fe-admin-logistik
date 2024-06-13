<?php

namespace App\Services;

use App\Helpers\EndPoints;
use Google\Service\Games\EndPoint;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Exception\HttpException;

class APIService
{
    /**
     * Check if API token is present in session.
     *
     * @return bool
     */
    public static function hasApiToken(): bool
    {
        return Session::has('api_token');
    }

    /**
     * Redirect to login page with unauthorized error.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function unauthorizedRedirect(): \Illuminate\Http\RedirectResponse
    {
        return redirect('/login')->withErrors(['message' => 'Unauthorized']);
    }

    public static function getHttpHeaders()
    {
        $bearerToken = Session::get('api_token');
        $headers = [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $bearerToken,
            ],
            'http_errors' => false,
        ];
        return $headers;
    }

    public static function GetDataByEndPoint($endPoint)
    {
        $baseApiUrl = EndPoints::getBaseUrl();
        $url = $baseApiUrl . $endPoint;
        $client = new Client(self::getHttpHeaders());
        $response = $client->get($url, ['verify' => false]);
        $resp['statusCode'] = $response->getStatusCode();
        $resp['bodyContents'] =
            json_decode($response->getBody()->getContents(), true);
        // dd($resp);
        return $resp;
    }

    public static function PostMultiPartData($endPoint, $body, $files = [])
    {
        $baseApiUrl = EndPoints::getBaseUrl();
        $url = $baseApiUrl . $endPoint;
        $client = new Client(self::getHttpHeaders());
        $multipart = [];

        foreach ($body as $name => $contents) {
            if ($name != 'image') {
                $multipart[] = [
                    'name' => $name,
                    'contents' => $contents,
                ];
            }
        }

        foreach ($files as $name => $file) {
            $multipart[] = [
                'name' => $name,
                'contents' => fopen($file, 'r'),
                'filename' => $file->getClientOriginalName(),
            ];
        }

        $request = $client->post($url, [
            'multipart' => $multipart,
            'verify' => false
        ]);

        $response['statusCode'] = $request->getStatusCode();
        $response['bodyContents'] = json_decode($request->getBody()->getContents(), true);
        return $response;
    }
    public static function postJsonData($endPoint, $data)
    {
        $baseApiUrl = EndPoints::getBaseUrl();
        $url = $baseApiUrl . $endPoint;
        $client = new Client(self::getHttpHeaders());

        try {
            $response = $client->post($url, [
                'json' => $data,
                'verify' => false
            ]);

            return [
                'statusCode' => $response->getStatusCode(),
                'bodyContents' => json_decode($response->getBody()->getContents(), true)
            ];
        } catch (\Exception $e) {
            return [
                'statusCode' => 500,
                'bodyContents' => ['error' => $e->getMessage()]
            ];
        }
    }

    public static function postDataByEndPoint($endPoint, $body, $files = [])
    {
        if (empty($files)) {
            return self::postJsonData($endPoint, $body);
        } else {
            return self::postMultipartData($endPoint, $body, $files);
        }
    }
    public static function PutDataByEndPoint($endPoint, $body, $files = [])
    {
        $baseApiUrl = EndPoints::getBaseUrl();
        $url = $baseApiUrl . $endPoint;
        $client = new Client(self::getHttpHeaders());
        $multipart = [];

        foreach ($body as $name => $contents) {
            if ($name != 'image') {
                $multipart[] = [
                    'name' => $name,
                    'contents' => $contents,
                ];
            }
        }

        foreach ($files as $name => $file) {
            $multipart[] = [
                'name' => $name,
                'contents' => fopen($file, 'r'),
                'filename' => $file->getClientOriginalName(),
            ];
        }

        $request = $client->put($url, [
            'multipart' => $multipart,
            'verify' => false
        ]);
        dd($request);

        $response['statusCode'] = $request->getStatusCode();
        $response['bodyContents'] = json_decode($request->getBody()->getContents(), true);
        return $response;
    }
    public static function DeleteDataByEndPoint($endPoint, $body = [])
    {
        $baseApiUrl = EndPoints::getBaseUrl();
        $url = $baseApiUrl . $endPoint;
        $client = new Client(self::getHttpHeaders());
        $request = $client->delete($url, ['body' => json_encode($body), 'verify' => false]);
        $response['statusCode'] = $request->getStatusCode();
        $response['bodyContents'] = json_decode($request->getBody()->getContents(), true);
        return $response;
    }
}
