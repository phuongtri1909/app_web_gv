<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Customer;
use App\Models\Quiz;
use App\Models\UsersOnlineExam;
use App\Models\UsersOnlineExamAnswer;
use App\Models\WardGovap;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OnlineXamsController extends Controller
{

    public function authZalo()
    {
        return view('pages.client.p17.online-exams.index');
    }

    public function listCompetitionsOnline(Request $request)
    {

        $customer_id = $request->get('customer_id');
        dd($customer_id);
        $competitions = Competition::with('quizzes')
        ->where('status', 'active')
        ->where('type', 'competition')
        ->get();
        // dd($competitions); 
        return view('pages.client.p17.online-exams.list-competitions', compact('competitions'));
    }

    public function listQuizOnline($competitionId)
    {
        $competition = Competition::findOrFail($competitionId);
        $quizzes = Quiz::where('competition_id', $competitionId)->where('status', 'active')->get();

        if ($quizzes->isEmpty()) {
            if($competition->type == 'survey-p'){
                return redirect()->route('p17.list.surveys.client')
                ->with('error', 'Khảo sát hiện không có bộ câu hỏi nào để tham gia.');
            }else{
                return redirect()->route('p17.list.competitions.exams.client')
                ->with('error', 'Cuộc thi hiện không có bộ câu hỏi nào để tham gia.');
            }
        }
        $competition->number_of_quizzes = $quizzes->count();

        return view('pages.client.p17.online-exams.list-quizs', compact('competition', 'quizzes'));
    }





    public function listQuestionsOnline(Request $request, $competitionId)
    {


        $customer_id = $request->get('customer_id');
        $usersOnlineExam = Customer::where('id', $customer_id)->first();
        $competition = Competition::findOrFail($competitionId);
        $quizzes = $competition->quizzes()->where('status', 'active')->get();

        return view('pages.client.p17.online-exams.list-questions', compact('competition', 'quizzes', 'usersOnlineExam'));
    }


    public function startOnlineExams(Request $request, $quizId)
    {

        $quiz = Quiz::with('questions')->findOrFail($quizId);
        $competition = $quiz->competition;
        $timeLimit = $competition->time_limit;
        $startTime = now();
        Session::put('start_time', $startTime);
        if ($quiz->questions->isEmpty()) {
            if($competition->type == 'survey-p'){
                return redirect()->route('p17.list.surveys.client')
                ->with('error', 'Khảo sát này chưa có câu hỏi, không vào thi được!');
            }else{
                return redirect()->route('p17.list.competitions.exams.client')
                ->with('error', 'Bài thi này chưa có câu hỏi, không vào thi được!');
            }
        }
        $questions = $quiz->questions()->paginate(5);

        foreach ($questions as $question) {
            $question->options = json_decode($question->answer, true);
        }
        $customer_id = $request->get('customer_id');
        $usersOnlineExam = Customer::where('id', $customer_id)->first();
        if ($usersOnlineExam->hasUserTakenQuiz($quizId)) {
            if($competition->type == 'survey-p'){
                return redirect()->route('p17.list.surveys.client')
                    ->with('error', 'Bạn đã khảo sát!.');
            }else{
                 return redirect()->route('p17.list.competitions.exams.client')
                    ->with('error', 'Bạn đã thi !!');
            }
        }

        $type = $competition->type;
        if (!$type || !in_array($type, ['survey', 'competition'])) {
            return redirect()->back()->with('error', 'Không xác định được loại bài thi.');
        }
        if (request()->ajax()) {
            return response()->json([
                'questions' => $questions,
                'timeLimit' => $timeLimit,
                'startTime' => $startTime,
            ]);
        }
        return view('pages.client.p17.online-exams.start-online-exams', compact('quiz', 'timeLimit', 'startTime'));
    }



    public function submitQuiz(Request $request, $quizId)
    {
        $validated = $request->validate([
            'start_time' => 'required',
            'submission_time' => 'required',
        ], [
            'start_time.required' => 'Thời gian bắt đầu là bắt buộc.',
            'submission_time.required' => 'Thời gian nộp bài là bắt buộc.',
        ]);


        $quiz = Quiz::with('questions')->findOrFail($quizId);

        $correctAnswersCount = 0;
        $incorrectAnswersCount = 0;
        $notAnsweredCount = 0;
        foreach ($quiz->questions as $question) {
            $selectedAnswer = $request->input("question_{$question->id}");
            if (!$selectedAnswer) {
                $selectedAnswer = 'not_answered';
                $notAnsweredCount++;
            } else if ($selectedAnswer === $question->answer_true) {
                $correctAnswersCount++;
            } else if ($selectedAnswer !== 'not_answered') {
                $incorrectAnswersCount++;
            }

            $start_time_vn = Carbon::parse($validated['start_time'])->setTimezone('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
            $submission_time_vn = Carbon::parse($validated['submission_time'])->setTimezone('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');

            $customer_id = $request->get('customer_id');
            UsersOnlineExamAnswer::create([
                'customer_id' =>   $customer_id,
                'question_id' => $question->id,
                'status' => $selectedAnswer,
                'start_time' => $start_time_vn,
                'submission_time' => $submission_time_vn,
            ]);
        }
        $totalQuestions = $quiz->questions->count();
        return response()->json([
            'redirectUrl' => route('p17.list.quiz.result.client', [
                'quizId' => $quizId,
                'correctAnswersCount' => $correctAnswersCount,
                'incorrectAnswersCount' => $incorrectAnswersCount,
                'notAnsweredCount' => $notAnsweredCount,
                'totalQuestions' => $totalQuestions,
            ]),
        ]);
    }
    public function listQuizResult(Request $request, $quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $customer_id = $request->get('customer_id');
        $correctAnswersCount = $request->input('correctAnswersCount');
        $incorrectAnswersCount = $request->input('incorrectAnswersCount');
        $totalQuestions = $request->input('totalQuestions');
        $notAnsweredCount = $request->input('notAnsweredCount');

        $userAnswers = UsersOnlineExamAnswer::where('customer_id',$customer_id)
            ->whereIn('question_id', $quiz->questions->pluck('id'))
            ->get();
        $type = $quiz->competition->type;
        if (!$type || !in_array($type, ['survey', 'competition'])) {
            return redirect()->back()->with('error', 'Không xác định được loại bài thi.');
        }

        return view('pages.client.p17.online-exams.result-user-online-exam', compact(
            'quiz',
            'correctAnswersCount',
            'incorrectAnswersCount',
            'totalQuestions',
            'userAnswers',
            'notAnsweredCount',
            'type'
        ));
    }

    public function listSurveys(Request $request)
    {

        $competitions = Competition::where('status', 'active')->where('type', 'survey-p')->get()->map(function ($competition) {
            $now = Carbon::now();

            if ($now->lessThan($competition->start_date)) {
                $competition->calculated_status = 'Sắp diễn ra';
                $competition->calculated_status_key = 'upcoming';
            } elseif ($now->between($competition->start_date, $competition->end_date)) {
                $competition->calculated_status = 'Đang diễn ra';
                $competition->calculated_status_key = 'ongoing';
            } elseif ($now->greaterThan($competition->end_date)) {
                $competition->calculated_status = 'Đã kết thúc';
                $competition->calculated_status_key = 'completed';
            } else {
                $competition->calculated_status = 'Không xác định';
                $competition->calculated_status_key = 'unknown';
            }
            return $competition;
        });
        return view('pages.client.p17.survey-exams.list-surveys', compact('competitions'));
    }

}
