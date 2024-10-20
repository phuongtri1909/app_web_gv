<?php
namespace App\Http\Controllers;

use App\Models\BankServicesInterest;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BankServicerController extends Controller
{
    public function index()
    {
        $bankServicers = BankServicesInterest::all();
        return view('admin.pages.bank-servicers.index', compact('bankServicers'));
    }

    public function create()
    {
        return view('admin.pages.bank-servicers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:bank_services_interest,name',
        ], [
            'name.required' => 'Trường họ và tên là bắt buộc.',
            'name.string' => 'Tên phải là một chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên này đã tồn tại trong hệ thống. Vui lòng chọn tên khác.'
        ]);


        BankServicesInterest::create($request->all());

        return redirect()->route('bank-servicers.index')->with('success', __('Tạo thành công!!.'));
    }

    public function edit($id)
    {
        try {
            $bankServicer = BankServicesInterest::findOrFail($id);
            return view('admin.pages.bank-servicers.edit', compact('bankServicer'));
        } catch (Exception $e) {
            return redirect()->route('bank-servicers.index')->with('error', __('Dịch vụ ngân hàng không tồn tại.'));
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $bankServicer = BankServicesInterest::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255|unique:bank_services_interest,name,' . $bankServicer->id,
            ], [
                'name.required' => 'Trường họ và tên là bắt buộc.',
                'name.string' => 'Tên phải là một chuỗi ký tự.',
                'name.max' => 'Tên không được vượt quá 255 ký tự.',
                'name.unique' => 'Tên này đã tồn tại trong hệ thống. Vui lòng chọn tên khác.'
            ]);

            $bankServicer->update($request->all());

            return redirect()->route('bank-servicers.index')->with('success', __('Cập nhật thành công!!'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('bank-servicers.index')->with('error', __('Dịch vụ ngân hàng không tồn tại.'));
        } catch (Exception $e) {
            return redirect()->route('bank-servicers.edit', $id)->withInput()->with('error', __('Cập nhật lỗi!!.'));
        }
    }



    public function destroy($id)
    {
        try {
            $bankServicer = BankServicesInterest::findOrFail($id);

            if ($bankServicer->relatedModels()->count() > 0) {
                return redirect()->route('bank-servicers.index')->with('error', __('Không thể xóa vì có liên kết tồn tại.'));
            }

            $bankServicer->delete();

            return redirect()->route('bank-servicers.index')->with('success', __('Xóa thành công!!!'));
        } catch (Exception $e) {
            return redirect()->route('bank-servicers.index')->with('error', __('Dịch vụ ngân hàng không tồn tại.'));
        }
    }
}



