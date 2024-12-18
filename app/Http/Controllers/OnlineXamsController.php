<?php

namespace App\Http\Controllers;

use App\Models\Competition;
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

    public function registerOnline(Request $request)
    {
        // dd($request->get('customer_id'));

        $wards = WardGovap::all();
        return view('pages.client.p17.online-exams.register-online', compact('wards'));
    }

    public function submitCompetitionsOnline(Request $request)
    {
        try {
            $validated = $request->validate([
                'cccd' => 'required|string|regex:/^[0-9]{12}$/',
                'phone' => 'required|string|max:10|regex:/^[0-9]+$/',
                'name' => 'required|string|max:100',
                'dob' => [
                    'required',
                    'date',
                    'before_or_equal:today',
                    function ($attribute, $value, $fail) {
                        $year = \Carbon\Carbon::parse($value)->year;
                        $currentYear = \Carbon\Carbon::now()->year;
                        if ($year == $currentYear) {
                            $fail('Năm sinh không thể là năm hiện tại (' . $currentYear . ').');
                        }
                    }
                ],
                'ward' => 'nullable|string|max:100',
                'village' => 'nullable|string|max:100',
                'captcha' => 'required|string',
            ], [
                'cccd.required' => 'CCCD là bắt buộc.',
                'cccd.regex' => 'CCCD phải bao gồm 12 chữ số.',
                'phone.required' => 'Số điện thoại là bắt buộc.',
                'phone.regex' => 'Số điện thoại chỉ được phép chứa các chữ số.',
                'phone.max' => 'Số điện thoại không được vượt quá 10 chữ số.',
                'name.required' => 'Tên là bắt buộc.',
                'name.max' => 'Tên không được vượt quá 100 ký tự.',
                'dob.required' => 'Ngày sinh là bắt buộc.',
                'dob.date' => 'Ngày sinh phải là một ngày hợp lệ.',
                'captcha.required' => 'Captcha là bắt buộc.',
            ]);

            if ($request->input('captcha') !== session('captcha_code')) {
                return redirect()->back()->with('error', 'Mã captcha không đúng.')->withInput();
            }

            $userOnlineExam = UsersOnlineExam::firstOrNew([
                'identity_card_number' => $request->input('cccd'),
            ]);

            // Check if the user is already registered in a competition or survey
            if ($userOnlineExam->exists) {
                Session::put('user_id', $userOnlineExam->id);
                Session::put('user_full_name', $userOnlineExam->full_name);


                $competitionType = $userOnlineExam->competition_type;
                if ($competitionType == 'competition') {
                    return redirect()->route('p17.list.competitions.exams.client')->with('success', 'Bạn đã tham gia cuộc thi thành công! Chúc may mắn.');
                } else {
                    return redirect()->route('p17.list.surveys.client')->with('success', 'Bạn đã tham gia khảo sát thành công!');
                }
            }

            // Save new user
            $userOnlineExam->fill([
                'full_name' => $request->input('name'),
                'phone_number' => $request->input('phone'),
                'date_of_birth' => $request->input('dob'),
                'wards_id' => $request->input('ward'),
                'street_number' => $request->input('village'),
            ]);
            $userOnlineExam->save();

            Session::put('user_id', $userOnlineExam->id);
            Session::put('user_full_name', $userOnlineExam->full_name);
            $competitionType = $userOnlineExam->competition_type;
            if ($competitionType == 'competition') {
                return redirect()->route('p17.list.competitions.exams.client')->with('success', 'Bạn đã tham gia cuộc thi thành công! Chúc may mắn.');
            } else {
                return redirect()->route('p17.list.surveys.client')->with('success', 'Bạn đã tham gia khảo sát thành công!');
            }
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Error submitting competition online: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi, vui lòng thử lại!')->withInput();
        }
    }



    public function listCompetitionsOnline()
    {
        // if (!Session::has('user_id')) {
        //     return redirect()->route('p17.online.xams.client.index')->with('error', 'Bạn phải đăng ký tham gia cuộc thi.');
        // }

        $competitions = Competition::with('quizzes')
        ->where('status', 'active')
        ->where('type', 'competition')
        ->get();
        // dd($competitions); 
        return view('pages.client.p17.online-exams.list-competitions', compact('competitions'));
    }

    public function listQuizOnline($competitionId)
    {
        // if (!Session::has('user_id')) {
        //     return redirect()->route('p17.online.xams.client.index')->with('error', 'Bạn phải đăng ký tham gia cuộc thi.');
        // }

        $competition = Competition::findOrFail($competitionId);
        $quizzes = Quiz::where('competition_id', $competitionId)->where('status', 'active')->get();

        if ($quizzes->isEmpty()) {
            if($competition->type == 'survey-p'){
                return redirect()->route('p17.list.surveys.client')
                ->with('error', 'Cuộc thi hiện không có bộ câu hỏi nào để tham gia.');
            }else{
                return redirect()->route('p17.list.competitions.exams.client')
                ->with('error', 'Cuộc thi hiện không có bộ câu hỏi nào để tham gia.');
            }
        }

        $competition->number_of_quizzes = $quizzes->count();

        return view('pages.client.p17.online-exams.list-quizs', compact('competition', 'quizzes'));
    }





    public function listQuestionsOnline($competitionId)
    {
        // if (!Session::has('user_id')) {
        //     return redirect()->route('p17.online.xams.client.index')
        //         ->with('error', 'Bạn phải đăng ký tham gia cuộc thi.');
        // }

        $userId = Session::get('user_id');
        $usersOnlineExam = UsersOnlineExam::where('id', $userId)->first();
        $competition = Competition::findOrFail($competitionId);
        $quizzes = $competition->quizzes()->where('status', 'active')->get();

        return view('pages.client.p17.online-exams.list-questions', compact('competition', 'quizzes', 'usersOnlineExam'));
    }


    public function startOnlineExams($quizId)
    {
        // if (!Session::has('user_id')) {
        //     return redirect()->route('p17.online.xams.client.index')->with('error', 'Bạn phải đăng ký tham gia cuộc thi.');
        // }
        $quiz = Quiz::with('questions')->findOrFail($quizId);
        $competition = $quiz->competition;
        $timeLimit = $competition->time_limit;
        $startTime = now();
        Session::put('start_time', $startTime);
        if ($quiz->questions->isEmpty()) {
            return redirect()->route('p17.list.competitions.exams.client')
                ->with('error', 'Bài thi này chưa có câu hỏi, không vào thi được!.');
        }
        $questions = $quiz->questions()->paginate(5);

        foreach ($questions as $question) {
            $question->options = json_decode($question->answer, true);
        }
        $userId = Session::get('user_id');
        $usersOnlineExam = UsersOnlineExam::where('id', $userId)->first();
        if ($usersOnlineExam->hasUserTakenQuiz($quizId)) {
            return redirect()->route('p17.list.competitions.exams.client')
                ->with('error', 'Thi rồi mà sao lại vô nữa !!!.');
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


            UsersOnlineExamAnswer::create([
                'users_online_exam_id' => Session::get('user_id'),
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
        $correctAnswersCount = $request->input('correctAnswersCount');
        $incorrectAnswersCount = $request->input('incorrectAnswersCount');
        $totalQuestions = $request->input('totalQuestions');
        $notAnsweredCount = $request->input('notAnsweredCount');

        $userAnswers = UsersOnlineExamAnswer::where('users_online_exam_id', Session::get('user_id'))
            ->whereIn('question_id', $quiz->questions->pluck('id'))
            ->get();

        return view('pages.client.p17.online-exams.result-user-online-exam', compact(
            'quiz',
            'correctAnswersCount',
            'incorrectAnswersCount',
            'totalQuestions',
            'userAnswers',
            'notAnsweredCount'
        ));
    }

    public function forgetSession(Request $request)
    {
        $request->session()->forget('user_full_name');
        $request->session()->forget('user_id');
        return response()->json(['message' => 'Session deleted successfully']);
    }

    public function listSurveys(Request $request)
    {
        // if (!Session::has('user_id')) {
        //     return redirect()->route('p17.online.xams.client.index')->with('error', 'Bạn phải đăng ký tham gia cuộc thi.');
        // }

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
