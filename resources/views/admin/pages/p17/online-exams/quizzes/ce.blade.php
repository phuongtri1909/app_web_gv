@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">{{ isset($quiz) ? 'Chỉnh sửa bộ câu hỏi' : 'Thêm mới bộ câu hỏi' }}</h5>
                </div>
                <div class="card-body px-4 pt-4 pb-2">
                    <form action="{{ isset($quiz) ? route('quizzes.update', ['type' => $type, 'id' => $quiz->id]) : route('quizzes.store',['type' => $type, 'competitionId' => $competition->id]) }}" method="POST">
                        @csrf
                        @if(isset($quiz))
                            @method('PUT')
                        @endif

                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Tiêu đề bộ câu hỏi</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', isset($quiz) ? $quiz->title : '') }}" placeholder="Nhập tiêu đề" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="quantity_question" class="form-label">Số lượng câu hỏi hiển thị</label>
                            <input type="number" name="quantity_question" id="quantity_question" class="form-control @error('quantity_question') is-invalid @enderror"
                                   value="{{ old('quantity_question', isset($quiz) ? $quiz->quantity_question : '') }}" placeholder="Nhập số lượng câu hỏi hiển thị" required>
                            @error('quantity_question')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status', isset($quiz) ? $quiz->status : '') === 'active' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="inactive" {{ old('status', isset($quiz) ? $quiz->status : '') === 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                                <option value="completed" {{ old('status', isset($quiz) ? $quiz->status : '') === 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('quizzes.index', ['type' => $type, 'competitionId' => $competition->id]) }}" class="btn btn-secondary me-2">Hủy</a>
                            <button type="submit" class="btn btn-primary">{{ isset($quiz) ? 'Cập nhật' : 'Thêm mới' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
