<?php

namespace App\Providers;

use App\Models\Tab;
use App\Models\Business;
use App\Models\Language;
use App\Models\Locations;
use App\Models\LegalAdvice;
use App\Models\BusinessMember;
use App\Models\JobApplication;
use App\Models\ProductBusiness;
use App\Services\ZaloApiService;
use Illuminate\Support\Facades\DB;
use App\Models\BusinessCapitalNeed;
use App\Models\BusinessRecruitment;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Models\BusinessFairRegistration;
use App\Models\BusinessStartPromotionInvestment;
use App\Models\Unit;

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

        $businessMemberStatusPending = BusinessMember::where('status', 'pending')->count();
        $businessStatus = Business::where('status', 'pending')->count();
        $businessProductStatus = ProductBusiness::where('status', 'pending')->count();
        $capitalNeedsStatus = BusinessCapitalNeed::where('email_status', 'not_sent')->count();
        $businessRecruitmentStatus = BusinessRecruitment::where('status', 'pending')->count();
        $jobApplicationsStatus = JobApplication::where('status', 'pending')->count();
        $legalAdviceStatus = LegalAdvice::where('status', 'pending')->count();
        $startPromotionInvestmentStatus = BusinessStartPromotionInvestment::where('status', 'pending')->count();
        $fairRegistrationsStatus = BusinessFairRegistration::where('status', 'pending')->count();

        $unit_id = Unit::where('unit_code','QGV')->first()->id;
        if($unit_id) {
            $locationStatus = Locations::where('unit_id', $unit_id)->where('status', 'pending')->count();
        } else {
            $locationStatus = 0;
        }

        
        $sharedData = [
            'languages' => $languages,
            'businessMemberStatusPending' => $businessMemberStatusPending,
            'businessStatus' => $businessStatus,
            'businessProductStatus' => $businessProductStatus,
            'capitalNeedsStatus' => $capitalNeedsStatus,
            'businessRecruitmentStatus' => $businessRecruitmentStatus,
            'jobApplicationsStatus' => $jobApplicationsStatus,
            'legalAdviceStatus' => $legalAdviceStatus,
            'startPromotionInvestmentStatus' => $startPromotionInvestmentStatus,
            'fairRegistrationsStatus' => $fairRegistrationsStatus,
            'locationStatus' => $locationStatus,
        ];

        View::composer(['layouts.app', 'admin.layouts.app'], function ($view) use ($sharedData) {
            $view->with($sharedData);
        });
    }

}
