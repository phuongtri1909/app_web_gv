<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\ZaloApiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckCodeZalo
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
        $code = $request->query('code');

        if (!$code) {
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
        }


        $codeVerifier = session('code_verifier');

        if (!$codeVerifier) {
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
        }

        // Đổi code lấy access_token từ Zalo
        $response = Http::withHeaders([
            'secret_key' => env('ZALO_SECRET_KEY'),
        ])->asForm()->post('https://oauth.zaloapp.com/v4/access_token', [
            'app_id' => env('ZALO_APP_ID'),
            'code' => $code,
            'code_verifier' => $codeVerifier,
            'grant_type' => 'authorization_code',
        ]);

        if (isset($response['error']) && $response['error'] !== 0) {
            dd($response->json());
            return abort(401);
        }

        dd($response->json());


        return $next($request);
    }
}
