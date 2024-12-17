@extends('pages.client.p17.layouts.app')
@section('title', 'Danh sách bộ câu hỏi')
@section('description', 'Danh sách bộ câu hỏi')
@section('keyword', 'Danh sách bộ câu hỏi')

@push('styles')
    <style>
        .contest-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
        }

        .form-actions button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
        }

        .back-btn {
            background-color: #fff;
            border: 1px solid #007bff;
            color: #007bff;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 4px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease, transform 0.3s ease;
        }

        .back-btn:hover {
            color: #007bff;
            border-color: #0056b3;
            transform: translateY(-2px);
        }

        .back-icon {
            margin-right: 8px;
            font-size: 16px;
        }

        .contest-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .contest-item {
            padding: 20px;
            background-color: #fff;
            transition: box-shadow 0.3s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .contest-item:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .contest-title {
            font-size: 20px;
            margin-bottom: 10px;
            color: #ef0c0c;
            font-weight: bold;
        }


        .contest-details p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;

        }

        .btn {
            background: linear-gradient(90deg, #0C63E7, #07C8F9);
            border: none;
            border-radius: 30px;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            padding: 6px 20px;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .contest-container {
                padding: 15px;
            }

            .contest-item {
                padding: 15px;
            }

            .contest-title {
                font-size: 18px;
            }

            .contest-details p {
                font-size: 13px;
            }

            .back-button button {
                font-size: 13px;
            }
        }
    </style>
@endpush

@push('scripts')
@endpush

@section('content')
    <section id="list-quizs">
        <div class="contest-container">
            <div class="form-actions my-2">
                <button type="button" onclick="history.back()" class="back-btn">
                    <i class="fa-solid fa-arrow-left back-icon"></i> Back
                </button>
                @if(Session::has('user_full_name'))
                    <p class="user-greeting">Chào, {{ Session::get('user_full_name') }}!</p>
                @endif
            </div>
            <div class="contest-list">
                @foreach ($quizzes as $quiz)
                    <div class="contest-item">
                        <h2 class="contest-title">{{ $quiz->title }}</h2>
                        <div class="contest-details">
                            <p><strong>Thời gian:</strong>
                                {{ \Carbon\Carbon::parse($competition->start_date)->format('d/m/Y H:i') }}
                                <span>-</span>
                                {{ \Carbon\Carbon::parse($competition->end_date)->format('d/m/Y H:i') }}
                            </p>
                            <p><strong>Số câu hỏi:</strong> {{ $quiz->quantity_question }}</p>
                            <p><strong>Thời gian làm bài:</strong> {{ $competition->time_limit }} phút</p>
                        </div>
                        <div class="text-center mt-2">
                            {{-- @if ($usersOnlineExam->hasUserTakenQuiz($quiz->id))
                                <p class="btn btn-primary btn-sm" disabled >Đã làm bài</p>
                            @else --}}
                                <a href="{{ route('p17.start.online.exams.client', ['quizId' => $quiz->id]) }}" class="btn btn-primary btn-sm">Bắt đầu thi</a>
                            {{-- @endif --}}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
