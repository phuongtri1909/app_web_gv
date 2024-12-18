@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Thêm câu hỏi thường gặp</h5>
                </div>
                <div class="card-body px-0 pt-0 pb-2 px-4">
                    <form action="{{ route('top-questions.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-12 col-md-6">
                                <label for="question">Câu hỏi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('question') is-invalid @enderror"
                                    id="question" name="question" value="{{ old('question') }}" required>
                                @error('question')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="answer">Câu trả lời <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('answer') is-invalid @enderror"
                                    id="answer" name="answer" value="{{ old('answer') }}" required>
                                @error('answer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="linkUrl">Link</label>
                                <input type="url" class="form-control @error('linkUrl') is-invalid @enderror"
                                    id="linkUrl" name="linkUrl" value="{{ old('linkUrl') }}">
                                @error('linkUrl')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="attachment">File đính kèm (pdf)</label>
                                <input type="file" class="form-control @error('attachment') is-invalid @enderror"
                                    id="attachment" name="attachment">
                                @error('attachment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Thêm câu hỏi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
