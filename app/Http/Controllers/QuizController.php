<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($competitionId)
    {
        $competition = Competition::findOrFail($competitionId);

        $quizzes = Quiz::where('competition_id', $competitionId)->paginate(10);

        return view('admin.pages.p17.online-exams.quizzes.index', compact('competition', 'quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($competitionId)
    {
        $competition = Competition::findOrFail($competitionId);
        return view('admin.pages.p17.online-exams.quizzes.ce', compact('competition'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $competitionId)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'quantity_question' => 'required|integer|min:1',
                'status' => 'required|in:active,inactive,completed',
            ], [
                'title.required' => 'Tiêu đề không được để trống.',
                'title.string' => 'Tiêu đề phải là một chuỗi ký tự.',
                'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
                'quantity_question.required' => 'Số lượng câu hỏi không được để trống.',
                'quantity_question.integer' => 'Số lượng câu hỏi phải là một số nguyên.',
                'quantity_question.min' => 'Số lượng câu hỏi phải lớn hơn hoặc bằng 1.',
                'status.required' => 'Trạng thái không được để trống.',
                'status.in' => 'Trạng thái không hợp lệ. Vui lòng chọn Hoạt động, Không hoạt động hoặc Hoàn thành.',
            ]);


            $competition = Competition::findOrFail($competitionId);

            Quiz::create([
                'competition_id' => $competition->id,
                'title' => $request->title,
                'quantity_question' => $request->quantity_question,
                'status' => $request->status,
            ]);

            return redirect()->route('quizzes.index', $competition->id)
                ->with('success', 'Bộ câu hỏi đã được thêm thành công.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Đã xảy ra lỗi khi thêm bộ câu hỏi: ' . $e->getMessage());
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $quiz = Quiz::findOrFail($id);
        $competition = $quiz->competition;

        return view('admin.pages.p17.online-exams.quizzes.ce', compact('quiz', 'competition'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'quantity_question' => 'required|integer|min:1',
                'status' => 'required|in:active,inactive,completed',
            ], [
                'title.required' => 'Tiêu đề không được để trống.',
                'title.string' => 'Tiêu đề phải là một chuỗi ký tự.',
                'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
                'quantity_question.required' => 'Số lượng câu hỏi không được để trống.',
                'quantity_question.integer' => 'Số lượng câu hỏi phải là một số nguyên.',
                'quantity_question.min' => 'Số lượng câu hỏi phải lớn hơn hoặc bằng 1.',
                'status.required' => 'Trạng thái không được để trống.',
                'status.in' => 'Trạng thái không hợp lệ. Vui lòng chọn Hoạt động, Không hoạt động hoặc Hoàn thành.',
            ]);


            $quiz = Quiz::findOrFail($id);
            $quiz->update([
                'title' => $request->title,
                'quantity_question' => $request->quantity_question,
                'status' => $request->status,
            ]);

            return redirect()->route('quizzes.index', $quiz->competition_id)
                ->with('success', 'Bộ câu hỏi đã được cập nhật thành công.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Đã xảy ra lỗi khi cập nhật bộ câu hỏi: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $quiz = Quiz::findOrFail($id);
            $quiz->delete();

            return redirect()->route('quizzes.index', $quiz->competition_id)
                ->with('success', 'Bộ câu hỏi đã được xóa thành công.');
        } catch (ModelNotFoundException $e) {
            Log::error('Lỗi khi xóa bộ câu hỏi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Bộ câu hỏi không tồn tại. Vui lòng thử lại.');
        }
    }
}
