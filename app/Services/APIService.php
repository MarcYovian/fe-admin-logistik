<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Exception\HttpException;

class APIService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Check if API token is present in session.
     *
     * @return bool
     */
    public function hasApiToken(): bool
    {
        return Session::has('api_token');
    }

    /**
     * Redirect to login page with unauthorized error.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unauthorizedRedirect(): \Illuminate\Http\RedirectResponse
    {
        return redirect('/login')->withErrors(['message' => 'Unauthorized']);
    }

    /**
     * Get API headers with authorization token.
     *
     * @param string $token
     * @return array
     */

    public function getApiHeaders($token): array
    {
        return [
            'Authorization' => $token,
        ];
    }

    /**
     * Make an API request with error handling.
     * @param string $url
     * @param string $endpoint
     * @param array $header
     * @return mixed
     */
    public function makeApiRequest($url, $endpoint, $headers)
    {
        try {
            $response = Http::withHeaders($headers)->get($url . $endpoint);
            $response->throw(); // Throw an exception for 4xx and 5xx status codes
            return $response->json();
        } catch (\Exception $e) {
            //throw $e;
            $this->handleApiError($e);
        }
    }

    /**
     * Handle API request errors.
     * @param \Exception $e
     */
    public function HandleApiError($e)
    {
        $errors = json_encode($e->getMessage(), true);
        if ($e instanceof HttpException && $e->getStatusCode() >= 400 && $e->getStatusCode() < 500) {
            // Log out user for 4xx errors
            Session::flush();
            return redirect()->route('login');
        } else {
            // Log or display error message for other exceptions
            Log::error($e->getMessage());
            // dd($errors); // Remove this line in production
        }
    }
}
