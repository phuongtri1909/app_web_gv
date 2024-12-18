@extends('pages.client.p17.layouts.app')
@section('title', 'Danh sách cuộc thi')
@section('description', 'Danh sách cuộc thi')
@section('keyword', 'Danh sách cuộc thi')

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

        .text-end {
            display: flex;
            justify-content: center;
            /* Đưa nút ra giữa màn hình */
            padding: 20px;
        }

        .btn {
            display: block;
            /* width: 50%; */
            padding: 6px 20px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            color: #fff;
            background: linear-gradient(90deg, #0C63E7, #07C8F9);
            border: none;
            border-radius: 30px;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: linear-gradient(90deg, #0056d2, #0044b1);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
            color: #fff;
        }

        .btn:active {
            transform: translateY(2px);
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

        @media (max-width: 480px) {
            .btn {
                font-size: 14px;
                padding: 6px 20px;
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
                    <i class="fa-solid fa-arrow-left back-icon"></i> Quay lại
                </button>
            </div>
            <div class="contest-list">
                    <div class="contest-item">
                        <h2 class="contest-title">{{ $competition->title }}</h2>
                        <div class="contest-details">
                            <p><strong>Thời gian:</strong> {{ \Carbon\Carbon::parse($competition->start_date)->format('d/m/Y H:i') }} - {{ \Carbon\Carbon::parse($competition->end_date)->format('d/m/Y H:i') }}</p>
                            <p><strong>Số bộ câu hỏi: </strong>{{ $competition->number_of_quizzes }}</p>
                            <p><strong>Thời gian làm bài: </strong>{{ $competition->time_limit }} phút</p>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('p17.list.questions.client', ['competitionId' => $competition->id]) }}" class="btn">Vào thi</a>
                        </div>
                    </div>
            </div>
        </div>

    </section>
@endsection
