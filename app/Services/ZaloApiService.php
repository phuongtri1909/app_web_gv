<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Exceptions\HttpResponseException;

class ZaloApiService
{
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
}