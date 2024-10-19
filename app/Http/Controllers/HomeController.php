<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\Banners;
use App\Models\Branch;
use App\Models\CategoryProgram;
use App\Models\ProgramOverview;
use App\Models\Slider;
use App\Models\Tab;
use App\Models\TabProject;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::where('active', 'yes')
            ->where('key_page', 'key_home')
            ->get();
        $category = CategoryProgram::where('key_page', 'page_home')
            ->with('programs')
            ->first();

        $programs = $category->programs;

        $aboutUs = AboutUs::first();

        $testimonials = Testimonial::all();


        $banners = Banners::where('key_page', 'key_home')
            ->where('active', 'yes')
            ->get();

        $firstBanner = $banners->first();

        $campuses = Branch::get();

        $tabs_programs_content = Tab::where('key_page','programs-content')->first();
        $tabs_mini_content = Tab::where('key_page','programs')
                                ->where('slug','phat-trien-cac-du-an-mini')
                                ->first();
        $tabProject = TabProject::whereRaw('content IS NULL OR content = ?', [json_encode([])])
                                ->latest()
                                ->limit(5)
                                ->get();
        return view(
            'pages.home',
            [
                'banner' => $firstBanner,
                'sliders' => $sliders,
                'category' => $category,
                'programs' => $programs,
                'aboutUs' => $aboutUs,
                'testimonials' => $testimonials,
                'campuses' => $campuses,
                'tabs_programs_content' => $tabs_programs_content,
                'tabProject' => $tabProject,
                'tabs_mini_content' => $tabs_mini_content
            ]
        );
    }
}
