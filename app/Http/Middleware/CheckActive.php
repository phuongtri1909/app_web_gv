<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $authUser = auth()->user();

        if ($authUser->status == 'inactive') {
            auth()->logout();
            return redirect()->route('admin.login')->with('error', 'Tài khoản của bạn đã bị vô hiệu hóa.');
        }

        return $next($request);
    }
}
