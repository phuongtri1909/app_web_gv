@extends('pages.client.p17.layouts.app')
@section('title', 'Thi trực tuyến')
@section('description', 'Thi trực tuyến')
@section('keyword', 'Thi trực tuyến')

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
        }

        #quiz-container h1 {
            font-size: 18px;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 800;
        }

        .question {
            margin-bottom: 20px;
        }

        .option {
            margin: 10px 0;
        }

        label {
            display: flex;
            align-items: center;
            font-size: 16px;
            color: #333;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ddd;
            cursor: pointer;
            border-color: rgba(152, 38, 93, 0.61);
            position: relative;
        }

        label:hover {
            background-color: #ffff;
            border-color: #a084ca;
        }

        input[type="radio"] {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #a084ca;
            border-radius: 50%;
            margin-right: 10px;
            position: relative;
            display: flex;
        }

        input[type="radio"]:checked {
            background-color: #a084ca;
            border-color: #a084ca;
        }

        input[type="radio"]:checked::after {
            content: '\2713';
            color: white;
            font-size: 14px;
            display: block;
            text-align: center;
            line-height: 18px;
            position: absolute;
            top: 1px;
            left: 4px;
        }

        label.selected {
            background-color: #e0d7f5;
            border-color: #a084ca;
        }

        label.selected:hover {
            background-color: #d7c8f0;
        }

        .quiz {
            margin-top: 3rem;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            const quizId = {{ $quiz->id }};
            const localStorageKey = 'quiz_answers_' + quizId;
            const startTimeKey = 'quiz_start_time_' + quizId;
            const isQuizFinishedKey = 'quiz_finished_' + quizId;
            let savedAnswers = JSON.parse(localStorage.getItem(localStorageKey)) || {};
            let formSubmitted = false;
            const $quizForm = $('#quizForm');
            const timeLimit = {{ $timeLimit }} * 60; // Giới hạn thời gian (giây)
            let remainingTime;

            // Khôi phục thời gian bắt đầu
            let startTime = JSON.parse(localStorage.getItem(startTimeKey));
            if (!startTime) {
                startTime = new Date();
                localStorage.setItem(startTimeKey, JSON.stringify(startTime));
            } else {
                startTime = new Date(startTime);
            }
            remainingTime = timeLimit - Math.floor((new Date() - startTime) / 1000);

            const isQuizFinished = localStorage.getItem(isQuizFinishedKey);
            if (isQuizFinished) {
                disableQuiz();
                return;
            }

            loadQuestions();

            function loadQuestions() {
                $.ajax({
                    url: '{{ route('p17.start.online.exams.client', ['quizId' => $quiz->id]) }}',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        const questions = response.questions.data || response.questions;
                        console.log(questions);
                        if (Array.isArray(questions)) {
                            renderQuestions(questions, isQuizFinished);
                            restoreSavedAnswers();
                        } else {
                            console.error('Expected an array for questions, but got:', questions);
                            toastr.error('Lỗi dữ liệu câu hỏi!');
                        }
                    },
                    error: function() {
                        toastr.error('Lỗi tải câu hỏi!');
                    }
                });
            }

            function renderQuestions(questions, quizSubmitted) {
                let questionsHtml = '';
                questions.forEach(function(question) {
                    questionsHtml += `
                        <div class="quiz" data-question-id="${question.id}">
                            <h3>${question.question_name}</h3>
                            ${generateOptions(question.options, question.id, quizSubmitted)}
                        </div>
                    `;
                });
                $('#questions-container').html(questionsHtml);
            }

            function generateOptions(options, questionId, quizSubmitted) {
                let optionsHtml = '';
                for (const [key, option] of Object.entries(options)) {
                    optionsHtml += `
                        <div class="option">
                            <label>
                                <input
                                    type="radio"
                                    name="question_${questionId}"
                                    value="${key}"
                                    ${quizSubmitted ? 'disabled' : ''}>
                                ${option}
                            </label>
                        </div>
                    `;
                }
                return optionsHtml;
            }

            // Xử lý chọn đáp án
            $('#questions-container').on('change', 'input[type="radio"]', function() {
                const questionId = $(this).attr('name').split('_')[1];
                savedAnswers[questionId] = $(this).val();
                localStorage.setItem(localStorageKey, JSON.stringify(savedAnswers));
                $(this).closest('.quiz').find('label').removeClass('selected');
                $(this).closest('label').addClass('selected');
            });

            function restoreSavedAnswers() {
                $('.quiz').each(function() {
                    const questionId = $(this).data('question-id');
                    if (savedAnswers[questionId]) {
                        const selectedInput = $(this).find(`input[value="${savedAnswers[questionId]}"]`);
                        selectedInput.prop('checked', true);
                        selectedInput.closest('label').addClass('selected');
                    }
                });
            }

            // Cập nhật đồng hồ đếm ngược
            let timerInterval;

            function updateTimer() {
                if (remainingTime <= 0) {
                    clearInterval(timerInterval);
                    $('#countdown-timer').text('Hết giờ!');
                    toastr.error('Hết thời gian làm bài! Bài thi sẽ được tự động nộp.');
                    submitQuiz(true);
                } else {
                    const minutes = Math.floor(remainingTime / 60);
                    const seconds = remainingTime % 60;
                    $('#countdown-timer').text(
                        `Thời gian còn lại: ${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`
                    );
                    remainingTime--;
                }
            }

            if (!isQuizFinished) {
                timerInterval = setInterval(updateTimer, 1000);
                updateTimer();
            }

            // Xử lý nộp bài
            $quizForm.on('submit', function(e) {
                e.preventDefault();
                swal({
                    title: 'Xác nhận nộp bài?',
                    text: 'Bạn chắc chắn muốn nộp bài thi?',
                    icon: 'warning',
                    buttons: ['Hủy', 'Nộp bài'],
                }).then((confirm) => {
                    if (confirm) submitQuiz(false);
                });
            });

            async function submitQuiz(autoSubmit) {
                if (formSubmitted) return;
                formSubmitted = true;

                for (const questionId in savedAnswers) {
                    $(`input[name="question_${questionId}"][value="${savedAnswers[questionId]}"]`).prop(
                        'checked', true);
                }

                dayjs.extend(dayjs_plugin_utc);
                dayjs.extend(dayjs_plugin_timezone);
                const startTimeVN = dayjs(startTime).tz('Asia/Ho_Chi_Minh').format('YYYY-MM-DD HH:mm:ss');
                const submissionTimeVN = dayjs().tz('Asia/Ho_Chi_Minh').format('YYYY-MM-DD HH:mm:ss');

                const start = dayjs(startTime).tz('Asia/Ho_Chi_Minh');
                const submission = dayjs();
                const timeDiff = submission.diff(start, 'seconds');
                const minutes = Math.floor(timeDiff / 60);
                const seconds = timeDiff % 60;
                const totalTime = `${minutes}:${seconds < 10 ? '0' + seconds : seconds}`;


                const formData = new FormData($quizForm[0]);
                formData.append('start_time', startTimeVN);
                formData.append('submission_time', totalTime);
                try {
                    const response = await fetch($quizForm.attr('action'), {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    if (response.ok) {
                        const data = await response.json();
                        localStorage.removeItem(localStorageKey);
                        localStorage.removeItem(startTimeKey);
                        localStorage.setItem(isQuizFinishedKey, true);

                        toastr.success(autoSubmit ? 'Hết giờ: Bài thi đã được nộp tự động.' :
                            'Bài thi đã được nộp thành công.');
                        disableQuiz();
                        window.location.href = data.redirectUrl;
                    } else {
                        throw new Error('Submission failed.');
                    }
                } catch (error) {
                    toastr.error('Lỗi: Không thể nộp bài thi.');
                    formSubmitted = false;
                }
            }

            function disableQuiz() {
                $('#submit-btn').replaceWith(`
                    <div class="submitted-page text-center mt-4">
                        <h2>Đã nộp bài!</h2>
                        <p>Cảm ơn bạn đã hoàn thành bài kiểm tra.</p>
                        <a href="{{ route('p17.list.competitions.exams.client') }}" class="btn btn-primary mt-3">Quay lại trang Chủ</a>
                    </div>
                `);
            }



            let tabSwitchCount = 0;
            $(document).on('visibilitychange', function() {
                if (document.hidden) {
                    tabSwitchCount++;
                    toastr.warning(`Cảnh báo: Chuyển tab ${tabSwitchCount} lần.`);
                    if (tabSwitchCount >= 3) {
                        swal('Bạn đã chuyển tab quá 3 lần, bài thi sẽ tự động nộp.', {
                            icon: 'warning'
                        });
                        submitQuiz(true);
                    }
                }
            });

            $(document).on('beforeunload', function(e) {
                if (!formSubmitted) {
                    toastr.warning(
                        'Bạn có chắc chắn muốn rời khỏi trang này? Bài thi của bạn sẽ được nộp.');
                    submitQuiz(true);
                    (e || window.event).returnValue = '';
                    return '';
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.7/dayjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.7/plugin/utc.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.10.7/plugin/timezone.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
@endpush

@section('content')
    <section id="quiz-container">
        <h1>Bài thi: {{ $quiz->title }}</h1>
        <div id="countdown-timer"></div>
        <div class="container">
            <form id="quizForm" method="POST" action="{{ route('p17.submit.quiz.client', ['quizId' => $quiz->id]) }}">
                @csrf
                <div class="quiz-container" id="questions-container">

                </div>
                <button type="submit" class="btn btn-primary" id="submit-btn">Nộp bài</button>
            </form>
        </div>
    </section>
@endsection
