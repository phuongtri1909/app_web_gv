<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ],[
            'username.required' => 'Thông tin xác thực được cung cấp không khớp với hồ sơ của chúng tôi.',
            'password.required' => 'Thông tin xác thực được cung cấp không khớp với hồ sơ của chúng tôi.',
        ]);
        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
           return redirect()->route('admin.dashboard');
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
        return redirect()->route('admin.login');
    }
}
