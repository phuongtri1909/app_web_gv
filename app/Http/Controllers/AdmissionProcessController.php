<?php

namespace App\Http\Controllers;

use App\Models\Tab;
use App\Models\Language;
use App\Models\Admission;
use Illuminate\Http\Request;
use App\Models\TabImgContent;
use App\Models\AdmissionProcess;
use App\Models\AdmissionProcessDetail;

class AdmissionProcessController extends Controller
{

    public function updateProcess(Request $request, $tab_img_content_id)
    {
        $tab_img_content = TabImgContent::find($tab_img_content_id);
        if (!$tab_img_content) {
            return back()->with('error', __('no_find_data'));
        }

        $tab = Tab::where('id', $tab_img_content->tab_id)->first();
        if (!$tab || $tab->slug != 'admissions-process') {
            return back()->with('error', __('no_find_data'));
        }
        
        $locales = Language::pluck('locale')->toArray();
        
        foreach ($locales as $locale) {
            $rules["title_{$locale}"] = 'required|string|max:255';
            $rules["content_{$locale}"] = 'required|string';

            $messages["title_{$locale}.required"] = __('title_required');
            $messages["content_{$locale}.required"] = __('content_required');
            $messages["title_{$locale}.string"] = __('title_string');
            $messages["title_{$locale}.max"] = __('title_max', ['max' => 255]);
            $messages["content_{$locale}.string"] = __('content_string');
        }

        $validatedData = $request->validate($rules, $messages);

        try{
            $translationTitle = [];
            $translationContent = [];
    
            foreach ($locales as $locale) {
                $translationTitle[$locale] = $validatedData["title_{$locale}"];
                $translationContent[$locale] = $validatedData["content_{$locale}"];
            }
    
            $tab_img_content->update([
                'title' => $translationTitle,
                'content' => $translationContent,
            ]);
            return back()->with('success', __('update_success'));
        }catch(\Exception $e){
            return back()->with('error', __('update_error'));
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($tab)
    {   
        $tab = Tab::where('id', $tab)->first();
        if (!$tab || $tab->slug != 'admissions-process') {
            return back()->with('error', __('no_find_data'));
        }
        $languages = Language::all();
        return view('admin.pages.tab_tuyensinh.process.create', compact('languages', 'tab'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $locales = Language::pluck('locale')->toArray();
        
        foreach ($locales as $locale) {
            $rules["title_{$locale}"] = 'required|string|max:255';
            $rules["content_{$locale}"] = 'required|string';

            $messages["title_{$locale}.required"] = __('title_required');
            $messages["content_{$locale}.required"] = __('content_required');
            $messages["title_{$locale}.string"] = __('title_string');
            $messages["title_{$locale}.max"] = __('title_max', ['max' => 255]);
            $messages["content_{$locale}.string"] = __('content_string');
        }

        $validatedData = $request->validate($rules, $messages);

        try{
            $translationTitle = [];
            $translationContent = [];
    
            foreach ($locales as $locale) {
                $translationTitle[$locale] = $validatedData["title_{$locale}"];
                $translationContent[$locale] = $validatedData["content_{$locale}"];
            }

            
            
            $admissionProcess = new AdmissionProcess();
            $admissionProcess->setTranslations('title', $translationTitle);
            $admissionProcess->setTranslations('content', $translationContent);
            $admissionProcess->save();
            
            $tab = Tab::where('slug', 'admissions-process')->first();
            return redirect()->route('tabs-admissions.show', $tab->id)->with('success', __('create_process_success'));
        }catch(\Exception $e){
            return back()->with('error', __('create_process_error'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($admissionProcess)
    {
        $admissionProcess = AdmissionProcess::where('id', $admissionProcess)->first();
        if (!$admissionProcess) {
            return back()->with('error', __('no_find_process'));
        }

        $admissionProcessDetail = AdmissionProcessDetail::where('admission_process_id', $admissionProcess->id)->get();

        return view('admin.pages.tab_tuyensinh.process.show_detail_process', compact('admissionProcess', 'admissionProcessDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($admissionProcess)
    {
        $admissionProcess = AdmissionProcess::where('id', $admissionProcess)->first();
        if (!$admissionProcess) {
            return back()->with('error', __('no_find_process'));
        }
        $tab = Tab::where('slug', 'admissions-process')->first();
        $languages = Language::all();
        return view('admin.pages.tab_tuyensinh.process.edit', compact('languages', 'admissionProcess', 'tab'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $admissionProcess)
    {
        $admissionProcess = AdmissionProcess::where('id', $admissionProcess)->first();
        if (!$admissionProcess) {
            return back()->with('error', __('no_find_process'));
        }

        $locales = Language::pluck('locale')->toArray();
        
        foreach ($locales as $locale) {
            $rules["title_{$locale}"] = 'required|string|max:255';
            $rules["content_{$locale}"] = 'required|string';

            $messages["title_{$locale}.required"] = __('title_required');
            $messages["content_{$locale}.required"] = __('content_required');
            $messages["title_{$locale}.string"] = __('title_string');
            $messages["title_{$locale}.max"] = __('title_max', ['max' => 255]);
            $messages["content_{$locale}.string"] = __('content_string');
        }

        $validatedData = $request->validate($rules, $messages);

        try{
            $translationTitle = [];
            $translationContent = [];
    
            foreach ($locales as $locale) {
                $translationTitle[$locale] = $validatedData["title_{$locale}"];
                $translationContent[$locale] = $validatedData["content_{$locale}"];
            }
    
            $admissionProcess->setTranslations('title', $translationTitle);
            $admissionProcess->setTranslations('content', $translationContent);
            $admissionProcess->save();

            $tab = Tab::where('slug', 'admissions-process')->first();
            return redirect()->route('tabs-admissions.show', $tab->id)->with('success', __('update_process_success'));
        }catch(\Exception $e){
            return back()->with('error', __('update_process_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($admissionProcess)
    {
        $admissionProcess = AdmissionProcess::where('id', $admissionProcess)->first();
        if (!$admissionProcess) {
            return back()->with('error', __('no_find_process'));
        }
        try{
            $admissionProcess->delete();
            $tab = Tab::where('slug', 'admissions-process')->first();
            return redirect()->route('tabs-admissions.show', $tab->id)->with('success', __('delete_process_success'));
        }catch(\Exception $e){
            return back()->with('error', __('delete_process_error'));
        }
    }
}
