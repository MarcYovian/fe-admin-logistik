<?php

namespace App\Http\Middleware;

use App\Services\APIService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAssetOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $assetId = $request->route('id');
        $respAdmin = APIService::GetDataByEndPoint('admins/current');
        $respAsset = ApiService::GetDataByEndPoint("assets/" . $assetId);

        if ($respAdmin['statusCode'] != 200 || $respAsset['statusCode'] != 200) {
            return redirect()->route('assets.index')->with('failed', 'Asset not found or unauthorized access');
        }
        $admin = $respAdmin['bodyContents']['data'];
        $asset = $respAsset['bodyContents']['data'];
        if ($asset['admin']['id'] != $admin['id']) {
            return redirect()->route('assets.index')->with('failed', 'unauthorized access');
        }
        return $next($request);
    }
}
