<?php

namespace App\Http\Controllers;

use App\Services\APIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DashboardController extends Controller
{
    public function index()
    {
        // dd(Session::all());
        $response = ApiService::GetDataByEndPoint("admins/current");
        // dd($response);
        if ($response['statusCode'] != 200) {
            Session::flush();
            return ApiService::unauthorizedRedirect();
        }
        $admin = $response['bodyContents']['data'];

        // $assets = $this->makeApiRequest($apiUrl, "assets", $header);

        $data = [
            'admin' => $admin,
            'url' => "dashboard",
            'active' => "dashboard",
            // 'assets' => $assets
        ];

        return view('admin.dashboard', $data);
    }
}
