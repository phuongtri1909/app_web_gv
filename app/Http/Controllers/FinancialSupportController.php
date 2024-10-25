<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankServicesInterest;
use App\Models\FinancialSupport;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class FinancialSupportController extends Controller
{
    // Show the list of financial support entries
    public function index()
    {
        $financialSupports = FinancialSupport::all();
        return view('admin.pages.financial-support.index', compact('financialSupports'));
    }


    public function create()
    {
        $banks = Bank::all();
        return view('admin.pages.financial-support.create', compact('banks'));
    }

    public function store(Request $request)
    {
        $rules = [
            'avt_financial_support' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'bank_id' => 'required|exists:banks,id',
            'name' => 'required|string|max:255|unique:financial_support,name',
        ];
        $messages = [
            'avt_financial_support.image' => __('image_image'),
            'avt_financial_support.mimes' => __('image_mimes'),
            'bank_id.required' => 'Bạn phải chọn một ngân hàng.',
            'bank_id.exists' => 'Ngân hàng đã chọn không tồn tại.',
            'name.required' => __('Tên là bắt buộc.'),
            'name.string' => __('Tên không hợp lệ.'),
            'name.max' => __('Tên không được vượt quá :max ký tự.', ['max' => 255]),
            'name.unique' => __('Tên đã tồn tại !!'),
        ];

        $validatedData = $request->validate($rules, $messages);

        try {
            $image_path = null;
            if ($request->hasFile('avt_financial_support')) {
                $image = $request->file('avt_financial_support');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileName = $originalFileName . '_' . time() . '.' . $extension;
                $image->move(public_path('/uploads/images/financial_support/' . $folderName), $fileName);
                $image_path = 'uploads/images/financial_support/' . $folderName . '/' . $fileName;
            }

            $financialSupport = new FinancialSupport();
            $financialSupport->name = $request->name;
            $financialSupport->slug = Str::slug($request->name);
            $financialSupport->url_financial_support = env('APP_URL') . '/client/post-detail/' . $financialSupport->slug;

            if (FinancialSupport::where('slug', $financialSupport->slug)->exists()) {
                return redirect()->back()->with('error', __('slug_exists'));
            }

            $financialSupport->avt_financial_support = $image_path;
            $financialSupport->bank_id = $request->bank_id;
            $financialSupport->save();

            return redirect()->route('financial-support.index')->with('success', __('Tạo thành công!!'));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', __('Đã có lỗi xảy ra'));
        }
    }




    public function show($id)
    {
        $financialSupport = FinancialSupport::findOrFail($id);
        return view('financial_support.show', compact('financialSupport'));
    }


    public function edit($id)
    {
        $financialSupport = FinancialSupport::findOrFail($id);
        $banks = Bank::all();
        return view('admin.pages.financial-support.edit', compact('financialSupport', 'banks'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'avt_financial_support' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'url' => 'required|url',
            'bank_id' => 'required|exists:banks,id',
            'name' => 'required|string|max:255|unique:financial_supports,name,' . $id,
        ];
        $messages = [
            'avt_financial_support.image' => __('image_image'),
            'avt_financial_support.mimes' => __('image_mimes'),
            'url.required' => __('URL là bắt buộc'),
            'url.url' => __('URL không hợp lệ'),
            'bank_id.required' => 'Bạn phải chọn một ngân hàng.',
            'bank_id.exists' => 'Ngân hàng đã chọn không tồn tại.',
            'name.required' => __('Tên là bắt buộc.'),
            'name.string' => __('Tên không hợp lệ.'),
            'name.max' => __('Tên không được vượt quá :max ký tự.', ['max' => 255]),
            'name.unique' => __('Tên đã tồn tại !!'),
        ];

        $validatedData = $request->validate($rules, $messages);

        try {
            $financialSupport = FinancialSupport::findOrFail($id);

            $image_path = $financialSupport->avt_financial_support;
            if ($request->hasFile('avt_financial_support')) {
                $image = $request->file('avt_financial_support');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileName = $originalFileName . '_' . time() . '.' . $extension;
                $image->move(public_path('/uploads/images/financial_support/' . $folderName), $fileName);
                $image_path = 'uploads/images/financial_support/' . $folderName . '/' . $fileName;
            }

            $slug = Str::slug($request->name);
            if (FinancialSupport::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                return redirect()->back()->with('error', __('slug_exists'));
            }

            $financialSupport->name = $request->name;
            $financialSupport->slug = $slug;
            $financialSupport->avt_financial_support = $image_path;
            $financialSupport->url_financial_support = $request->input('url');
            $financialSupport->bank_id = $request->input('bank_id');
            $financialSupport->save();

            return redirect()->route('financial-support.index')->with('success', __('Cập nhật thành công!!'));
        } catch (\Exception $e) {
            return back()->withInput()->with('error', __('Đã có lỗi xảy ra'));
        }
    }



    // Delete a financial support entry
    public function destroy($id)
    {
        $financialSupport = FinancialSupport::findOrFail($id);
        $financialSupport->delete();

        return redirect()->route('financial-support.index')->with('success', 'Xóa thành công!!.');
    }

    public function showFinancial($slug){
        $bank = Bank::where('slug', $slug)->firstOrFail();
        $financialSupports = FinancialSupport::where('bank_id', $bank->id)->with('bank')->get();
        $bankServicers = BankServicesInterest::where('bank_id', $bank->id)->with('bank')->get();
        return view('pages.client.gv.home-post', compact('financialSupports','bankServicers','bank'));
    }
}
