<?php

namespace App\Http\Controllers;

use App\Models\Tab;
use App\Models\Tuition;
use App\Models\Admission;
use Illuminate\Http\Request;
use App\Models\TabImgContent;
use App\Models\AdmissionProcess;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;

class AdmissionController extends Controller
{

    public function pageAdmission()
    {
        $tuitions = Tuition::with('content_tuition')->orderBy('numerical_order', 'asc')->get();
        foreach ($tuitions as $tuition) {
            $tuition->content = $tuition->content_tuition; 
            $tuition->count = count($tuition->content);
        }
        return view('pages.admission', compact('tuitions'));
    }

    public function tabAdmission(Request $request, $slug)
    {
        $tab = Tab::where('slug', $slug)->first();
        if(!$tab){
            return abort(404);
        }
        $tab_img_contents = TabImgContent::where('tab_id', $tab->id)->get();
        if(!$tab_img_contents){
            return view('pages.admission', compact('tab'));
        }
        switch ($tab->slug) {
            case 'admissions-process':
                $process = AdmissionProcess::get();
                foreach ($process as $key => $value) {
                    $value->process_detail = $value->admission_process_detail;
                }

                $tab_img_content = $tab_img_contents->where('tab_id', $tab->id)->first();
                return view('pages.tab-admission.admissions-process', compact('tab','tab_img_content','process'));
                break;
            case 'tuition-fees':
            case 'refund-tuition-fees':
            case 'school-calendar':
                $admissionJson = $request->cookie('admission');
               
                // if ($admissionJson) {
                //     $admission = Admission::where('email', json_decode($admissionJson)->email)
                //                             ->Where('age', json_decode($admissionJson)->age)
                //                             ->Where('full_name', json_decode($admissionJson)->full_name)
                //                             ->Where('phone', json_decode($admissionJson)->phone)
                //                             ->first();
                //     if ($admission) {
                //         return view('pages.admission', compact('tab','tab_img_contents','admission'));
                //     }
                // }

                $admission = new Admission();
                return view('pages.admission', compact('tab','tab_img_contents','admission'));
                break;
            default:
                $component_2 = $tab->imgContents->where('section_type','component_1')->first();
                    
                $components_3 = $tab->imgContents()->where('section_type','component_2')->get();

                return view('pages.tab-custom.index', compact('tab','component_2','components_3'));
                break;
        }

    }

    public function sendAdmission(Request $request)
    {
        $recaptchaSecret = config('services.recaptcha.secret');
        $response = $request->input('g-recaptcha-response');

        $response = Http::get('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $recaptchaSecret,
            'response' => $response
        ]);
        
        $verifyResponse = $response->body();
        $responseData = json_decode($verifyResponse);

        if (!$responseData->success) {
            return redirect()->back()->withInput()->with(['error' =>  __('recaptcha_required') ]);
        }

        $request->validate([
            'age' => 'required|in:1-2,2-3,3-4,4-5,5-6',
            'full_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'address' => 'nullable',
            'content' => 'nullable',
        ],[
            'age.required' => __('form.age_required'),
            'age.in' => __('form.age_in',['min' => 1, 'max' => 6]),
            'full_name.required' => __('form.name_required'),
            'email.required' => __('form.email_required'),
            'email.email' => __('form.email_email'),
            'phone.required' => __('form.phone_required'),
            'phone.numeric' => __('form.phone_numeric'),
        ]);

        try {
            $admission = new Admission();
            $admission->age = $request->age;
            $admission->full_name = $request->full_name;
            $admission->email = $request->email;
            $admission->phone = $request->phone;
            $admission->address = $request->address;
            $admission->content = $request->content;
            $admission->save();

            $admissionData = [
                'age' => $admission->age,
                'full_name' => $admission->full_name,
                'email' => $admission->email,
                'phone' => $admission->phone,
            ];

            $admissionJson = json_encode($admissionData);
            Cookie::queue(Cookie::forever('admission', $admissionJson));
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with(['error' => __('send_admission_consultation_error') ]);
        }

        return redirect()->back()->with('success', __('send_admission_consultation_success'));
    }

    public function index()
    {
        $admissions = Admission::orderBy('created_at', 'desc')->paginate(30);
        return view('admin.pages.admission.index', compact('admissions'));
    }

    public function approve($id)
    {
        $admission = Admission::find($id);
        if ($admission) {
            if($admission->status == 'pending'){
                $admission->status = "approved";
                $admission->save();
                return redirect()->back()->with('success', __('admission_approve_success'));
            }
            if($admission->status == 'rejected'){
                return redirect()->back()->with('error', __('admission_already_rejected'));
            }
            else{
                return redirect()->back()->with('error', __('admission_already_approved'));
            }
        }else{
            return redirect()->back()->with('error', __('admission_not_found'));
        }
    }

    public function reject($id)
    {
        $admission = Admission::find($id);
       if($admission){
            if($admission->status == 'pending'){
                $admission->status = "rejected";
                $admission->save();
                return redirect()->back()->with('success', __('admission_reject_success'));
            }
            if($admission->status == 'approved'){
                return redirect()->back()->with('error', __('admission_already_approved'));
            }
            else{
                return redirect()->back()->with('error', __('admission_already_rejected'));
            }
        }else{
            return redirect()->back()->with('error', __('admission_not_found'));
        }
    }
}
