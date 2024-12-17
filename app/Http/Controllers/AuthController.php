<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessMember;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $intendedRoute = session('intended_route', route('business'));

        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ],[
            'username.required' => 'Thông tin xác thực được cung cấp không khớp với hồ sơ của chúng tôi.',
            'password.required' => 'Thông tin xác thực được cung cấp không khớp với hồ sơ của chúng tôi.',
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            if (auth()->user()->role == 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (auth()->user()->role == 'business') {

                if (auth()->user()->status == 'inactive') {
                    auth()->logout();
                    return redirect()->route('admin.login')->withErrors([
                        'username' => 'Tài khoản của bạn đã bị vô hiệu hóa.',
                    ])->withInput($request->only('username'));
                }
                // Check if business_member_id exists
                if (auth()->user()->business_member_id && auth()->user()->businessMember && auth()->user()->businessMember->status == 'approved') {
                    return redirect($intendedRoute);
                } else {
                    auth()->logout();
                    return redirect()->route('admin.login')->withErrors([
                        'username' => 'Thông tin xác thực được cung cấp không khớp với hồ sơ của chúng tôi.',
                    ])->withInput($request->only('username'));
                }
            } else {
                return redirect($intendedRoute);
            }
        }

        return back()->withErrors([
            'username' => 'Thông tin xác thực được cung cấp không khớp với hồ sơ của chúng tôi.',
        ])->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->back();
    }

    public function authZalo(Request $request)
    {
        return view('pages.client.p17.auth-zalo');
    }
}
