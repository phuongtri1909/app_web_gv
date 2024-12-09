<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleAdminQGV
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $unit = auth()->user()->unit;
        
        if($unit->unit_code !== 'QGV') {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập trang này');
        }

        return $next($request);
    }
}
