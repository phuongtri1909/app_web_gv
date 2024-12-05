<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->route()->getName() !== 'admin.login') {
            $request->session()->put('intended_route', $request->fullUrl());
        }

        if (Auth::check()) {
            $languageExists = DB::table('languages')->where('locale', Auth::user()->language)->exists();
            $locale = $languageExists ? Auth::user()->language : config('app.locale');
        } else {
            $languageExists = DB::table('languages')->where('locale', $request->cookie('locale'))->exists();
            $locale = $languageExists ? $request->cookie('locale') : config('app.locale');
        }
        
        if (!File::exists(base_path("lang/{$locale}.json"))) {
            $locale = config('app.fallback_locale');
            App::setLocale($locale);
        }
        App::setLocale($locale);
        return $next($request);
    }
}
