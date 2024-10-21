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
        $languages = Language::all();
        return view('admin.pages.financial-support.create', compact('languages','banks'));
    }

    public function store(Request $request)
    {
        $locales = Language::pluck('locale')->toArray();


        $rules = [
            'avt_financial_support' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'bank_id' => 'required|exists:banks,id',
        ];
        $messages = [
            'avt_financial_support.image' => __('image_image'),
            'avt_financial_support.mimes' => __('image_mimes'),
            'bank_id.required' => 'Bạn phải chọn một ngân hàng.',
            'bank_id.exists' => 'Ngân hàng đã chọn không tồn tại.',
        ];


        foreach ($locales as $locale) {
            $rules["name_{$locale}"] = 'string|max:255';
            $messages["name_{$locale}.string"] = __('name_string');
            $messages["name_{$locale}.max"] = __('name_max', ['max' => 255]);
        }


        $validatedData = $request->validate($rules, $messages);

        try {
            $translateName = [];
            $image_path = null;
            foreach ($locales as $locale) {
                $translateName[$locale] = $request->get("name_{$locale}");
            }


            if ($request->hasFile('avt_financial_support')) {
                $image = $request->file('avt_financial_support');
                $folderName = date('Y/m');
                $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileName = $originalFileName . '_' . time() . '.' . $extension;
                $image->move(public_path('/uploads/images/financial_support/' . $folderName), $fileName);
                $image_path = 'uploads/images/financial_support/' . $folderName . '/' . $fileName;
            }
            $slug = Str::slug($translateName[config('app.locale')]);
            $url = "http://app_web_gv.local/client/post-detail/{$slug}";
            if (FinancialSupport::where('slug', $slug)->exists()) {
                return redirect()->back()->with('error', __('slug_exists'));
            }
            $financialSupport = new FinancialSupport();
            $financialSupport->setTranslations('name', $translateName);
            $financialSupport->slug = $slug;
            $financialSupport->url_financial_support = $url;
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
        $languages = Language::all();
        $banks = Bank::all();
        return view('admin.pages.financial-support.edit', compact('financialSupport', 'languages','banks'));
    }

    public function update(Request $request, $id)
    {
        $locales = Language::pluck('locale')->toArray();

        $rules = [
            'avt_financial_support' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'url' => 'required|url',
            'bank_id' => 'required|exists:banks,id',
        ];
        $messages = [
            'avt_financial_support.image' => __('image_image'),
            'avt_financial_support.mimes' => __('image_mimes'),
            'url.required' => __('URL is required'),
            'url.url' => __('URL is not valid'),
            'bank_id.required' => 'Bạn phải chọn một ngân hàng.',
            'bank_id.exists' => 'Ngân hàng đã chọn không tồn tại.',
        ];

        foreach ($locales as $locale) {
            $rules["name_{$locale}"] = 'string|max:255';
            $messages["name_{$locale}.string"] = __('name_string');
            $messages["name_{$locale}.max"] = __('name_max', ['max' => 255]);
        }

        $validatedData = $request->validate($rules, $messages);

        try {
            $financialSupport = FinancialSupport::findOrFail($id);
            $translateName = [];
            foreach ($locales as $locale) {
                $translateName[$locale] = $request->get("name_{$locale}");
            }

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

            $slug = Str::slug($translateName[config('app.locale')]);
            if (FinancialSupport::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                return redirect()->back()->with('error', __('slug_exists'));
            }

            $financialSupport->setTranslations('name', $translateName);
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
