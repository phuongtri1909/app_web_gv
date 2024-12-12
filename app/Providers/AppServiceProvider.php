<?php

namespace App\Providers;

use App\Models\Tab;
use App\Models\Language;
use App\Services\ZaloApiService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ZaloApiService::class, function ($app) {
            return new ZaloApiService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    
        $languages = Schema::hasTable('languages') ? Language::all() : collect();

        
        $sharedData = [
            'languages' => $languages,   
        ];

        View::composer(['layouts.app', 'admin.layouts.app'], function ($view) use ($sharedData) {
            $view->with($sharedData);
        });
    }

}
