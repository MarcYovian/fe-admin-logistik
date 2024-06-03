<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckAPIToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah token ada dalam sesi
        // dd(Session::has('api_token'));
        if (!Session::has('api_token')) {
            // Redirect ke halaman login jika tidak ada token
            return redirect('/login')->withErrors(['message' => 'Unauthorized']);
        }
        // Lanjutkan ke proses selanjutnya jika token tersedia
        return $next($request);
    }
}
