<?php
namespace App\Http\Controllers;

use App\Models\BankServicesInterest;
use App\Models\FinancialSupport;
use App\Models\Language;
use App\Models\NewsTabContentDetailPost;
use App\Models\TabDetailPost;
use App\Models\News;
use Illuminate\Http\Request;

class NewsTabContentDetailPostController extends Controller
{
    public function index()
    {
        $newsTabContentDetails = NewsTabContentDetailPost::with(['financialSupport', 'tab','bankServices'])->get();

        // if ($newsTabContentDetails->isEmpty()) {
        //     return redirect()->back()->with('error', 'Không tìm thấy');
        // }

        // foreach ($newsTabContentDetails as $detail) {
        //     if (!$detail->financialSupport || !$detail->tab) {
        //         $missingRelations = [];

        //         if (!$detail->financialSupport) {
        //             $missingRelations[] = 'Financial Support';
        //         }

        //         if (!$detail->tab) {
        //             $missingRelations[] = 'Tab';
        //         }
        //         if (!$detail->bankServices) {
        //             $missingRelations[] = 'Bank Services';
        //         }

        //         $errorMessage = 'Một số chi tiết nội dung bị thiếu các mối quan hệ bắt buộc: ' . implode(', ', $missingRelations);

        //         return redirect()->back()->with('error', $errorMessage);
        //     }

        // }

        return view('admin.pages.blogs.tabs_content_detail_post.index', compact('newsTabContentDetails'));
    }


    public function create()
    {
        $news = FinancialSupport::all();
        $bank_servicers = BankServicesInterest::all();
        $tabs = TabDetailPost::all();
        return view('admin.pages.blogs.tabs_content_detail_post.create', compact('news', 'tabs','bank_servicers'));
    }


    public function store(Request $request)
    {

        $rules = [
            'content' => 'required|string',
            'financial_support_id' => 'nullable|exists:financial_support,id',
            'bank_service_id' => 'nullable|exists:bank_services_interest,id',
            'tab_id' => 'required|exists:tabs_detail_posts,id',
        ];

        $messages = [
            'content.string' => __('content_string'),
        ];

        $validatedData = $request->validate($rules, $messages);

        if (empty($validatedData['financial_support_id']) && empty($validatedData['bank_service_id'])) {
            return back()->withInput()->withErrors([
                'financial_support_id' => __('Bạn phải chọn ít nhất một trong hai dịch vụ tài trợ hoặc dịch vụ ngân hàng.'),
                'bank_service_id' => __('Bạn phải chọn ít nhất một trong hai dịch vụ tài trợ hoặc dịch vụ ngân hàng.')
            ]);
        }
        if (!empty($validatedData['financial_support_id']) && !empty($validatedData['bank_service_id'])) {
            return back()->withInput()->withErrors([
                'financial_support_id' => __('Bạn chỉ có thể chọn một trong hai dịch vụ: dịch vụ tài trợ hoặc dịch vụ ngân hàng.'),
                'bank_service_id' => __('Bạn chỉ có thể chọn một trong hai dịch vụ: dịch vụ tài trợ hoặc dịch vụ ngân hàng.')
            ]);
        }
        if ($validatedData['financial_support_id']) {
            $existingFinancialSupport = NewsTabContentDetailPost::where('financial_support_id', $validatedData['financial_support_id'])
                ->where('tab_id', $validatedData['tab_id'])
                ->first();

            if ($existingFinancialSupport) {
                return back()->withInput()->withErrors([
                    'financial_support_id' => __('ID dịch vụ tài trợ này đã được liên kết với ID tab đã chọn.')
                ]);
            }
        }
        if ($validatedData['bank_service_id']) {
            $existingBankService = NewsTabContentDetailPost::where('bank_service_id', $validatedData['bank_service_id'])
                ->where('tab_id', $validatedData['tab_id'])
                ->first();
                if ($existingBankService) {
                    return back()->withInput()->withErrors([
                        'bank_service_id' => __('ID dịch vụ ngân hàng này đã được liên kết với ID tab đã chọn.')
                    ]);
                }
        }

        $contentDetailPost = new NewsTabContentDetailPost();
        $contentDetailPost->content = $validatedData['content'];
        $contentDetailPost->financial_support_id = $validatedData['financial_support_id'] ?? null;
        $contentDetailPost->bank_service_id = $validatedData['bank_service_id'] ?? null;
        $contentDetailPost->tab_id = $validatedData['tab_id'];
        $contentDetailPost->save();

        return redirect()->route('news_contents.index')->with('success', __('create_success'));
    }



