<?php

namespace App\Http\Middleware;

use Closure;
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
        // Kiểm tra nếu đã có access_token trong session
        if (Session::has('access_token')) {

            $accessToken = Session::get('access_token');

            $get_info = $this->zaloApiService->getProfile($accessToken);

            //nếu access_token chưa hết hạn
            if (!isset($get_info['error']) && !$get_info['error'] !== 0) {
                $request->merge(['get_info' => $get_info]);
                $request->merge(['customer_id' => $get_info['id']]);
                return $next($request);
            }
        }

        $code = $request->query('code');
        if (!$code) {
            return abort(401);
        }

        // Đổi code lấy access_token từ Zalo
        $response = Http::withHeaders([
            'secret_key' => env('ZALO_SECRET_KEY'),
        ])->asForm()->post('https://oauth.zaloapp.com/v4/access_token', [
            'app_id' => env('ZALO_APP_ID'),
            'code' => $code,
            'code_verifier' => $request->query('code_verifier'),
            'grant_type' => 'authorization_code',
        ]);

        if (isset($response['error']) && $response['error'] !== 0) {
            dd($response->json());
            return abort(401);
        }

        dd($response['access_token']);


        return $next($request);
    }
}
