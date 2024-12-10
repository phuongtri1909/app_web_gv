<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        if($search) {
            $departments = Department::where('name', 'like', "%$search%")
                ->paginate(15);
            return view('admin.pages.p17.department.index', compact('departments'));
        }

        $departments = Department::paginate(15);

        return view('admin.pages.p17.department.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.p17.department.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|max:255',
            ], [
                'name.required' => 'Tên phòng ban không được để trống.',
                'name.max' => 'Tên phòng ban không được vượt quá 255 ký tự.',
            ]);
        
            $slug = Str::slug($request->name);
        
            if (Department::where('slug', $slug)->exists()) {
                return redirect()->route('departments.index')->with('error', 'Phòng ban đã tồn tại.');
            }
        
            $department = new Department();
            $department->name = $request->name;
            $department->slug = $slug;
            $department->save();
        
            return redirect()->route('departments.index')->with('success', 'Thêm phòng ban thành công.');
        } catch (\Exception $e) {
            return redirect()->route('departments.index')->with('error', 'Thêm phòng ban thất bại.');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($department)
    {
        $department = Department::find($department);

        if (!$department) {
            return redirect()->route('department.index')
                ->with('error', 'Phòng ban không tồn tại.');
        }

        return view('admin.pages.p17.department.edit', compact('department'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$department)
    {
        $department = Department::find($department);

        if(!$department){
            return redirect()->route('departments.index')
                ->with('error', 'Phòng ban không tồn tại.');
        }

        try{
            $request->validate([
                'name' => 'required|max:255',
            ],[
                'name.required' => 'Tên phòng ban không được để trống.',
                'name.max' => 'Tên phòng ban không được vượt quá 255 ký tự.',
            ]);

            $slug = Str::slug($request->name);

            if (Department::where('slug', $slug)->where('id', '!=', $department->id)->exists()) {
                return redirect()->route('departments.index')->with('error', 'Phòng ban đã tồn tại.');
            }

            $department->name = $request->name;
            $department->slug = $slug;
            $department->save();

            return redirect()->route('departments.index')->with('success', 'Cập nhật phòng ban thành công.');
        }catch(\Exception $e){
            return redirect()->route('departments.index')->with('error', 'Cập nhật phòng ban thất bại.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($department)
    {
        $department = Department::find($department);

        if(!$department){
            return redirect()->route('department.index')
                ->with('error', 'Phòng ban không tồn tại.');
        }

        try{
            $department->delete();
            return redirect()->route('departments.index')->with('success', 'Xóa phòng ban thành công.');
        }catch(\Exception $e){
            return redirect()->route('departments.index')->with('error', 'Xóa phòng ban thất bại.');
        }
    }
}
