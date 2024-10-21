<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
class BanksController extends Controller
{
    //
    public function index()
    {

        $banks = Bank::all();
        return view('admin.pages.banks.index', compact('banks'));
    }
    public function create()
    {
        return view('admin.pages.banks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:banks,name',
            'avt_bank' => 'image|max:2048',
        ], [
            'name.required' => 'Trường họ và tên là bắt buộc.',
            'name.string' => 'Tên phải là một chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên này đã tồn tại trong hệ thống. Vui lòng chọn tên khác.',
            'avt_bank.image' => __('image_image'),
            'avt_bank.max' => 'Ảnh không được vượt quá 2MB.',
        ]);
        $image = null;
        if ($request->hasFile('avt_bank')) {
            $image = $request->file('avt_bank');
            $folderName = date('Y/m');
            $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $fileName = $originalFileName . '_' . time() . '.' . $extension;
            $image->move(public_path('/uploads/images/banks/' . $folderName), $fileName);
            $image_path = 'uploads/images/banks/' . $folderName . '/' . $fileName;
        }
        $slug = Str::slug($request->input('name'));
        if (Bank::where('slug', $slug)->exists()) {
            return redirect()->back()->with('error', __('Slug đã tồn tại.'))->withInput();
        }
        Bank::create([
            'name' => $request->input('name'),
            'slug' => $slug,
            'avt_bank' => $image_path,
        ]);

        return redirect()->route('banks.index')->with('success', __('Tạo thành công!!.'));
    }

    public function edit($id)
    {
        try {
            $banks = Bank::findOrFail($id);
            return view('admin.pages.banks.edit', compact('banks'));
        } catch (Exception $e) {
            return redirect()->route('banks.index')->with('error', __('Dịch vụ ngân hàng không tồn tại.'));
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $banks = Bank::findOrFail($id);
            $request->validate([
                'name' => 'required|string|max:255|unique:banks,name,' . $banks->id,
                'avt_bank' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            ], [
                'name.required' => 'Trường họ và tên là bắt buộc.',
                'name.string' => 'Tên phải là một chuỗi ký tự.',
                'name.max' => 'Tên không được vượt quá 255 ký tự.',
                'name.unique' => 'Tên này đã tồn tại trong hệ thống. Vui lòng chọn tên khác.',
                'avt_bank.image' => __('image_image'),
                'avt_bank.mimes' => __('image_mimes'),
            ]);


            $slug = Str::slug($request->input('name'));

            if (Bank::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                return redirect()->back()->with('error', __('Slug đã tồn tại.'))->withInput();
            }

            $image_path = $banks->avt_bank;
            if ($request->hasFile('avt_bank')) {
                $image = $request->file('avt_bank');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileName = $originalFileName . '_' . time() . '.' . $extension;
                $image->move(public_path('/uploads/images/banks/' . $folderName), $fileName);
                $image_path = 'uploads/images/banks/' . $folderName . '/' . $fileName;
            }

            $banks->update([
                'name' => $request->input('name'),
                'avt_bank' => $image_path,
                'slug' => $slug,
            ]);

            return redirect()->route('banks.index')->with('success', __('Cập nhật thành công!!'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('banks.index')->with('error', __('Dịch vụ ngân hàng không tồn tại.'));
        } catch (Exception $e) {
            return redirect()->route('banks.edit', $id)->withInput()->with('error', __('Cập nhật lỗi!!.'));
        }
    }
    public function destroy($id)
    {
        try {
            $banks = Bank::findOrFail($id);

            $banks->delete();

            return redirect()->route('banks.index')->with('success', __('Xóa thành công!!!'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('banks.index')->with('error', __('Ngân hàng không tồn tại.'));
        } catch (Exception $e) {
            return redirect()->route('banks.index')->with('error', __('Có lỗi xảy ra: ') . $e->getMessage());
        }
    }
    public function showHomeBank()
    {
        $banks = Bank::all();
        return view('pages.client.gv.home-bank',compact('banks'));
    }
}
