<?php

namespace App\Http\Controllers;

use App\Models\ContactConsultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $contactConsultations = ContactConsultation::when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        })
        ->paginate(15);

        return view('admin.pages.contact_consultations.index', compact('contactConsultations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.contact_consultations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image',
            'link' => 'required',
        ], [
            'name.required' => 'Tên là trường bắt buộc.',
            'image.required' => 'Hình ảnh là trường bắt buộc.',
            'image.image' => 'Tệp tải lên phải là một hình ảnh.',
            'link.required' => 'Liên kết là trường bắt buộc.',
        ]);

            DB::beginTransaction();

            try {
                $data = [];
                $this->handleFileUpload1($request, 'image', $data, '', 'contact_consultations');

                $contactConsultation = new ContactConsultation();
                $contactConsultation->name = $request->input('name');
                $contactConsultation->image = $data['image'];
                $contactConsultation->link = $request->input('link');
                $contactConsultation->save();

                DB::commit();
                return redirect()->route('contact-consultations.index')->with('success', 'Kênh tư vấn pháp luật đã được tạo thành công!');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error' , 'Lỗi khi tạo kênh tư vấn pháp luật mới!')->withInput();
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactConsultation $contactConsultation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $contactConsultation = ContactConsultation::find($id);
        if (!$contactConsultation) {
            return redirect()->route('contact-consultations.index')->with('error', 'Kênh tư vấn pháp luật không tồn tại!');
        }
        return view('admin.pages.contact_consultations.edit')->with('contactConsultation', $contactConsultation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'image',
            'link' => 'required',
        ], [
            'name.required' => 'Tên là trường bắt buộc.',
            'image.image' => 'Tệp tải lên phải là một hình ảnh.',
            'link.required' => 'Liên kết là trường bắt buộc.',
        ]);
    
        DB::beginTransaction();
    
        try {
            $data = [];
            $this->handleFileUpload1($request, 'image', $data, '', 'contact_consultations');
    
            $contactConsultation = ContactConsultation::find($id);
            $contactConsultation->name = $request->input('name');
            if ($request->hasFile('image')) {
                $contactConsultation->image = $data['image'];
            }
            $contactConsultation->link = $request->input('link');
            $contactConsultation->save();
    
            DB::commit();
            return redirect()->route('contact-consultations.index')->with('success', 'Kênh tư vấn pháp luật đã được cập nhật thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error' , 'Lỗi khi cập nhật kênh tư vấn pháp luật!')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $contactConsultation = ContactConsultation::find($id);
        if ($contactConsultation) {
            $contactConsultation->delete();
            return redirect()->route('contact-consultations.index')->with('success', 'Xóa thành công!!.');
        }
        return back()->with('error', 'Kênh tư vấn pháp luật không tồn tại!');
    }

    public function legalAdvice()
    {
        $contactConsultation = ContactConsultation::all();
       // dd($contactConsultation);

        return view('pages.client.legal-advice', compact('contactConsultation'));
    }
}