    public function edit($id)
    {
        $newsContent = NewsTabContentDetailPost::findOrFail($id);
        if (!$newsContent) {
            return back()->with('error', __('no_find_data'));
        }
        $news = FinancialSupport::all();
        $bank_servicers = BankServicesInterest::all();
        $tabs = TabDetailPost::all();

        return view('admin.pages.blogs.tabs_content_detail_post.edit', compact('newsContent', 'news', 'tabs','bank_servicers'));
    }


    public function update(Request $request, string $id)
    {
        $rules = [
            'content' => 'required|string',
            'financial_support_id' => 'nullable|exists:financial_support,id',
            'bank_service_id' => 'nullable|exists:bank_services_interest,id',
            'tab_id' => 'required|exists:tabs_detail_posts,id',
        ];

        $messages = [
            'content.required' => __('content') . __(' is_required.'),
            'content.string' => __('content_string'),
        ];

        $validatedData = $request->validate($rules, $messages);
        if (empty($validatedData['financial_support_id']) && empty($validatedData['bank_service_id'])) {
            return back()->withInput()->withErrors([
                'financial_support_id' => __('Bạn phải chọn ít nhất một trong hai dịch vụ tài trợ hoặc dịch vụ ngân hàng.'),
                'bank_service_id' => __('Bạn phải chọn ít nhất một trong hai dịch vụ tài trợ hoặc dịch vụ ngân hàng.')
            ]);
        }
        if (!empty($validatedData['financial_support_id']) && !empty($validatedData['bank_service_id'])) {
            return back()->withInput()->withErrors([
                'financial_support_id' => __('Bạn chỉ có thể chọn một trong hai dịch vụ: dịch vụ tài trợ hoặc dịch vụ ngân hàng.'),
                'bank_service_id' => __('Bạn chỉ có thể chọn một trong hai dịch vụ: dịch vụ tài trợ hoặc dịch vụ ngân hàng.')
            ]);
        }

        $contentDetailPost = NewsTabContentDetailPost::findOrFail($id);
        
        if ($validatedData['financial_support_id'] && $validatedData['financial_support_id'] != $contentDetailPost->financial_support_id) {
            $existingFinancialSupport = NewsTabContentDetailPost::where('financial_support_id', $validatedData['financial_support_id'])
                ->where('tab_id', $validatedData['tab_id'])
                ->first();

            if ($existingFinancialSupport) {
                return back()->withInput()->withErrors([
                    'financial_support_id' => __('ID dịch vụ tài trợ này đã được liên kết với ID tab đã chọn.')
                ]);
            }
        }

        if ($validatedData['bank_service_id'] && $validatedData['bank_service_id'] != $contentDetailPost->bank_service_id) {
            $existingBankService = NewsTabContentDetailPost::where('bank_service_id', $validatedData['bank_service_id'])
                ->where('tab_id', $validatedData['tab_id'])
                ->first();

            if ($existingBankService) {
                return back()->withInput()->withErrors([
                    'bank_service_id' => __('ID dịch vụ ngân hàng này đã được liên kết với ID tab đã chọn.')
                ]);
            }
        }

        $newsContent = NewsTabContentDetailPost::findOrFail($id);
        $newsContent->content = $validatedData['content'];
        $newsContent->financial_support_id = $validatedData['financial_support_id'];
        $newsContent->bank_service_id = $validatedData['bank_service_id'];
        $newsContent->tab_id = $validatedData['tab_id'];
        $newsContent->save();

        return redirect()->route('news_contents.index')->with('success', __('update_success'));
    }



    public function destroy($id)
    {
        $category = NewsTabContentDetailPost::find($id);

        if (!$category) {
            return redirect()->route('news_contents.index')->with('error', __('content_not_found'));
        }


        $category->delete();

        return redirect()->route('news_contents.index')->with('success', __('delete_success'));
    }
}
