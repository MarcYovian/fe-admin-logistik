<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Services\APIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\LoginAdminRequest;
use GuzzleHttp\Exception\ClientException;
use App\Http\Requests\RegisterAdminRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AdminController extends Controller
{
    public function login()
    {
        if (Session::has('api_token')) {
            return redirect('/dashboard');
        }
        return view('login', [
            'title' => 'SSC | Login'
        ]);
    }
    public function register()
    {
        if (Session::has('api_token')) {
            return redirect('/dashboard');
        }
        return view('register', [
            'title' => 'SSC | Register'
        ]);
    }

    public function actionLogin(LoginAdminRequest $request)
    {
        $data = $request->validated();

        try {
            $response = APIService::PostDataByEndPoint('admins/login', $data);
            // dd($response['data']);
            $statusCode = $response['statusCode'];

            // handle server error
            if ($statusCode >= 500) {
                $errors = ['errors' => ['message' => 'Server error occurred. Please try again later.']];
                throw new HttpException(
                    statusCode: $statusCode,
                    message: json_encode($errors)
                );
            }

            $contents = $response['bodyContents'];
            // dd($contents);
            // handle client error
            if ($statusCode >= 400 && $statusCode < 500) {
                $errors = $contents;
                // dd($errors);
                throw new HttpException(statusCode: $statusCode, message: json_encode($errors));
            }

            $data = $contents['data'];
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

    public function actionRegister(RegisterAdminRequest $request)
    {
        $data = $request->validated();

        try {
            $response = APIService::PostDataByEndPoint('admins/register', $data);
            // dd($response['data']);
            $statusCode = $response['statusCode'];

            // handle server error
            if ($statusCode >= 500) {
                $errors = ['errors' => ['message' => 'Server error occurred. Please try again later.']];
                throw new HttpException(
                    statusCode: $statusCode,
                    message: json_encode($errors)
                );
            }

            $contents = $response['bodyContents'];
            // dd($contents);
            // handle client error
            if ($statusCode >= 400 && $statusCode < 500) {
                $errors = $contents;
                // dd($errors);
                throw new HttpException(statusCode: $statusCode, message: json_encode($errors));
            }

            $data = $contents['data'];
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
        try {
            $response = APIService::DeleteDataByEndPoint('admins/logout');
            // dd($response);
            // if ($response['data']) {
            //     dd("Error Logout");
            // }
            Auth::logout();
            Session::forget('api_token');
            return redirect()->route('login');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
