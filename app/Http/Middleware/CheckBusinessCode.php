<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\BusinessMember;

class CheckBusinessCode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if(!auth()->check()){
            return redirect()->route('admin.login')->with('error', 'Vui lòng đăng nhập trước khi thực hiện chức năng này');
        }

        if (auth()->user()->role == 'admin') {
           return redirect()->route('admin.dashboard')->with('error', 'Bạn là admin, không thể thực hiện đăng ký các thông tin');
        }


        return $next($request);

    }

    function encrypt($data, $key) {
        $cipher = "aes-256-cbc";
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
        $encrypted = openssl_encrypt($data, $cipher, $key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }
    
    function decrypt($data, $key) {
        $cipher = "aes-256-cbc";
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, $cipher, $key, 0, $iv);
    }
}