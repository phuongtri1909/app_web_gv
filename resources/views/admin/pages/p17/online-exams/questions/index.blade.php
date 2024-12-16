@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        .table th,
        .table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: center;
            word-break: break-word;
            max-width: 250px;
            overflow: hidden;
            white-space: normal;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: center;
        }

        .table td {
            word-wrap: break-word;
        }

        .table td li {
            border-bottom: 1px solid #dee2e6;
            word-break: break-word;
            white-space: normal;
            padding: 10px;
            overflow: hidden;
        }

        .table td li:last-child {
            border-bottom: none;
        }

        .table tbody tr:last-child td {
            border-top: 1px solid #dee2e6;
            border-left: 1px solid #dee2e6;
            border-right: 1px solid #dee2e6;
        }

        .table td p {
            max-width: 200px;
            word-break: break-word;
            overflow: hidden;
            white-space: normal;
        }

        .table td ul {
            padding-left: 0;
        }
    </style>
@endpush

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ $type == 'survey-p' ? 'Danh sách câu hỏi khảo sát' : 'Danh sách câu hỏi'}}-{{ $quiz->title }}</h5>
                        </div>
                        <div>
                            <a href="{{ route('questions.create', ['type' => $type,'quizId' => $quiz->id]) }}" class="btn btn-primary">Thêm
                                câu
                                hỏi</a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        @if ($questions->count() > 0)
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên câu hỏi</th>
                                        <th>Đáp án</th>
                                        <th>Đáp án đúng</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($questions as $key => $question)
                                        <tr>

                                            <td>{{ $key + 1 }}</td>

                                            <td>{{ $question->question_name }}</td>

                                            <td>
                                                @php
                                                    $answers = is_string($question->answer)
                                                        ? json_decode($question->answer, true)
                                                        : $question->answer;
                                                @endphp
                                                @if (is_array($answers))
                                                    <ul class="mb-0">
                                                        @foreach ($answers as $key => $value)
                                                            <li>{{ $value }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <p>Không có đáp án</p>
                                                @endif
                                            </td>

                                            <td>
                                                @php
                                                    $correctAnswer = isset($answers[$question->answer_true]) ? $answers[$question->answer_true] : 'Chưa có đáp án đúng';
                                                @endphp
                                                {{ $correctAnswer }}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('questions.edit',['type' => $type, 'id' => $question->id]) }}"><i
                                                        class="fa-regular fa-pen-to-square"></i></a>

                                                @include('admin.pages.components.delete-form', [
                                                    'id' => $question->id, 'type' => $type,
                                                    'route' => route('questions.destroy',['type' => $type, 'id' => $question->id]),
                                                    'message' => __('Bạn có chắc chắn muốn xóa?'),
                                                ])
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-center">Không có câu hỏi nào.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
