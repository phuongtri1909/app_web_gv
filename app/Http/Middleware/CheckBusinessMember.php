<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBusinessMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user->businessMember) {
            Auth::logout();
            return redirect()->route('show.form.member.business')->with('error', 'Bạn đã không còn là thành viên của hội doanh nghiệp');
        }elseif ($user->businessMember->status == 'pending') {
            Auth::logout();
            return redirect()->route('show.form.member.business')->with('error', 'Tài khoản của bạn đang chờ duyệt');
        }elseif ($user->businessMember->status == 'rejected') {
            Auth::logout();
            return redirect()->route('show.form.member.business')->with('error', 'Tài khoản của bạn đã bị từ chối, vui lòng liên hệ với chúng tôi');
        }

        return $next($request);
    }
}
