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

class SuperUserController extends Controller
{
    public function index()
    {
        $page = request()->query('page', 1);

        $respAdmin = ApiService::GetDataByEndPoint('admins/current');
        $respAssets = ApiService::GetDataByEndPoint('admins/users');

        if ($respAdmin['statusCode'] != 200 || $respAssets['statusCode'] != 200) {
            Session::flush();
            return ApiService::unauthorizedRedirect();
        }
        $admin = $respAdmin['bodyContents']['data'];
        $assets = $respAssets['bodyContents'];

        $data = [
            'admin' => $admin,
            'assets' => $assets,
            'url' => "users",
            'active' => "users",
            'page' => $page
        ];
        return view('users.index', $data);
    }

    public function update(Request $request, $id)
    {
        $data = $request['type'];

        $files = [];
        if ($request->hasFile('image')) {
            $files['image'] = $request->file('image');
        }

        try {
            $resp = APIService::PutDataByEndPoint('users/' . $id, $data, $files);
            dd("test");
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

    public function destroy($id)
    {
        try {
            $resp = APIService::DeleteDataByEndPoint('admins/users/' . $id);
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
            return redirect()->route('users')->with('success', 'Admin deleted successfully');
        } catch (HttpException $e) {
            dd($e->getMessage());
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->withErrors(['message' => 'An error occurred. Please try again later.'])->withInput();
        }
    }
}
