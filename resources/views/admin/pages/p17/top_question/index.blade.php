@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Danh sách câu hỏi</h5>
                        </div>
                        <div>
                            <a href="{{ route('top-questions.create') }}" class="btn btn-primary">Thêm câu hỏi</a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Câu hỏi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trả lời</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topQuestions as $question)
                                    <tr>
                                        <td data-bs-toggle="collapse" data-bs-target="#collapse{{ $question->id }}" aria-expanded="false" aria-controls="collapse{{ $question->id }}">
                                            <div class="d-flex flex-column justify-content-center" style="width: 300px;">
                                                <h6 class="mb-0 text-sm">{{ $question->question }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $question->questioned_by }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm {{ $question->answer ? '' : 'bg-danger' }}">
                                                {{ $question->answer ? 'Đã trả lời' : 'Chưa trả lời' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if (!$question->answer)
                                                <form action="{{ route('top-questions.answer', $question->id) }}" method="POST" style="display:inline-block;" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row g-1">
                                                        <div class="col-12 col-md-6">
                                                            <input class="form-control form-control-sm @error('answer_' . $question->id) is-invalid @enderror" id="answer-{{ $question->id }}" type="text" name="answer_{{ $question->id }}" placeholder="Trả lời" required >
                                                            @error('answer_' . $question->id)
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="col-12 col-md-6">
                                                            <input class="form-control form-control-sm @error('linkUrl_' . $question->id) is-invalid @enderror" id="linkUrl-{{ $question->id }}" type="text" name="linkUrl_{{ $question->id }}" placeholder="Url">
                                                            @error('linkUrl_' . $question->id)
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="col-12 col-md-6">
                                                            <input class="form-control form-control-sm @error('attachment_' . $question->id) is-invalid @enderror" id="attachment-{{ $question->id }}" type="file" name="attachment_{{ $question->id }}">
                                                            @error('attachment_' . $question->id)
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="col-12 col-md-6">
                                                            <button type="submit" class="btn btn-success btn-sm"><i class="fa-regular fa-paper-plane"></i></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $question->id,
                                                'route' => route('top-questions.destroy', $question->id),
                                                'message' => __('Bạn có chắc chắn muốn xóa?'),
                                            ])
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <div class="collapse" id="collapse{{ $question->id }}">
                                                <div class="accordion-body text-start">
                                                    <strong>Trả lời:</strong>
                                                    {{ $question->answer ?? 'Chưa có câu trả lời' }}
                                                    <br>
                                                    <strong>Người trả lời:</strong> {{ $question->answered_by }}
                                                    <br>
                                                    @if ($question->linkUrl)
                                                        <strong>Link:</strong> <a href="{{ $question->linkUrl }}" target="_blank">{{ $question->linkUrl }}</a>
                                                        <br>
                                                    @endif
                                                    @if ($question->attachment)
                                                        <strong>Attachment:</strong> <a href="{{ asset($question->attachment) }}" target="_blank">Download</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <x-pagination :paginator="$topQuestions" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toggles = document.querySelectorAll('.question-toggle');
            toggles.forEach(function (toggle) {
                toggle.addEventListener('click', function () {
                    var target = this.getAttribute('data-bs-target');
                    var collapseElement = document.querySelector(target);
                    var bsCollapse = new bootstrap.Collapse(collapseElement);
                    bsCollapse.toggle();
                });
            });
        });
    </script>
@endpush