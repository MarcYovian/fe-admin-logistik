<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AdminController extends Controller
{
    public function login()
    {
        if (Session::has('api_token')) {
            return redirect('/dashboard');
        }
        return view('login');
    }

    public function actionLogin(Request $request)
    {
        $data = [
            'username' => $request['username'],
            'password' => $request['password'],
        ];

        $client = new Client([
            'base_uri' => 'http://logistik-api.test/api/v1/',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        try {
            $response = $client->post('admins/login', [
                'json' => $data,
                'http_errors' => false,
            ]);
            // dd($response->getStatusCode());

            // handle server error
            if ($response->getStatusCode() >= 500) {
                $errors = ['errors' => ['message' => 'Server error occurred. Please try again later.']];
                throw new HttpException(
                    statusCode: $response->getStatusCode(),
                    message: json_encode($errors)
                );
            }
            // handle client error
            if ($response->getStatusCode() >= 400 && $response->getStatusCode() < 500) {
                $errors = json_decode($response->getBody(), true);
                throw new HttpException(statusCode: $response->getStatusCode(), message: json_encode($errors));
            }

            $data = json_decode($response->getBody(), true)['data'];
            Session::put('api_token', $data['token']);
            return redirect('/dashboard');
        } catch (HttpException $e) {
            // handle Http Errors
            $errors = json_decode($e->getMessage(), true);
            $error_messages = $errors['errors'];
            return redirect()->back()->withErrors($error_messages)->withInput();
        } catch (\Exception $e) {
            // Handle  errors
            return redirect()->back()->withErrors(['Network error occurred. Please check your internet connection and try again.'])->withInput();
        }
    }

    public function logout()
    {
        if (!Session::has('api_token')) {
            return redirect('/login')->withErrors(['message' => 'Unauthorized']);
        }

        $token = Session::get('api_token');
        // dd($token);
        $url = "http://logistik-api.test/api/v1/";
        $headers = [
            "Authorization" => $token,
        ];

        try {
            $response = Http::withHeaders($headers)->delete($url . "admins/logout");
            $data = $response->json();
            // dd($data);
            if (!$data['data']) {
                dd("Error Logout");
            }
            Session::flush();
            return redirect()->route('login');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
