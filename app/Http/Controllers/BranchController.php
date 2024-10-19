<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cookie;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campuses = Branch::all();
        return view('admin.pages.campus.index', compact('campuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::all();
        return view('admin.pages.campus.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'location' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ];
        $messages = [
            'image.required' => __('image_required'),
            'image.image' => __('image_image'),
            'image.mimes' => __('image_mimes'),
            'image.max' => __('image_max_5120'),
        ];
        $locales = Language::pluck('locale')->toArray();

        foreach ($locales as $locale) {
            $rules['name_' . $locale] = 'required';
            $rules['address_' . $locale] = 'required';
            $rules['title_' . $locale] = 'required';
            $rules['description_' . $locale] = 'required';

            $messages['name_' . $locale . '.required'] = __('form.name_required');
            $messages['address_' . $locale . '.required'] = __('address_required');
            $messages['title_' . $locale . '.required'] = __('title_required');
            $messages['description_' . $locale . '.required'] = __('description_required');
        }

        $this->validate($request, $rules, $messages);

        try {

            $branch = new Branch();

            if ($request->hasFile('image')) {
               try {
                    $image = $request->file('image');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    $fileName = $originalFileName . '_' . time() . '.' . $extension;
                    $uploadPath = public_path('uploads/images/campus/' . $folderName);

                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }

                    $image = Image::make($image->getRealPath());
                    $image->save($uploadPath . '/' . $fileName, 75);

                    $image_path = 'uploads/images/campus/' . $folderName . '/' . $fileName;
                } catch (\Exception $e) {
                    if (isset($image_path) && File::exists(public_path($image_path))) {
                        File::delete(public_path($image_path));
                    }
                    return back()->withInput()->with('error', __('upload_image_error'));
                }
              
                $branch->image = $image_path;
            }

           
            $branch->location = $request->location;
            $branch->phone = $request->phone;
            


            $translateName = [];
            $translateAddress = [];
            $translateTitle = [];
            $translateDescription = [];
            foreach ($locales as $locale) {
                $translateName[$locale] = $request->get('name_' . $locale);
                $translateAddress[$locale] = $request->get('address_' . $locale);
                $translateTitle[$locale] = $request->get('title_' . $locale);
                $translateDescription[$locale] = $request->get('description_' . $locale);
            }

            $branch->name = $translateName;
            $branch->address = $translateAddress;
            $branch->title = $translateTitle;
            $branch->description = $translateDescription;

            $branch->save();

            return redirect()->route('campuses.index')
            ->with('success', __('create_campus_success'));
        } catch (\Exception $e) {

            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            return redirect()->route('campuses.create')
                ->with('error', __('create_campus_error'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($branch)
    {
        $campus = Branch::find($branch);
        if (!$campus) {
            return redirect()->route('campuses.index')
                ->with('error', __('campus_not_found'));
        }

        $personnel = $campus->personnel()->orderBy('id', 'desc')->get();

        return view('admin.pages.campus.staff.index', compact('campus', 'personnel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($branch)
    {
        $campus = Branch::find($branch);
        if (!$campus) {
            return redirect()->route('campuses.index')
                ->with('error', __('campus_not_found'));
        }
        $languages = Language::all();
        return view('admin.pages.campus.edit', compact('campus', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $branch)
    {
        $campus = Branch::find($branch);
        if (!$campus) {
            return redirect()->route('campuses.index')
                ->with('error', __('campus_not_found'));
        }

        $rules = [
            'location' => 'required',
            
        ];

        if ($request->hasFile('image')) {
            $rules['image'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:5120';
        }

        $messages = [
            'image.image' => __('image_image'),
            'image.mimes' => __('image_mimes'),
            'image.max' => __('image_max_5120'),
            'location.required' => __('location_required'),
        ];

        $locales = Language::pluck('locale')->toArray();

        foreach ($locales as $locale) {
            $rules['name_' . $locale] = 'required';
            $rules['address_' . $locale] = 'required';
            $rules['title_' . $locale] = 'required';
            $rules['description_' . $locale] = 'required';

            $messages['name_' . $locale . '.required'] = __('form.name_required');
            $messages['address_' . $locale . '.required'] = __('address_required');
            $messages['title_' . $locale . '.required'] = __('title_required');
            $messages['description_' . $locale . '.required'] = __('description_required');
        }

        $this->validate($request, $rules, $messages);

        try{
            if ($request->hasFile('image')) {
                try {
                    $image = $request->file('image');
                    $folderName = date('Y/m');
                    $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    $fileName = $originalFileName . '_' . time() . '.' . $extension;
                    $uploadPath = public_path('uploads/images/campus/' . $folderName);

                    // Kiểm tra và tạo thư mục nếu chưa tồn tại
                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }

                    $image = Image::make($image->getRealPath());
                    $image->save($uploadPath . '/' . $fileName, 75);

                    $image_path = 'uploads/images/campus/' . $folderName . '/' . $fileName;
                } catch (\Exception $e) {
                    if (isset($image_path) && File::exists(public_path($image_path))) {
                        File::delete(public_path($image_path));
                    }
                    return back()->withInput()->with('error', __('upload_image_error'));
                }

                $imageBackup = $campus->image;

                $campus->image = $image_path;
            }

            $campus->location = $request->location;
            $campus->phone = $request->phone;

            $translateName = [];
            $translateAddress = [];
            $translateTitle = [];
            $translateDescription = [];
            foreach ($locales as $locale) {
                $translateName[$locale] = $request->get('name_' . $locale);
                $translateAddress[$locale] = $request->get('address_' . $locale);
                $translateTitle[$locale] = $request->get('title_' . $locale);
                $translateDescription[$locale] = $request->get('description_' . $locale);
            }

            $campus->name = $translateName;
            $campus->address = $translateAddress;
            $campus->title = $translateTitle;
            $campus->description = $translateDescription;

            $campus->save();

            if (isset($imageBackup) && File::exists(public_path($imageBackup))) {
                File::delete(public_path($imageBackup));
            }

            return redirect()->route('campuses.index')
                ->with('success', __('update_campus_success'));
        } catch (\Exception $e) {

            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            return redirect()->route('campuses.edit', $campus->id)
                ->with('error', __('update_campus_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($branch)
    {
        $campus = Branch::find($branch);
        if (!$campus) {
            return redirect()->route('campuses.index')
                ->with('error', __('campus_not_found'));
        }

        try {
            $campus->delete();
            if (File::exists(public_path($campus->image))) {
                File::delete(public_path($campus->image));
            }
            return redirect()->route('campuses.index')
                ->with('success', __('delete_campus_success'));
        } catch (\Exception $e) {
            return redirect()->route('campuses.index')
                ->with('error', __('delete_campus_error'));
        }
    }

    public function selectCampus(Request $request){
        $campus = Branch::find($request->campus_id);
        if (!$campus) {
            return redirect()->back();
        }

        Cookie::queue(Cookie::forever('campus_brighton', $request->campus_id));

        return redirect()->back();
    }
}
