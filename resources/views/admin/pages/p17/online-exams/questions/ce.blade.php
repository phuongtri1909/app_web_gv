@extends('admin.layouts.app')

@push('styles-admin')
<style>
.remove-answer {
    background-color: #f44336; 
    color: white; 
    border: none;
    border-radius: 4px;
    padding: 5px 10px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.remove-answer:hover {
    background-color: #d32f2f; 
}

.remove-answer i {
    margin-right: 5px; 
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
                        action="{{ isset($question) ? route('questions.update', [$question->id]) : route('questions.store', $quiz->id) }}"
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
                                @endphp

                                @foreach ($answers as $key => $value)
                                    <div class="input-group mb-2 answer-row">
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

                        <div class="form-group mb-3">
                            <label for="answer_true" class="form-label">Đáp án đúng</label>
                            <select name="answer_true" id="answer_true"
                                class="form-control @error('answer_true') is-invalid @enderror">
                                @foreach ($answers as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ old('answer_true', isset($question) ? $question->answer_true : '') === $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>

                            @error('answer_true')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                        <div class="d-flex justify-content-end">
                            <a href="{{ route('questions.index', $quiz->id) }}" class="btn btn-secondary me-2">Hủy</a>
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
        document.addEventListener('DOMContentLoaded', function() {
            const answersContainer = document.getElementById('answers-container');
            const addAnswerButton = document.getElementById('add-answer');
            const answerTrueSelect = document.getElementById('answer_true');

            let key = 0;
            function updateAnswerOptions() {
                answerTrueSelect.innerHTML = '';
                const inputs = answersContainer.querySelectorAll('.answer-row input');

                inputs.forEach((input, index) => {
                    const value = input.value;
                    const option = document.createElement('option');
                    option.value = key + index;
                    option.textContent = `${value}`;
                    answerTrueSelect.appendChild(option);
                });
            }

            addAnswerButton.addEventListener('click', () => {
                const newRow = document.createElement('div');
                newRow.classList.add('input-group', 'mb-2', 'answer-row');
                newRow.innerHTML = `
                <input type="text" class="form-control" name="answers[${++key}]" value="" placeholder="Nhập đáp án" required>
                <button type="button" class="remove-answer"><i class="fas fa-times"></i></button>
            `;
                answersContainer.appendChild(newRow);
                updateAnswerOptions();
            });

            answersContainer.addEventListener('input', (event) => {
                if (event.target.tagName.toLowerCase() === 'input') {
                    updateAnswerOptions();
                }
            });

            answersContainer.addEventListener('click', (event) => {
                if (event.target.closest('.remove-answer')) {
                    event.target.closest('.answer-row').remove();
                    updateAnswerOptions();
                    if (answerTrueSelect.value === '') {
                        answerTrueSelect.selectedIndex = 0;
                    }
                }
            });

            updateAnswerOptions();
        });
    </script>
@endpush
