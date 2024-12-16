<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
class QuestionController extends Controller
{
    public function index($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $questions = $quiz->questions;
        foreach ($questions as $question) {
            if (is_string($question->answer)) {
                $question->answer = json_decode($question->answer, true);
            }
        }
        return view('admin.pages.p17.online-exams.questions.index', compact('quiz', 'questions'));
    }

    public function create($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        return view('admin.pages.p17.online-exams.questions.ce', compact('quiz'));
    }

    public function store(Request $request, $quizId)
    {
        try {
            $validated = $request->validate([
                'question_name' => 'required|string|max:255',
                'answers' => 'required|array|min:2|max:10',
                'answers.*' => 'required|string|max:255',
                'answer_true' => 'required|string',
            ], [
                'question_name.required' => 'Câu hỏi không được để trống.',
                'question_name.string' => 'Câu hỏi phải là một chuỗi ký tự.',
                'question_name.max' => 'Câu hỏi không được dài quá 255 ký tự.',
                
                'answers.required' => 'Bạn phải nhập ít nhất 2 đáp án.',
                'answers.array' => 'Đáp án phải là một mảng.',
                'answers.min' => 'Bạn phải nhập ít nhất 2 đáp án.',
                'answers.max' => 'Bạn chỉ có thể nhập tối đa 10 đáp án.',
                
                'answers.*.required' => 'Đáp án không được để trống.',
                'answers.*.string' => 'Mỗi đáp án phải là một chuỗi ký tự.',
                'answers.*.max' => 'Đáp án không được dài quá 255 ký tự.',
                
                'answer_true.required' => 'Bạn phải chọn một đáp án đúng.',
                'answer_true.string' => 'Đáp án đúng phải là một chuỗi ký tự.',
            ]);
    
            if (!array_key_exists($validated['answer_true'], $validated['answers'])) {
                return back()->with('error', 'Đáp án đúng không hợp lệ.')->withInput();
            }

            Question::create([
                'quiz_id' => $quizId,
                'question_name' => $validated['question_name'],
                'answer' => json_encode($validated['answers']),  
                'answer_true' => $validated['answer_true'], 
            ]);
    
            return redirect()->route('questions.index', $quizId)->with('success', 'Thêm câu hỏi thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm câu hỏi: ' . $e->getMessage());
    
            return back()->with('error', 'Đã xảy ra lỗi khi thêm câu hỏi. Vui lòng thử lại sau.')->withInput();
        }
    }
    
    public function edit($id)
    {
        $question = Question::findOrFail($id);
        $quiz = $question->quiz;
        return view('admin.pages.p17.online-exams.questions.ce', compact('question', 'quiz'));
    }

    public function update(Request $request, $id)
    {
        try {
            
            $question = Question::findOrFail($id);

            $validated = $request->validate([
                'question_name' => 'required|string|max:255',
                'answers' => 'required|array|min:2|max:10',
                'answers.*' => 'required|string|max:255',
                'answer_true' => 'required|string',
            ], [
                'question_name.required' => 'Câu hỏi không được để trống.',
                'question_name.string' => 'Câu hỏi phải là một chuỗi ký tự.',
                'question_name.max' => 'Câu hỏi không được dài quá 255 ký tự.',
                
                'answers.required' => 'Bạn phải nhập ít nhất 2 đáp án.',
                'answers.array' => 'Đáp án phải là một mảng.',
                'answers.min' => 'Bạn phải nhập ít nhất 2 đáp án.',
                'answers.max' => 'Bạn chỉ có thể nhập tối đa 10 đáp án.',
                
                'answers.*.required' => 'Đáp án không được để trống.',
                'answers.*.string' => 'Mỗi đáp án phải là một chuỗi ký tự.',
                'answers.*.max' => 'Đáp án không được dài quá 255 ký tự.',
                
                'answer_true.required' => 'Bạn phải chọn một đáp án đúng.',
                'answer_true.string' => 'Đáp án đúng phải là một chuỗi ký tự.',
            ]);

            if (!array_key_exists($validated['answer_true'], $validated['answers'])) {
                return back()->with('error', 'Đáp án đúng không hợp lệ.')->withInput();
            }
            $question->update([
                'question_name' => $validated['question_name'],
                'answer' => json_encode($validated['answers']),
                'answer_true' => $validated['answer_true'],
            ]);

            return redirect()->route('questions.index', $question->quiz_id)->with('success', 'Cập nhật câu hỏi thành công!');
        } catch (\Exception $e) {

            Log::error('Lỗi khi cập nhật câu hỏi: ' . $e->getMessage());
            return back()->with('error', 'Đã xảy ra lỗi khi cập nhật câu hỏi. Vui lòng thử lại sau.')->withInput();
        }
    }


    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $quizId = $question->quiz_id;
        $question->delete();

        return redirect()->route('questions.index', $quizId)->with('success', 'Xóa câu hỏi thành công!.');
    }
}
