<?php

namespace App\Http\Controllers\API;

use App\Models\TopQuestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class TopQuestionController extends Controller
{
    public function topQuestions()
    {
        $top_questions = TopQuestion::all();
        return response()->json(['topQuestions' => $top_questions], 200);
    }

    public function store(Request $request)
    {

        try {
            $validatedData = $request->validate([
                'question' => 'required|max:255',
                'linkUrl' => 'nullable|url',
                'attachment' => 'nullable|file|mimes:pdf',
                'get_info' => 'required',
            ], [
                'question.required' => 'Câu hỏi không được để trống',
                'question.max' => 'Câu hỏi không được vượt quá 255 ký tự',
                'linkUrl.url' => 'Định dạng link không hợp lệ',
                'attachment.file' => 'File không hợp lệ',
                'attachment.mimes' => 'Định dạng file phải là pdf',
                'get_info.required' => 'Thao tác không hợp lệ',
            ]);

            if ($request->hasFile('attachment')) {
                $folderName = date('Y/m');
                $attachment = $request->file('attachment');
                $originalFileName = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                $fileName = $originalFileName . '_' . time() . '.' . $attachment->getClientOriginalExtension();
                $uploadPath = public_path('uploads/files/attachment' . $folderName);

                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                $attachment->move($uploadPath, $fileName);

                $validatedData['attachment'] = $uploadPath . '/' . $fileName;
            }

            $top_question = new TopQuestion();

            $top_question->question = $request->question;
            $top_question->questioned_by = $validatedData['get_info']['name'];

            if($request->has('linkUrl')) {
                $top_question->linkUrl = $validatedData['linkUrl'];
            }

            if($request->has('attachment')) {
                $top_question->attachment = $validatedData['attachment'];
            }

            $top_question->save();
            

            return response()->json(['message' => 'Gửi câu hỏi thành công'], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Có lỗi xảy ra, vui lòng thử lại sau' . $e->getMessage()], 500);
        }
    }
}
