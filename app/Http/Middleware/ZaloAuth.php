<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\ZaloApiService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class ZaloAuth
{

    protected $zaloApiService;

    public function __construct(ZaloApiService $zaloApiService)
    {
        $this->zaloApiService = $zaloApiService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            $accessToken = $request->header('access-token');
        } else {
            if (Session::has('access_token')) {
                $accessToken = Session::get('access_token');
            }
        }


        if (!isset($accessToken) || !$accessToken) {
            return $this->unauthorizedResponse($request);
        }

        $get_info = $this->zaloApiService->getProfile($accessToken);

        if (isset($get_info['error']) && $get_info['error'] !== 0) {
            return $this->unauthorizedResponse($request);
        }

        $request->merge(['get_info' => $get_info]);
        $request->merge(['customer_id' => $get_info['id']]);
        return $next($request);
    }

    protected function unauthorizedResponse(Request $request)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'error' => 'Unauthorized',
                'status' => 401,
            ], 401);
        } else {
            try {
                // Bước 1: Tạo code_verifier
                $codeVerifier = Str::random(43);

                // Bước 2: Tạo code_challenge
                $codeChallenge = rtrim(strtr(base64_encode(hash('sha256', $codeVerifier, true)), '+/', '-_'), '=');

                // Bước 3: Lưu code_verifier vào session
                session(['code_verifier' => $codeVerifier]);

                $state = Str::random(32); // Tạo chuỗi random 32 ký tự
                session(['oauth_state' => $state]);

                $appId = env('ZALO_APP_ID');
                $redirectUri = route('p17.auth.zalo.client');
                $codeChallenge = $codeChallenge;
                $state = $state; // Thay thế bằng giá trị thực tế

                $authUrl = "https://oauth.zaloapp.com/v4/permission?app_id={$appId}&redirect_uri={$redirectUri}&code_challenge={$codeChallenge}&state={$state}";

                return redirect($authUrl);
            } catch (\Exception $e) {
                return abort(401);
            }
        }
    }
}
