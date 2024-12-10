<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class ZaloAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $accessToken = $request->header('Authorization');

        if (!$accessToken) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Xác thực accessToken với Zalo API
        $response = Http::withHeaders([
            'Authorization' => $accessToken,
        ])->get('https://graph.zalo.me/v2.0/me?fields=id,name');

        if ($response->failed()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Lưu thông tin người dùng vào request
        $request->merge(['zalo_user' => $response->json()]);

        return $next($request);
    }
}
