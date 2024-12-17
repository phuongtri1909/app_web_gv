<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
class QuestionController extends Controller
{
    public function index($type = 'competition', $quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $questions = $quiz->questions;
        foreach ($questions as $question) {
            if (is_string($question->answer)) {
                $question->answer = json_decode($question->answer, true);
            }
        }
        return view('admin.pages.p17.online-exams.questions.index', compact('quiz', 'questions','type'));
    }

    public function create($type = 'competition', $quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        return view('admin.pages.p17.online-exams.questions.ce', compact('quiz','type'));
    }

    public function store($type = 'competition', Request $request, $quizId)
    {
        Log::info('Data from request: ', $request->all());
        try {

            $validated = $request->validate([
                'question_name' => 'required|string|max:255',
                'answers' => 'required|array|min:2|max:10',
                'answers.*' => 'required|string|max:255',
                'answer_true' => 'required|string|in:' . implode(',', array_keys($request->answers)),
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


            $answers = [];
            foreach ($validated['answers'] as $key => $value) {
                $answers[$key] = $value;
            }


            $answerTrueKey = $validated['answer_true'];
            if (!array_key_exists($answerTrueKey, $answers)) {
                throw new \Exception('Đáp án đúng không hợp lệ.');
            }


            $question = new Question();
            $question->quiz_id = $quizId;
            $question->question_name = $validated['question_name'];
            $question->answer = json_encode($answers);
            $question->answer_true = $answerTrueKey;
            $question->save();

            return redirect()->route('questions.index', ['type' => $type, 'quizId' => $quizId])->with('success', 'Thêm câu hỏi thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm câu hỏi: ' . $e->getMessage());

            return back()->with('error', 'Đã xảy ra lỗi khi thêm câu hỏi. Vui lòng thử lại sau.')->withInput();
        }
    }



    public function edit($type = 'competition', $id)
    {
        $question = Question::findOrFail($id);
        $quiz = $question->quiz;
        return view('admin.pages.p17.online-exams.questions.ce', compact('question', 'quiz','type'));
    }

    public function update($type = 'competition', Request $request, $id)
    {
        try {
        $validated = $request->validate([
            'question_name' => 'required|string|max:255',
            'answers' => 'required|array',
            'answer_true' => 'required|string|in:' . implode(',', array_keys($request->answers)),
        ] ,[
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

        $answers = [];
        foreach ($validated['answers'] as $key => $value) {
            $answers[$key] = $value;
        }


        $answerTrueKey = $validated['answer_true'];
        if (!array_key_exists($answerTrueKey, $answers)) {
            throw new \Exception('Đáp án đúng không hợp lệ.');
        }


        $question = Question::findOrFail($id);


        $question->question_name = $validated['question_name'];
        $question->answer = json_encode($answers);
        $question->answer_true = $answerTrueKey;
        $question->save();

        return redirect()->route('questions.index',['type' => $type, 'quizId' => $question->quiz_id])->with('success', 'Cập nhật câu hỏi thành công!');
    } catch (\Exception $e) {
        Log::error('Lỗi khi cập nhật câu hỏi: ' . $e->getMessage());

        return back()->with('error', 'Đã xảy ra lỗi khi cập nhật câu hỏi. Vui lòng thử lại sau.')->withInput();
    }
    }





    public function destroy($type = 'competition', $id)
    {
        $question = Question::findOrFail($id);
        $quizId = $question->quiz_id;
        $question->delete();

        return redirect()->route('questions.index', ['type' => $type, 'quizId' => $quizId])->with('success', 'Xóa câu hỏi thành công!.');
    }
}
