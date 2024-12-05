<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Lấy thông tin route hiện tại
        $currentRouteName = $request->route()->getName();
        $currentRouteAction = $request->route()->getActionName();

        // Ghi log thông tin route hiện tại
      // dd($currentRouteName, $currentRouteAction);

        if (auth()->user()->role !== 'admin') {
            return redirect()->route('business')->with('error', 'Bạn không có quyền truy cập trang này');
        }

        return $next($request);
    }
}
