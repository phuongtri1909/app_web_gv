<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CompetitionsImport;

class CompetitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($type = 'competition')
    {
        $competitions = Competition::where('type', $type)->paginate(10);

        return view('admin.pages.p17.online-exams.competitions.index', compact('competitions','type'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create($type = 'competition')
    {
        return view('admin.pages.p17.online-exams.competitions.create', compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($type = 'competition', Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,inactive,completed',
            'time_limit' => 'required|integer|min:1',
            'banner' => 'required|image|mimes:jpeg,jpg,png|max:2048', // Giới hạn 2MB
        ], [
            'title.required' => 'Tiêu đề là bắt buộc.',
            'title.max' => 'Tiêu đề không được vượt quá :max ký tự.',
            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date' => 'Ngày bắt đầu phải đúng định dạng ngày.',
            'end_date.required' => 'Ngày kết thúc là bắt buộc.',
            'end_date.date' => 'Ngày kết thúc phải đúng định dạng ngày.',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái phải là một trong các giá trị: active, inactive, completed.',
            'time_limit.required' => 'Giới hạn thời gian là bắt buộc.',
            'time_limit.integer' => 'Giới hạn thời gian phải là số nguyên.',
            'time_limit.min' => 'Giới hạn thời gian phải lớn hơn hoặc bằng :min phút.',
            'banner.required' => 'Ảnh bìa là bắt buộc.',
            'banner.image' => 'Ảnh bìa phải là tệp hình ảnh.',
            'banner.mimes' => 'Ảnh bìa phải có định dạng: jpeg, jpg, png.',
            'banner.max' => 'Ảnh bìa không được lớn hơn :max KB.',
        ]);

        try {

            if ($request->hasFile('banner')) {
                $image = $request->file('banner');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = $originalFileName . '_' .time() . '.webp';
                $uploadPath = public_path('uploads/images/competitions/banner/' . $folderName);

                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }
                $image = Image::make($image->getRealPath());
                $image->resize(360, 203);
                $image->encode('webp', 75);
                $image->save($uploadPath . '/' . $fileName);

                $bannerPath = 'uploads/images/p17/competitions/banner/' . $folderName . '/' . $fileName;
            }

            Competition::create([
                'title' => $validated['title'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'status' => $validated['status'],
                'time_limit' => $validated['time_limit'],
                'banner' => $bannerPath,
            ]);
            return redirect()->route('competitions.index', ['type' => $type])->with('success', 'Cuộc thi đã được tạo thành công.');
        } catch (\Exception $e) {
            if (isset($bannerPath) && File::exists(public_path($bannerPath))) {
                File::delete(public_path($bannerPath));
            }
            Log::error('Lỗi tạo cuộc thi: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($type = 'competition', $id)
    {

        $competition = Competition::where('type', $type)->findOrFail($id);

        return view('admin.pages.p17.online-exams.competitions.edit', compact('competition', 'type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($type = 'competition',Request $request, $id)
    {
        $competition = Competition::where('type', $type)->findOrFail($id);

        try {
            $validated = $request->validate(
                [
                    'title' => 'required|string|max:255',
                    'start_date' => 'required|date',
                    'end_date' => 'required|date|after:start_date',
                    'status' => 'required|in:active,inactive,completed',
                    'time_limit' => 'required|integer|min:1',
                    'banner' => 'nullable|image|mimes:jpeg,jpg,png',
                ],
                [
                    'title.required' => 'Vui lòng nhập tiêu đề cuộc thi.',
                    'title.string' => 'Tiêu đề phải là chuỗi ký tự.',
                    'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
                    'start_date.required' => 'Vui lòng chọn ngày bắt đầu.',
                    'start_date.date' => 'Ngày bắt đầu phải là định dạng ngày hợp lệ.',
                    'end_date.required' => 'Vui lòng chọn ngày kết thúc.',
                    'end_date.date' => 'Ngày kết thúc phải là định dạng ngày hợp lệ.',
                    'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
                    'status.required' => 'Vui lòng chọn trạng thái.',
                    'status.in' => 'Trạng thái không hợp lệ, chỉ được chọn active, inactive hoặc completed.',
                    'time_limit.required' => 'Vui lòng nhập giới hạn thời gian.',
                    'time_limit.integer' => 'Giới hạn thời gian phải là số nguyên.',
                    'time_limit.min' => 'Giới hạn thời gian phải lớn hơn hoặc bằng 1.',
                    'banner.image' => 'Banner phải là một tệp hình ảnh.',
                    'banner.mimes' => 'Banner phải có định dạng jpeg, jpg, hoặc png.',
                ]
            );


            if ($request->hasFile('banner')) {
                $image = $request->file('banner');

                if ($competition->banner && File::exists(public_path($competition->banner))) {
                    File::delete(public_path($competition->banner));
                }

                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = $originalFileName . '_' . time() . '.webp';
                $uploadPath = public_path('uploads/images/p17/competitions/banner/' . $folderName);

                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                $image = Image::make($image->getRealPath());
                $image->resize(360, 203);
                $image->encode('webp', 75);
                $image->save($uploadPath . '/' . $fileName);

                $bannerPath = 'uploads/images/p17/competitions/banner/' . $folderName . '/' . $fileName;
                $competition->banner = $bannerPath;
            }

            $competition->update([
                'title' => $validated['title'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'status' => $validated['status'],
                'time_limit' => $validated['time_limit'],
                'banner' => $competition->banner ?? $competition->getOriginal('banner'),
            ]);

            return redirect()->route('competitions.index', ['type' => $type , 'id' => $id])->with('success', 'Cuộc thi đã được cập nhật thành công.');

        } catch (\Exception $e) {
            if (isset($bannerPath) && File::exists(public_path($bannerPath))) {
                File::delete(public_path($bannerPath));
            }
            Log::error('Lỗi khi cập nhật cuộc thi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi cập nhật cuộc thi. Vui lòng thử lại.');
        }
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $type = 'competition' ,string $id)
    {
        try {
            $competition = Competition::findOrFail($id);
            $competition->delete();

            return redirect()->route('competitions.index', ['type' => $type , 'id' => $id])->with('success', 'Cuộc thi đã được xóa thành công.');
        } catch (ModelNotFoundException $e) {
            Log::error('Lỗi khi xóa cuộc thi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Cuộc thi không tồn tại. Vui lòng thử lại.');
        }
    }

    public function import($type = 'competition', Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new CompetitionsImport, $request->file('file'));

            return redirect()->route('competitions.index', ['type' => $type])
                ->with('success', 'Dữ liệu cuộc thi đã được nhập thành công.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            // Hiển thị lỗi validation
            return back()->withErrors([
                'file' => 'Dữ liệu trong file không hợp lệ. Vui lòng kiểm tra lại.'
            ])->with('importErrors', $failures);
        } catch (\Exception $e) {
            \Log::error('Import Error: ' . $e->getMessage());

            return back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }

}
