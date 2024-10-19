<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Branch;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class StaffController extends Controller
{


    /**
     * Show the form for creating a new resource.
     */
    public function create($campus_id)
    {
        $campus = Branch::find($campus_id);
        if (!$campus) {
           return redirect()->route('campuses.index')->with('error', __('campus_not_found'));
        }

        $languages = Language::all();
        return view('admin.pages.campus.staff.create', compact('campus', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $campus_id)
    {
        $campus = Branch::find($campus_id);
        if (!$campus) {
            return redirect()->route('campuses.index')->with('error', __('campus_not_found'));
        }

        $rules = [
            'full_name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ];

        $messages = [
            'image.required' => __('avatar_required'),
            'image.image' => __('avatar_image'),
            'image.mimes' => __('avatar_mimes'),
            'image.max' => __('avatar_max_5120'),
            'full_name.required' => __('full_name_required'),
        ];


        $locales = Language::pluck('locale')->toArray();

        foreach ($locales as $locale) {
            $rules['position_' . $locale] = 'required';
            $rules['description_' . $locale] = 'required';

            $messages['position_' . $locale . '.required'] = __('position_required');
            $messages['description_' . $locale . '.required'] = __('description_required');
        }

        $this->validate($request, $rules, $messages);

        try{
            $staff = new Staff();

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

                    $staff->image = $image_path;
                } catch (\Exception $e) {

                    if (isset($image_path) && File::exists(public_path($image_path))) {
                        File::delete(public_path($image_path));
                    }

                    return redirect()->back()->with('error', __('image_upload_failed'));
                }
            }

            $staff->branch_id = $campus->id;
            $staff->full_name = $request->full_name;

            $translatePosition = [];
            $translateDescription = [];

            foreach ($locales as $locale) {
                $translatePosition[$locale] = $request->get('position_' . $locale);
                $translateDescription[$locale] = $request->get('description_' . $locale);
            }

            $staff->position = $translatePosition;
            $staff->description = $translateDescription;
            $staff->save();

            return redirect()->route('campuses.show', $campus->id)->with('success', __('create_personnel_success'));
        } catch (\Exception $e) {
            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            return redirect()->back()->with('error', __('create_personnel_error') . $e->getMessage());
        }


    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($staff)
    {
        $personnel = Staff::find($staff);
        if (!$personnel) {
            return redirect()->route('campuses.index')->with('error', __('personnel_not_found'));
        }

        $campus = Branch::find($personnel->branch->id);
        if (!$campus) {
            return redirect()->route('campuses.index')->with('error', __('campus_not_found'));
        }
        $languages = Language::all();
        return view('admin.pages.campus.staff.edit', compact('personnel', 'campus', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $staff)
    {
        $personnel = Staff::find($staff);
        if (!$personnel) {
            return redirect()->route('campuses.index')->with('error', __('personnel_not_found'));
        }

        $campus = Branch::find($personnel->branch->id);

        if (!$campus) {
            return redirect()->route('campuses.index')->with('error', __('campus_not_found'));
        }

        $rules = [
            'full_name' => 'required',
        ];

        $messages = [
            'full_name.required' => __('full_name_required'),
        ];

        if ($request->hasFile('image')) {
            $rules = [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            ];

            $messages = [
                'image.required' => __('avatar_required'),
                'image.image' => __('avatar_image'),
                'image.mimes' => __('avatar_mimes'),
                'image.max' => __('avatar_max_5120'),
            ]; 
        }

        $locales = Language::pluck('locale')->toArray();

        foreach ($locales as $locale) {
            $rules['position_' . $locale] = 'required';
            $rules['description_' . $locale] = 'required';

            $messages['position_' . $locale . '.required'] = __('position_required');
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

                    if (!File::exists($uploadPath)) {
                        File::makeDirectory($uploadPath, 0755, true);
                    }

                    $image = Image::make($image->getRealPath());
                    $image->save($uploadPath . '/' . $fileName, 75);

                    $image_path = 'uploads/images/campus/' . $folderName . '/' . $fileName;

                    $imageBackup = $personnel->image;
                    $personnel->image = $image_path;
                } catch (\Exception $e) {

                    if (isset($image_path) && File::exists(public_path($image_path))) {
                        File::delete(public_path($image_path));
                    }

                    return redirect()->back()->with('error', __('image_upload_failed'));
                }
            }

            $personnel->full_name = $request->full_name;

            $translatePosition = [];
            $translateDescription = [];

            foreach ($locales as $locale) {
                $translatePosition[$locale] = $request->get('position_' . $locale);
                $translateDescription[$locale] = $request->get('description_' . $locale);
            }

            $personnel->position = $translatePosition;
            $personnel->description = $translateDescription;

            $personnel->save();

            if (isset($imageBackup) && File::exists(public_path($imageBackup))) {
                File::delete(public_path($imageBackup));
            }

            return redirect()->route('campuses.show', $campus->id)->with('success', __('update_personnel_success'));
        } catch (\Exception $e) {
            if (isset($image_path) && File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            return redirect()->back()->with('error', __('update_personnel_error') . $e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($staff)
    {
        $personnel = Staff::find($staff);
        if (!$personnel) {
            return redirect()->route('campuses.index')->with('error', __('personnel_not_found'));
        }

        $campus = Branch::find($personnel->branch->id);
        if (!$campus) {
            return redirect()->route('campuses.index')->with('error', __('campus_not_found'));
        }

        try {
           
            $personnel->delete();
            if (isset($personnel->image) && File::exists(public_path($personnel->image))) {
                File::delete(public_path($personnel->image));
            }
            return redirect()->route('campuses.show', $campus->id)->with('success', __('delete_personnel_success'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('delete_personnel_error'));
        }
    }
}
