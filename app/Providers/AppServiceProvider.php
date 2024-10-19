<?php

namespace App\Providers;

use App\Models\Tab;
use App\Models\Language;
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
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Lấy danh sách các tab
        $tab_tuyen_sinh = $this->getTab('admissions', false);
        $tab_chuong_trinh = $this->getTab('programs', false);
        $tab_phu_huynh = $this->getTab('parent',false);

        // Lấy một tab đơn
        $tab_moi_truong_cha = $this->getTab('environment');
        $tab_phu_huynh_2 = $this->getTab('parent');
        $tab_noi_dung_ct = $this->getTab('programs-content');
        $tab_ban_co_van = $this->getTab('advisory-board');

        $excludedSlugs = ['school-board-message', 'brighton-academy'];
        $tabs_about_us = Tab::where('key_page', 'about-us')
            ->whereNotIn('slug', $excludedSlugs)
            ->where('active', 'yes')
            ->select('slug', 'title')
            ->get();
        $tabs_about_us = $this->handleEmptyCollection($tabs_about_us);

        $tabs_environment = Tab::where('key_page', 'environment')
            ->whereNotIn('slug', $excludedSlugs)
            ->where('active', 'yes')
            ->select('slug', 'title')
            ->get();
        $tabs_environment = $this->handleEmptyCollection($tabs_environment);

        $key_pages = ['about-us', 'environment', 'admissions', 'programs', 'parent', 'advisory-board'];
        $languages = Schema::hasTable('languages') ? Language::all() : collect();

        $page_suggestions = Schema::hasTable('tabs') ? Tab::whereIn('key_page', $key_pages)->inRandomOrder()->take(4)->get() : collect();

        $tab_blogs = $this->getTab('blog');

        // Chia sẻ dữ liệu với các view
        View::share('page_suggestions', $page_suggestions);
        $sharedData = [
            'languages' => $languages,
            'tab_tuyen_sinh' => $tab_tuyen_sinh,
            'tab_chuong_trinh' => $tab_chuong_trinh,
            'tab_phu_huynh' => $tab_phu_huynh,
            'tab_moi_truong_cha' => $tab_moi_truong_cha,
            'tabs_about_us' => $tabs_about_us,
            'tabs_environment' => $tabs_environment,
            'tab_blogs' => $tab_blogs,
            'tab_noi_dung_ct' => $tab_noi_dung_ct,
            'tab_ban_co_van' => $tab_ban_co_van,
            'tab_phu_huynh_2' => $tab_phu_huynh_2
        ];

        View::composer(['layouts.app', 'admin.layouts.app'], function ($view) use ($sharedData) {
            $view->with($sharedData);
        });
    }

    // Hàm hỗ trợ để lấy dữ liệu và gán giá trị mặc định
    private function getTab($keyPage, $isSingle = true)
    {
        $query = Tab::where('key_page', $keyPage)
            ->where('active', 'yes')
            ->select('slug', 'title');

        if ($isSingle) {
            $result = $query->first();
            return $result ?? (object) ['slug' => '', 'title' => ''];
        } else {
            $result = $query->get();
            return $result->isEmpty() ? collect([(object) ['slug' => '', 'title' => '']]) : $result;
        }
    }

    // Hàm hỗ trợ để xử lý danh sách rỗng
    private function handleEmptyCollection($collection)
    {
        return $collection->isEmpty() ? collect([(object) ['slug' => '', 'title' => '']]) : $collection;
    }


}
