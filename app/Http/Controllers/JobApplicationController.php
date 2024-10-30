<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobApplicationController extends Controller
{

    public function storeForm(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:10|regex:/^[0-9]+$/',
            'fax' => 'nullable|string|max:255',
            'birth_year' => 'required|integer|min:1500|max:' . date('Y'),
            'gender' => 'required|in:male,female,other',
            'email' => 'nullable|email|max:255',
            'introduction' => 'required|string',
            'job_registration' => 'required|string',
            'cv' => 'nullable|mimes:pdf',
        ], [
            'full_name.required' => 'Tên là bắt buộc.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'phone.max' => 'Số điện thoại không được vượt quá 10 số.',
            'birth_year.required' => 'Năm sinh là bắt buộc.',
            'birth_year.digits' => 'Năm sinh phải có 4 chữ số.',
            'birth_year.min' => 'Năm sinh phải lớn hơn hoặc bằng 1500.',
            'birth_year.max' => 'Năm sinh không được lớn hơn năm hiện tại.',
            'gender.required' => 'Giới tính là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'introduction.required' => 'Thông tin/giới thiệu bản thân là bắt buộc.',
            'job_registration.required' => 'Đăng ký tìm việc là bắt buộc.',
            'cv.mimes' => 'File phải là file PDF.',
        ]);
        
        DB::beginTransaction();
        try {
            $data = $request->except(['cv']);


            if ($request->hasFile('cv')) {
                $image = $request->file('cv');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileName = $originalFileName . '_' . time() . '.' . $extension;
                $image->move(public_path('/uploads/images/cv/' . $folderName), $fileName);
                $data['cv'] = 'uploads/images/cv/' . $folderName . '/' . $fileName;
            }
            JobApplication::create([
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'],
            'fax' => $validated['fax'],
            'birth_year' => $validated['birth_year'],
            'gender' => $validated['gender'],
            'email' => $validated['email'],
            'introduction' => $validated['introduction'],
            'job_registration' => $validated['job_registration'],
            'cv' => $data['cv'],
        ]);

        DB::commit();

        return redirect()->back()->with('success', 'Gửi thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($filename) && file_exists(public_path($data['cv']))) {
                unlink(public_path($data['cv']));
            }

            return redirect()->back()->with('error', 'Gửi thất bại: ' . $e->getMessage());
        }
    }

    public function jobApplication()
    {
        return view('pages.client.form-job-application');
    }
    public function index()
    {
        $jobApplications = JobApplication::all();;
        return view('admin.pages.client.form-job-applications.index', compact('jobApplications'));
    }

    public function create()
    {
        return view('pages.client.form-job-application');
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        return response()->json([
            'id' => $jobApplication->id,
            'full_name' => $jobApplication->full_name,
            'birth_year' => $jobApplication->birth_year,
            'gender' => $jobApplication->gender,
            'phone' => $jobApplication->phone,
            'fax' => $jobApplication->fax,
            'email' => $jobApplication->email,
            'introduction' => $jobApplication->introduction,
            'job_registration' => $jobApplication->job_registration,
            'cv' => $jobApplication->cv,
            'status' => $jobApplication->status,
            'created_at' => $jobApplication->created_at
        ]);
    }


    public function edit(JobApplication $jobApplication)
    {
        return view('admin.pages.client.form-job-applications.edit', compact('jobApplication'));
    }

    public function update(Request $request, JobApplication $jobApplication)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:10|regex:/^[0-9]+$/',
            'fax' => 'nullable|string|max:255',
            'birth_year' => 'required|integer|min:1500|max:' . date('Y'),
            'gender' => 'required|in:male,female,other',
            'email' => 'nullable|email|max:255',
            'introduction' => 'required|string',
            'job_registration' => 'required|string',
            'cv' => 'nullable|mimes:pdf|max:3048',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->except(['cv']);

            if ($request->hasFile('cv')) {
                if ($jobApplication->cv && file_exists(public_path($jobApplication->cv))) {
                    unlink(public_path($jobApplication->cv));
                }

                $image = $request->file('cv');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileName = $originalFileName . '_' . time() . '.' . $extension;
                $image->move(public_path('/uploads/images/cv/' . $folderName), $fileName);
                $data['cv'] = 'uploads/images/cv/' . $folderName . '/' . $fileName;
            }

            $jobApplication->update($data);
            DB::commit();
            return redirect()->route('job-applications.index')->with('success', 'Cập nhật thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Cập nhật thất bại: ' . $e->getMessage());
        }
    }

    public function destroy(JobApplication $jobApplication)
    {
        try {
            if ($jobApplication->cv && file_exists(public_path($jobApplication->cv))) {
                unlink(public_path($jobApplication->cv));
            }
            $jobApplication->delete();
            return redirect()->route('job-applications.index')->with('success', 'Xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa thất bại: ' . $e->getMessage());
        }
    }
}
