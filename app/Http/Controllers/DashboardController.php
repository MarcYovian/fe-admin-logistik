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
    private APIService $ApiService;
    public function __construct(APIService $ApiService)
    {
        $this->ApiService = $ApiService;
    }
    public function index()
    {
        // dd(Session::all());
        if (!$this->ApiService->hasApiToken()) {
            return $this->ApiService->unauthorizedRedirect();
        }
        $token = Session::get('api_token');
        $apiUrl = 'http://logistik-api.test/api/v1/';
        $header = $this->ApiService->getApiHeaders($token);

        $admin = $this->ApiService->makeApiRequest($apiUrl, "admins/current", $header);
        if ($admin == null) {
            Session::flush();
            return $this->ApiService->unauthorizedRedirect();
        }

        // $assets = $this->makeApiRequest($apiUrl, "assets", $header);

        $data = [
            'admin' => $admin['data'],
            'url' => "dashboard",
            // 'assets' => $assets
        ];

        return view('admin.dashboard', $data);
    }
}
