<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Exceptions\HttpResponseException;

class ZaloApiService
{

    public function updateProfile($get_info,$get_phone = null)
    {
        $customer = Customer::where('id', $get_info['id'])->first();

        if (!$customer) {
            $customer = new Customer();
            $customer->id = $get_info['id'];
            $customer->customerName = $get_info['name'];

            if (isset($get_info['picture']['data']['url'])) {
                $customer->imageUrl = $get_info['picture']['data']['url'];
            }
            if (!empty($get_phone['data']['number'])) {
                $customer->phone = $get_phone['data']['number'];
            }
            $customer->save();
        } else {
            $customer->customerName = $get_info['name'];

            if (!empty($get_phone['data']['number'])) {
                $customer->phone = $get_phone['data']['number'];
            }

            if (isset($get_info['picture']['data']['url'])) {
                $customer->imageUrl = $get_info['picture']['data']['url'];
            }
            $customer->save();
        }

        return $customer;
    }

    public function getProfile($accessToken)
    {
        try {
            $response = Http::withHeaders([
                'access_token' => $accessToken,
            ])->get('https://graph.zalo.me/v2.0/me', [
                'fields' => 'id,name,picture',
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error("get profile: " . $e->getMessage());
            throw new HttpResponseException(response()->json(['error' => $e->getMessage()], 400));
        }
    }

    public function getPhoneNumber($accessToken, $userAccessToken)
    {
        try {
            $response = Http::withHeaders([
                'access_token' => $accessToken,
                'code' => $userAccessToken,
                'secret_key' => env("ZALO_SECRET_KEY"),
            ])->get('https://graph.zalo.me/v2.0/me/info');

            return $response->json();
        } catch (\Exception $e) {
            Log::error("get phone error:" . $e->getMessage());
            throw new HttpResponseException(response()->json(['error' => $e->getMessage()], 400));
        }
    }

    public function redirectToZaloLogin()
    {
        try {
            $codeVerifier = Str::random(43);
            $codeChallenge = rtrim(strtr(base64_encode(hash('sha256', $codeVerifier, true)), '+/', '-_'), '=');
            session(['code_verifier' => $codeVerifier]);

            $state = Str::random(32);
            session(['oauth_state' => $state]);

            $appId = env('ZALO_APP_ID');
            $redirectUri = route('p17.auth.zalo.client');
            $codeChallenge = $codeChallenge;
            $state = $state;

            $authUrl = "https://oauth.zaloapp.com/v4/permission?app_id={$appId}&redirect_uri={$redirectUri}&code_challenge={$codeChallenge}&state={$state}";

            return redirect($authUrl);
        } catch (\Exception $e) {
            Log::error("redirect to zalo login: " . $e->getMessage());
            return abort(400);
        }
    }

    public function getAccessToken($code, $codeVerifier)
    {
        try {
            $response = Http::withHeaders([
                'secret_key' => env('ZALO_SECRET_KEY'),
            ])->asForm()->post('https://oauth.zaloapp.com/v4/access_token', [
                'app_id' => env('ZALO_APP_ID'),
                'code' => $code,
                'code_verifier' => $codeVerifier,
                'grant_type' => 'authorization_code',
            ]);

            if (isset($response['error']) && $response['error'] == -14019) {

                return $this->redirectToZaloLogin();
            } elseif (isset($response['error']) && $response['error'] !== 0) {
                return $this->redirectToZaloLogin();
            }

            // Save access token and refresh token

            Session::put('access_token', $response['access_token']);
            Session::put('refresh_token', $response['refresh_token']);
            Session::put('refresh_token_expires_in', $response['refresh_token_expires_in']);

            $previousUrl = Session::get('previous_url');

            return redirect($previousUrl);
        } catch (\Exception $e) {
            Log::error("get access token: " . $e->getMessage());
            return abort(400);
        }
    }

    public function refreshAcessToken($next, $request)
    {
        $refreshToken = Session::get('refresh_token');
        $refreshTokenExpiresIn = Session::get('refresh_token_expires_in');

        if (!$refreshToken || !$refreshTokenExpiresIn) {
            return $this->redirectToZaloLogin();
        }

        $response = Http::withHeaders([
            'secret_key' => env('ZALO_SECRET_KEY'),
        ])->asForm()->post('https://oauth.zaloapp.com/v4/access_token', [
            'app_id' => env('ZALO_APP_ID'),
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
        ]);

        if (isset($response['access_token']) && $response['refresh_token']) {
            Session::put('access_token', $response['access_token']);
            Session::put('refresh_token', $response['refresh_token']);
            Session::put('refresh_token_expires_in', $response['refresh_token_expires_in']);

            return $next($request);
        }

        return $this->redirectToZaloLogin();
    }
}
