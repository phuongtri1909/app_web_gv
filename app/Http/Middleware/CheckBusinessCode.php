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
        $key = 'E-Business@$^$%^';
        // Store the intended route if not already stored
        if ($request->route()->getName() !== 'form.check.business') {
            $request->session()->put('intended_route', $request->fullUrl());
        }

        if ($request->isMethod('post') && $request->route()->getName() === 'form.check.business') {
            $request->validate([
                'business_code' => 'required',
            ], [
                'business_code.required' => 'Vui lòng nhập mã số thuế',
            ]);

            $businessCode = $request->input('business_code');
            $businessMember = BusinessMember::where('business_code', $businessCode)->first();

            if ($businessMember && $businessMember->status == 'approved') {
                $request->session()->put('business_code', $businessMember->business_code);
    
                $encryptedBusinessCode = $this->encrypt($businessMember->business_code, $key);
                $request->session()->put('key_business_code', $encryptedBusinessCode);

                $intendedRoute = session('intended_route', route('show.form.member.business'));
                
                return redirect($intendedRoute);
            }elseif($businessMember && $businessMember->status == 'pending'){
                return redirect()->route('form.check.business')->with('error', 'Tài khoản của bạn đang chờ xác nhận, vui lòng chờ trong giây lát')->withInput();
            }elseif($businessMember && $businessMember->status == 'rejected'){
                return redirect()->route('form.check.business')->with('error', 'Tài khoản của bạn đã bị từ chối, vui lòng liên hệ với chúng tôi nếu có thắc mắc')->withInput();
            }
            else {
                return redirect()->route('show.form.member.business')->with('error', 'Mã số thuế không tồn tại, hãy đăng ký doanh nghiệp/hộ kinh doanh')->withInput();
            }
        }

        $keyBusinessCode = $request->session()->get('key_business_code');
        $isBusinessCode = $request->session()->get('business_code');
       

        if ($keyBusinessCode && $isBusinessCode) {
           $decryptedBusinessCode = $this->decrypt($keyBusinessCode, $key);
           if ($isBusinessCode == $decryptedBusinessCode) {

                return $next($request);
            }
            return redirect()->route('form.check.business')->with('error', 'Hãy kiểm tra lại mã số thuế trước khi đăng ký');
        }
        else{
            return redirect()->route('form.check.business')->with('error', 'Hãy kiểm tra mã số thuế trước khi đăng ký');
        }
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