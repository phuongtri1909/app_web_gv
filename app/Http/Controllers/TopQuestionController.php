<?php

namespace App\Http\Controllers;

use App\Models\TopQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TopQuestionController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->input('search');

        if ($search) {
            $topQuestions = TopQuestion::where('question', 'like', '%' . $search . '%')
                ->orWhere('answer', 'like', '%' . $search . '%')
                ->orWhere('questioned_by', 'like', '%' . $search . '%')
                ->orWhere('answered_by', 'like', '%' . $search . '%')
                ->paginate(15);
            $topQuestions->appends(['search' => $search]);
        } else {
            $topQuestions = TopQuestion::paginate(15);
        }

        return view('admin.pages.p17.top_question.index', compact('topQuestions'));
    }

    public function create()
    {
        return view('admin.pages.p17.top_question.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|max:255',
            'answer' => 'required|max:255',
            'linkUrl' => 'nullable|url',
            'attachment' => 'nullable|file|mimes:pdf',
        ], [
            'question.required' => 'Câu hỏi không được để trống.',
            'question.max' => 'Câu hỏi không được quá 255 ký tự.',
            'answer.required' => 'Câu trả lời không được để trống.',
            'answer.max' => 'Câu trả lời không được quá 255 ký tự.',
            'linkUrl.url' => 'Link không hợp lệ.',
            'attachment.file' => 'File không hợp lệ.',
            'attachment.mimes' => 'File phải là pdf.',
        ]);

        $question = new TopQuestion();
        $question->question = $request->input('question');
        $question->answer = $request->input('answer');
        $question->questioned_by = auth()->user()->full_name;
        $question->answered_by = auth()->user()->full_name;

        if ($request->has('linkUrl')) {
            $question->linkUrl = $request->input('linkUrl');
        }

        if ($request->hasFile('attachment')) {
            $folderName = date('Y/m');
            $attachment = $request->file('attachment');
            $originalFileName = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
            $fileName = $originalFileName . '_' . time() . '.' . $attachment->getClientOriginalExtension();
            $uploadPath = public_path('uploads/files/attachment/' . $folderName);

            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $attachment->move($uploadPath, $fileName);

            $uploadPath = 'uploads/files/attachment/' . $folderName;

            $pathAttachment = $uploadPath . '/' . $fileName;

            $question->attachment = $pathAttachment;
        }

        $question->save();

        return redirect()->route('top-questions.index')->with('success', 'Câu hỏi thường gặp đã được thêm.');
    }

    public function destroy($id)
    {
        $question = TopQuestion::findOrFail($id);
        $question->delete();
        return redirect()->route('top-questions.index')->with('success', 'Câu hỏi thường gặp đã được xóa.');
    }

    public function answer(Request $request, $id)
    {
        $request->validate([
            'answer_' . $id => 'required|max:255',
            'linkUrl_' . $id => 'nullable|url',
            'attachment_' . $id => 'nullable|file|mimes:pdf',
        ], [
            'answer_' . $id . '.required' => 'Câu trả lời không được để trống.',
            'answer_' . $id . '.max' => 'Câu trả lời không được quá 255 ký tự.',
            'linkUrl_' . $id . '.url' => 'Link không hợp lệ.',
            'attachment_' . $id . '.file' => 'File không hợp lệ.',
            'attachment_' . $id . '.mimes' => 'File đính kèm phải là tệp PDF.',
        ]);

        $question = TopQuestion::findOrFail($id);
        $question->answer = $request->input('answer_' . $id);
        $question->answered_by = auth()->user()->full_name;

        if ($request->has('linkUrl_' . $id)) {
            $question->linkUrl = $request->input('linkUrl_' . $id);
        }

        if ($request->hasFile('attachment_' . $id)) {
            $folderName = date('Y/m');
            $attachment = $request->file('attachment_' . $id);
            $originalFileName = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
            $fileName = $originalFileName . '_' . time() . '.' . $attachment->getClientOriginalExtension();
            $uploadPath = public_path('uploads/files/attachment/' . $folderName);

            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $attachment->move($uploadPath, $fileName);

            $uploadPath = 'uploads/files/attachment/' . $folderName;

            $pathAttachment = $uploadPath . '/' . $fileName;

            $question->attachment = $pathAttachment;
        }

        $question->save();

        return redirect()->route('top-questions.index')->with('success', 'Câu hỏi đã được trả lời.');
    }
}
