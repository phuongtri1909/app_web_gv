<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\AdmissionProcess;
use App\Models\AdmissionProcessDetail;

class AdmissionProcessDetailController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create($process_id)
    {
        $process = AdmissionProcess::find($process_id);
        if (!$process) {
            return back()->with('error', __('no_find_process'));
        }
        $languages = Language::all();
        return view('admin.pages.tab_tuyensinh.process-detail.create', compact('languages', 'process'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $process_id)
    {
        $process = AdmissionProcess::find($process_id);
        if (!$process) {
            return back()->with('error', __('no_find_process'));
        }

        $locales = Language::all()->pluck('locale')->toArray();
        foreach ($locales as $locale) {
           $rules= [
                'title_'.$locale => 'required',
                'content_'.$locale => 'required',
            ];
            $messages = [
                'title_'.$locale.'.required' => __('title_required'),
                'content_'.$locale.'.required' => __('content_required'),
            ];
        }

        $request->validate($rules, $messages);

        try {
            $translationTitle = [];
            $translationContent = [];

            foreach ($locales as $locale) {
                $translationTitle[$locale] = $request->input('title_'.$locale);
                $translationContent[$locale] = $request->input('content_'.$locale);
            }

            $processDetail = new AdmissionProcessDetail();
            $processDetail->title = $translationTitle;
            $processDetail->content = $translationContent;
            $processDetail->admission_process_id = $process_id;
            $processDetail->save();
        } catch (\Exception $e) {
            return back()->with('error', __('create_detail_process_error'));
        }

        return redirect()->route('admission-process.show', $process_id)->with('success', __('create_detail_process_success'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($admissionProcessDetail)
    {
        $processDetail = AdmissionProcessDetail::find($admissionProcessDetail);
        if (!$processDetail) {
            return back()->with('error', __('no_find_process_detail'));
        }
        $process = $processDetail->admission_process;
        $languages = Language::all();
        return view('admin.pages.tab_tuyensinh.process-detail.edit', compact('languages', 'processDetail', 'process'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $admissionProcessDetail)
    {
        $admissionProcessDetail = AdmissionProcessDetail::find($admissionProcessDetail);
        if (!$admissionProcessDetail) {
            return back()->with('error', __('no_find_process_detail'));
        }

        $locales = Language::all()->pluck('locale')->toArray();
        foreach ($locales as $locale) {
           $rules= [
                'title_'.$locale => 'required',
                'content_'.$locale => 'required',
            ];
            $messages = [
                'title_'.$locale.'.required' => __('title_required'),
                'content_'.$locale.'.required' => __('content_required'),
            ];
        }

        $request->validate($rules, $messages);

        try {
            $translationTitle = [];
            $translationContent = [];

            foreach ($locales as $locale) {
                $translationTitle[$locale] = $request->input('title_'.$locale);
                $translationContent[$locale] = $request->input('content_'.$locale);
            }

            $admissionProcessDetail->title = $translationTitle;
            $admissionProcessDetail->content = $translationContent;
            $admissionProcessDetail->save();
            return redirect()->route('admission-process.show', $admissionProcessDetail->admission_process->id)->with('success', __('update_detail_process_success'));
        } catch (\Exception $e) {
            return back()->with('error', __('update_detail_process_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $admissionProcessDetail)
    {
        $admissionProcessDetail = AdmissionProcessDetail::find($admissionProcessDetail);
        if (!$admissionProcessDetail) {
            return back()->with('error', __('no_find_process_detail'));
        }

        try {
            $admissionProcessDetail->delete();
            return back()->with('success', __('delete_detail_process_success'));
        } catch (\Exception $e) {
            return back()->with('error', __('delete_detail_process_error'));
        }
    }
}
