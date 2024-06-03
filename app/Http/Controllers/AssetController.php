<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Services\APIService;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AssetController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware(middleware: 'auth.api')
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = request()->query('page', 1);

        $respAdmin = ApiService::GetDataByEndPoint('admins/current');
        $respAssets = ApiService::GetDataByEndPoint('assets?page=' . $page);
        if ($respAdmin['statusCode'] != 200 || $respAssets['statusCode'] != 200) {
            Session::flush();
            return ApiService::unauthorizedRedirect();
        }
        $admin = $respAdmin['bodyContents']['data'];
        $assets = $respAssets['bodyContents'];

        $data = [
            'admin' => $admin,
            'assets' => $assets,
            'url' => "assets",
            'active' => "assets",
            'page' => $page,
        ];

        return view("admin.assets.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // dd(auth()->id());
        $respAdmin = ApiService::GetDataByEndPoint('admins/current');
        if ($respAdmin['statusCode'] != 200) {
            Session::flush();
            return ApiService::unauthorizedRedirect();
        }
        $admin = $respAdmin['bodyContents']['data'];

        $data = [
            'admin' => $admin,
            'url' => "create assets",
            'active' => "assets",
        ];
        return view('admin.assets.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAssetRequest $request)
    {
        $data = $request->validated();

        $files = [];
        if ($request->hasFile('image')) {
            $files['image'] = $request->file('image');
        }
        try {
            //code...
            $resp = APIService::PostDataByEndPoint('assets', $data, $files);
            $statusCode = $resp['statusCode'];
            // handle server error
            if ($statusCode >= 500) {
                $errors = ['errors' => ['message' => 'Server error occurred. Please try again later.']];
                throw new HttpException(
                    statusCode: $statusCode,
                    message: json_encode($errors)
                );
            }
            if ($statusCode >= 400 || $statusCode < 500) {
                $errors = $resp['bodyContents'];
                throw new HttpException(
                    statusCode: $statusCode,
                    message: $errors
                );
            }
            return redirect()->route('assets.index')->with('success', 'Asset created successfully');
        } catch (HttpException $e) {
            // handle http exception
            $errors = json_decode($e->getMessage(), true);
            $error_messages = $errors['errors'];
            return redirect()->back()->withErrors($error_messages)->withInput();
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->withErrors(['message' => 'An error occurred. Please try again later.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $respAdmin = ApiService::GetDataByEndPoint('admins/current');
        $respAsset = ApiService::GetDataByEndPoint("assets/" . $id);
        if ($respAdmin['statusCode'] != 200 || $respAsset['statusCode'] != 200) {
            Session::flush();
            return ApiService::unauthorizedRedirect();
        }
        $admin = $respAdmin['bodyContents']['data'];
        $asset = $respAsset['bodyContents']['data'];

        $data = [
            'admin' => $admin,
            'asset' => $asset,
            'url' => $asset['data']['name'],
            'active' => "assets",
            // 'assets' => $assets
        ];

        return view('admin.assets.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $respAdmin = ApiService::GetDataByEndPoint('admins/current');
        $respAsset = ApiService::GetDataByEndPoint("assets/" . $id);
        if ($respAdmin['statusCode'] != 200 || $respAsset['statusCode'] != 200) {
            Session::flush();
            return ApiService::unauthorizedRedirect();
        }
        $admin = $respAdmin['bodyContents']['data'];
        $asset = $respAsset['bodyContents'];

        $data = [
            'admin' => $admin,
            'asset' => $asset['data'],
            'url' => $asset['data']['name'],
            'active' => "assets",
            // 'assets' => $assets
        ];

        return view('admin.assets.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssetRequest $request, string $id)
    {
        $data = $request->validated();

        $files = [];
        if ($request->hasFile('image')) {
            $files['image'] = $request->file('image');
        }

        try {
            $resp = APIService::PutDataByEndPoint('assets/' . $id, $data, $files);
            dd($resp);
            $statusCode = $resp['statusCode'];
            if ($statusCode >= 500) {
                $errors = ['errors' => ['message' => 'Server error occurred. Please try again later.']];
                throw new HttpException(
                    statusCode: $statusCode,
                    message: json_encode($errors)
                );
            }

            // Handle client error
            if ($statusCode >= 400 && $statusCode < 500) {
                $errors = $resp['bodyContents'];
                throw new HttpException(
                    statusCode: $statusCode,
                    message: json_encode($errors)
                );
            }

            return redirect()->route('assets.index')->with('success', 'Asset updated successfully');
        } catch (HttpException $e) {
            dd($e->getMessage());
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->withErrors(['message' => 'An error occurred. Please try again later.'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $resp = APIService::DeleteDataByEndPoint('assets/' . $id);
            $statusCode = $resp['statusCode'];
            if ($statusCode >= 500) {
                $errors = ['errors' => ['message' => 'Server error occurred. Please try again later.']];
                throw new HttpException(
                    statusCode: $statusCode,
                    message: json_encode($errors)
                );
            }
            // Handle client error
            if ($statusCode >= 400 && $statusCode < 500) {
                $errors = $resp['bodyContents'];
                throw new HttpException(
                    statusCode: $statusCode,
                    message: json_encode($errors)
                );
            }
        } catch (HttpException $e) {
            dd($e->getMessage());
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->withErrors(['message' => 'An error occurred. Please try again later.'])->withInput();
        }
        return redirect()->route('assets.index')->with('success', 'Asset deleted successfully');
    }
}
