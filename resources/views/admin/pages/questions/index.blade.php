@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        .btn-cus {
            font-size: 10px;
            padding: 10px !important;
            display: flex;
            justify-content: center;
            align-items: center;
            text-transform: unset;
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
                            <h5 class="mb-0">{{ __('list_of_questions') }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @include('admin.pages.notification.success-error')
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class=" text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('stt') }}</th>
                                    <th class=" text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('name') }}</th>
                                    <th class=" text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('phone') }}</th>
                                    <th class=" text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('email') }}</th>
                                    <th class=" text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('question') }}</th>
                                    <th class=" text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('category') }}</th>
                                    <th class="text-center  text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('answers') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questions as $index => $question)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ e($question->name) }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ e($question->phone) }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ e($question->email) }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0"  style="word-break: break-all;">{{ e($question->content) }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ e($question->category->name ?? __('uncategorized')) }}</p>
                                        </td>
                                        <td class="text-center">
                                            @if ($question->answers->isNotEmpty())
                                                <button type="button" class="btn btn-success btn-cus"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $question->id }}">{{ __('replied') }}</button>
                                                @include('admin.pages.components.delete-form', [
                                                    'id' => $question->id,
                                                    'route' => route('admin.questions.destroy', [
                                                        'id' => $question->id,
                                                    ]),
                                                    'message' => __('delete_question'),
                                                ])
                                            @else
                                                <button type="button" class="btn btn-primary btn-cus"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#replyModal{{ $question->id }}">{{ __('reply') }}</button>
                                            @endif
                                        </td>

                                    </tr>

                                    <div class="modal fade" id="replyModal{{ $question->id }}" tabindex="-1"
                                        aria-labelledby="replyModalLabel{{ $question->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="replyModalLabel{{ $question->id }}"
                                                        style="font-size: 14px;word-break: break-all;">{{ __('answer_the_question') }}:
                                                        {{ e($question->content) }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.answers.store') }}" method="POST"
                                                    id="replyForm{{ $question->id }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <input type="hidden" name="question_id"
                                                            value="{{ $question->id }}">
                                                        <div class="form-group">
                                                            <label for="category_id">{{ __('category') }}</label>
                                                            <select name="category_id" class="form-control" required>
                                                                <option value="" disabled>{{ __('select_category') }}</option>
                                                                 @foreach ($categories as $category)
                                                                    <option value="{{ $category->id }}">{{ e($category->name) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label
                                                                for="answerTitle{{ $question->id }}">{{ __('title') }}</label>
                                                            <input type="text" name="title" class="form-control"
                                                                id="answerTitle{{ $question->id }} "
                                                                value="{{ old('title') }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label
                                                                for="answerContent{{ $question->id }}">{{ __('content') }}</label>
                                                            <textarea name="content" class="form-control" id="answerContent{{ $question->id }}" rows="3" required>{{ old('content') }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label
                                                                for="answerImage{{ $question->id }}">{{ __('image') }}</label>
                                                            <input type="file" name="image" class="form-control"
                                                                id="answerImage{{ $question->id }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">{{ __('close') }}</button>
                                                        <button type="submit"
                                                            class="btn btn-primary">{{ __('send') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal sửa câu trả lời -->
                                    <div class="modal fade" id="editModal{{ $question->id }}" tabindex="-1"
                                        aria-labelledby="editModalLabel{{ $question->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel{{ $question->id }}"
                                                        style="font-size: 14px;word-break: break-all;">{{ __('edit_answer') }}:
                                                        {{ e($question->content) }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.answers.update') }}" method="POST"
                                                    id="editForm{{ $question->id }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <input type="hidden" name="question_id"
                                                            value="{{ $question->id }}">
                                                        <div class="form-group">
                                                            <label for="category_id">{{ __('category') }}</label>
                                                            <select name="category_id" class="form-control" required>
                                                                <option value="" disabled>{{ __('select_category') }}</option>
                                                                @foreach ($categories as $category)
                                                                    <option value="{{ $category->id }}" {{ $question->category_id == $category->id ? 'selected' : '' }}>
                                                                        {{ e($category->name) }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label
                                                                for="editTitle{{ $question->id }}">{{ __('title') }}</label>
                                                            <input type="text" name="title" class="form-control"
                                                                id="editTitle{{ $question->id }}"
                                                                value="{{ old('title', $question->answers->first()->title ?? '') }}"
                                                                required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label
                                                                for="editContent{{ $question->id }}">{{ __('content') }}</label>
                                                            <textarea name="content" class="form-control" id="editContent{{ $question->id }}" rows="3" required>{{ old('content', $question->answers->first()->content ?? '') }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label
                                                                for="editImage{{ $question->id }}">{{ __('image') }}</label>
                                                            <input type="file" name="image" class="form-control"
                                                                id="editImage{{ $question->id }}">


                                                            @if ($question->answers->first()->image ?? '')
                                                                <div class="mt-2">
                                                                    <label>{{ __('current_image') }}</label>
                                                                    <div class="form-control-image">
                                                                        <img src="{{ asset($question->answers->first()->image) ?? '' }}"
                                                                            alt="Image" class="img-thumbnail"
                                                                            height="100" width="150">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">{{ __('close') }}</button>
                                                        <button type="submit"
                                                            class="btn btn-primary">{{ __('update') }}</button>
                                                    </div>
                                                </form>
                                                {{-- @php dd(e($question->answers->first()->title)); @endphp --}}

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    <script src="https://cdn.tiny.cloud/1/94rfxe6iw4a63rhexl9m1wnjy9xkor08bhxft539qnuxepbv/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('textarea[id^="answerContent"], textarea[id^="editContent"]').forEach(
                function(textarea) {
                    tinymce.init({
                        selector: `#${textarea.id}`,
                        height: 300,
                        plugins: "  advlist  anchor  autolink autoresize autosave  charmap  code codesample directionality editimage emoticons  fullscreen help image importcss  insertdatetime link linkchecker lists media    nonbreaking pagebreak   preview quickbars save searchreplace table  template tinydrive   visualblocks visualchars wordcount",
                        toolbar: 'undo redo | formatselect | bold italic backcolor | \
                                                                          alignleft aligncenter alignright alignjustify | \
                                                                          bullist numlist outdent indent | removeformat | table',
                        toolbar_mode: 'floating',
                        setup: function(editor) {
                            editor.on('change', function() {
                                tinymce.triggerSave();
                            });
                        }
                    });
                });


            $('form[id^="replyForm"]').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var questionId = form.find('input[name="question_id"]').val();
                var modalId = `#replyModal${questionId}`;
                var row = form.closest('tr');
                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.invalid-feedback').remove();
                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $(form.closest('.modal')).modal('hide');

                            row.find('td.text-center').html(
                                '<button type="button" class="btn btn-success btn-sm">Đã trả lời</button>'
                            );

                            form[0].reset();

                            alert(response.message);

                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseJSON); 
                        var errors = xhr.responseJSON.errors;

                        if (errors) {
                            $.each(errors, function(field, messages) {
                                var input = form.find(`[name="${field}"]`);
                                input.addClass('is-invalid');
                                input.after('<div class="invalid-feedback">' + messages
                                    .join('<br>') + '</div>');
                            });
                        } else {
                            alert('Đã xảy ra lỗi, vui lòng thử lại.');
                        }
                    }
                });
            });
            $('form[id^="editForm"]').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var answerId = form.find('input[name="answer_id"]').val();
                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.invalid-feedback').remove();

                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $(form.closest('.modal')).modal('hide');
                            alert(response.message || 'Cập nhật thành công!');
                        } else {
                            alert(response.error || 'Đã xảy ra lỗi, vui lòng thử lại.1');
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;

                        if (errors) {
                            $.each(errors, function(field, messages) {
                                var input = form.find(`[name="${field}"]`);
                                input.addClass('is-invalid');
                                input.after('<div class="invalid-feedback">' + messages
                                    .join('<br>') + '</div>');
                            });
                        } else {
                            alert('Đã xảy ra lỗi, vui lòng thử lại. 2');
                        }
                    }
                });
            });
        });
    </script>
@endpush
