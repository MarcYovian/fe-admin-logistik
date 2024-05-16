<?php

namespace App\Http\Controllers;

use App\Services\APIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AssetController extends Controller
{
    private APIService $apiService;
    private String $apiUrl = 'http://logistik-api.test/api/v1/';
    public function __construct(APIService $ApiService)
    {
        $this->apiService = $ApiService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = request()->query('page', 1);

        if (!$this->apiService->hasApiToken()) {
            return $this->apiService->unauthorizedRedirect();
        }
        $token = Session::get('api_token');
        $header = $this->apiService->getApiHeaders($token);
        $admin = $this->apiService->makeApiRequest($this->apiUrl, "admins/current", $header);
        if ($admin == null) {
            Session::flush();
            return $this->apiService->unauthorizedRedirect();
        }
        $assets = $this->apiService->makeApiRequest($this->apiUrl, "assets?page=" . $page, $header);


        $data = [
            'admin' => $admin['data'],
            'assets' => $assets,
            'url' => "assets",
            'page' => $page,
            // 'assets' => $assets
        ];

        return view("admin.assets.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!$this->apiService->hasApiToken()) {
            return $this->apiService->unauthorizedRedirect();
        }
        $token = Session::get('api_token');
        $header = $this->apiService->getApiHeaders($token);
        $admin = $this->apiService->makeApiRequest($this->apiUrl, "admins/current", $header);
        if ($admin == null) {
            Session::flush();
            return $this->apiService->unauthorizedRedirect();
        }
        $asset = $this->apiService->makeApiRequest($this->apiUrl, "assets/" . $id, $header);

        $data = [
            'admin' => $admin['data'],
            'asset' => $asset['data'],
            'url' => $asset['data']['name'],
            // 'assets' => $assets
        ];

        return view('admin.assets.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
