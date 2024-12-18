<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\ZaloApiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
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

        $routeActions = ['p17.list.surveys.client', 'p17.list.competitions.exams.client','p17.online.xams.client.index'];
        $routeAuth = 'p17.auth.zalo.client';
        if (in_array($request->route()->getName(), $routeActions)) {
            Session::put('previous_url', $request->fullUrl());
        }

        $code = $request->query('code');
        $codeVerifier = session('code_verifier');

        if (Session::has('access_token')) {
            $accessToken = Session::get('access_token');
            $get_info = $this->zaloApiService->getProfile($accessToken);
           
            if (isset($get_info['error']) && $get_info['error'] !== 0) {
                if (in_array($request->route()->getName(), $routeActions)) {
                    //452 lỗi token hết hạn
                    if($get_info['error'] == 452){
                        return $this->zaloApiService->refreshAcessToken($next, $request);
                    }

                    return $this->zaloApiService->redirectToZaloLogin();
                }
            }

            if (Route::currentRouteName() == $routeAuth) {
                $previousUrl = Session::get('previous_url');

                return redirect($previousUrl);
            }
            return $next($request);
        }

        return $this->checkCodeZalo($code, $codeVerifier);
    }

    protected function checkCodeZalo($code, $codeVerifier)
    {
        if(!$code || !$codeVerifier){
            return $this->zaloApiService->redirectToZaloLogin();
        }else{
            return $this->zaloApiService->getAccessToken($code, $codeVerifier);
        }
    }
}
