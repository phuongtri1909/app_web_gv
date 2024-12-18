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
        $accessToken = $request->header('access-token');

        if (!isset($accessToken) || !$accessToken) {
            return $this->unauthorizedResponse($next,$request);
        }

        $get_info = $this->zaloApiService->getProfile($accessToken);
        if (isset($get_info['error']) && $get_info['error'] !== 0) {
            
            return $this->unauthorizedResponse($next,$request, $get_info);
        }

        $request->merge(['get_info' => $get_info]);
        $request->merge(['customer_id' => $get_info['id']]);
        return $next($request);
    }

    protected function unauthorizedResponse($next, $request, $get_info = null)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'error' => 'Unauthorized',
                'status' => 401,
            ], 401);
        } else {
            try {
                if($get_info != null){
                    if ($get_info['error'] == 452) {
                        return $this->zaloApiService->refreshAcessToken($next, $request);
                    }
                }
                return $this->zaloApiService->redirectToZaloLogin();
            } catch (\Exception $e) {
                dd($e->getMessage());
                return abort(401);
            }
        }
    }
}
