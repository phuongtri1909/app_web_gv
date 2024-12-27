@extends('admin.layouts.app')

@push('styles-admin')
    <style>
    .answer-row {
        display: flex;
        align-items: center;
        gap: 10px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        transition: box-shadow 0.3s;
    }

    .answer-row:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .input-group-append {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-check-input {
        cursor: pointer;
        transform: scale(1.2);
        margin-right: 5px;
        background-color: teal;
    }

    .form-control {
        flex: 1;
        border-radius: 10px !important;
    }
    .input-group .form-control:not(:first-child) {
         border-left: 0;
         padding-left: 10px;
    }
    .remove-answer {
        background-color: transparent;
        color: #f44336;
        border: none;
        cursor: pointer;
        font-size: 18px;
        transition: color 0.3s;
    }

    .remove-answer:hover {
        color: #d32f2f;
    }
    #answers-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    </style>
@endpush

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">{{ isset($question) ? 'Chỉnh sửa câu hỏi' : 'Thêm mới câu hỏi' }}</h5>
                </div>
                <div class="card-body px-4 pt-4 pb-2">
                    <form
                        action="{{ isset($question) ? route('questions.update', ['type' => $type, 'id' => $question->id]) : route('questions.store', ['type' => $type, 'quizId' => $quiz->id]) }}"
                        method="POST">
                        @csrf
                        @if (isset($question))
                            @method('PUT')
                        @endif

                        <div class="form-group mb-3">
                            <label for="question_name" class="form-label">Câu hỏi</label>
                            <input type="text" name="question_name" id="question_name"
                                class="form-control @error('question_name') is-invalid @enderror"
                                value="{{ old('question_name', $question->question_name ?? '') }}"
                                placeholder="Nhập nội dung câu hỏi" required>
                            @error('question_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Đáp án</label>
                            <div id="answers-container">
                                @php
                                    $answers = old(
                                        'answers',
                                        isset($question) ? json_decode($question->answer, true) : [],
                                    );
                                    $answerTrue = old('answer_true', isset($question) ? $question->answer_true : '');
                                @endphp

                                @foreach ($answers as $key  => $value)
                                    @php
                                        $originalKey = base64_decode($key);
                                    @endphp
                                    <div class="input-group mb-2 answer-row" data-key="{{ $key }}">
                                        @if ($type !== 'survey-p')
                                            <div class="input-group-append">
                                                <input type="radio" name="answer_true" value="{{ $key }}"
                                                    class="form-check-input @error('answer_true') is-invalid @enderror"
                                                    id="answer_true_{{ $key }}"
                                                    {{ old('answer_true', isset($question) ? $question->answer_true : '') === $key ? 'checked' : '' }}>
                                            </div>
                                        @endif
                                        <input type="text" name="answers[{{ $key }}]"
                                            class="form-control @error('answers.' . $key) is-invalid @enderror"
                                            value="{{ old('answers.' . $key, $value) }}" placeholder="Nhập đáp án" required>
                                        <button type="button" class="remove-answer"><i class="fas fa-times"></i></button>
                                        @error('answers.' . $key)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-success mt-2" id="add-answer">Thêm đáp án</button>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('questions.index', ['type' => $type, 'quizId' => $quiz->id]) }}" class="btn btn-secondary me-2">Hủy</a>
                            <button type="submit"
                                class="btn btn-primary">{{ isset($question) ? 'Cập nhật' : 'Thêm mới' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const type = '{{ $type }}';
            const answersContainer = document.getElementById('answers-container');
            const addAnswerButton = document.getElementById('add-answer');
            const answerTrueRadio = document.getElementById('answer-true');

            let answerKeyCount = 0;

            function generateUniqueKey() {
                return 'answer' + Math.random().toString(36).substr(2, 8);
            }


            function updateAnswerOptions() {
                const rows = answersContainer.querySelectorAll('.answer-row');
                rows.forEach((row, index) => {
                    const textInput = row.querySelector('input[type=text]');
                    const radio = row.querySelector('input[type=radio]');
                    const key = row.dataset.key;


                    textInput.name = `answers[${key}]`;
                    if (radio) {
                        radio.value = key;
                        if (radio.checked) {
                            answerTrueRadio.value = key;
                        }
                    }
                });
            }


            addAnswerButton.addEventListener('click', function () {
                const key = generateUniqueKey();
                const newRow = document.createElement('div');
                newRow.classList.add('input-group', 'mb-2', 'answer-row');
                newRow.dataset.key = key;

                newRow.innerHTML = `
                    ${type !== 'survey-p' ? `
                    <div class="input-group-append">
                        <input type="radio" name="answer_true" value="${key}" class="form-check-input">
                    </div>` : ''}
                    <input type="text" class="form-control" name="answers[${key}]" placeholder="Nhập đáp án" required>
                    <button type="button" class="remove-answer"><i class="fas fa-times"></i></button>
                `;
                answersContainer.appendChild(newRow);


                updateAnswerOptions();
            });


            answersContainer.addEventListener('click', function (event) {
                if (event.target.closest('.remove-answer')) {
                    const rowToRemove = event.target.closest('.answer-row');
                    rowToRemove.remove();
                    updateAnswerOptions();
                }
            });

            updateAnswerOptions();
        });



    </script>
@endpush
