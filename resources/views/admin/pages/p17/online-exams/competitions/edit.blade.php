@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Chỉnh sửa cuộc thi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('competitions.update', $competition->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="title">Tiêu đề</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="title" name="title" value="{{ old('title', $competition->title) }}"
                                        required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Ngày bắt đầu</label>
                                    <input type="datetime-local"
                                        class="form-control @error('start_date') is-invalid @enderror" id="start_date"
                                        name="start_date"
                                        value="{{ old('start_date', \Carbon\Carbon::parse($competition->start_date)->format('Y-m-d\TH:i')) }}"
                                        required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="end_date">Ngày kết thúc</label>
                                    <input type="datetime-local"
                                        class="form-control @error('end_date') is-invalid @enderror" id="end_date"
                                        name="end_date"
                                        value="{{ old('end_date', \Carbon\Carbon::parse($competition->end_date)->format('Y-m-d\TH:i')) }}"
                                        required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="status">Trạng thái</label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status"
                                        name="status" required>
                                        <option value="active"
                                            {{ old('status', $competition->status) == 'active' ? 'selected' : '' }}>
                                            Hoạt động</option>
                                        <option value="inactive"
                                            {{ old('status', $competition->status) == 'inactive' ? 'selected' : '' }}>Không
                                            hoạt động</option>
                                        <option value="completed"
                                            {{ old('status', $competition->status) == 'completed' ? 'selected' : '' }}>Hoàn
                                            thành</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="time_limit">Giới hạn thời gian (phút)</label>
                                    <input type="number" class="form-control @error('time_limit') is-invalid @enderror"
                                        id="time_limit" name="time_limit"
                                        value="{{ old('time_limit', $competition->time_limit) }}" min="1" required>
                                    @error('time_limit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="banner">Banner</label>
                                    <input type="file" class="form-control @error('banner') is-invalid @enderror"
                                        id="banner" name="banner">
                                    @error('banner')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    @if ($competition->banner)
                                        <div class="mt-3">
                                            <p>Banner hiện tại:</p>
                                            <img src="{{ asset($competition->banner) }}" alt="Banner" width="200">
                                        </div>
                                    @endif
                                    <img id="image-preview" src="#" alt="Image Preview"
                                        style="display: none; max-width: 200px; max-height: 200px; margin-top: 10px;">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <a href="{{ route('competitions.index') }}" class="btn btn-secondary">Hủy</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    <script>
        $(document).ready(function() {
            $('#banner').change(function() {
                var input = this;
                if ($('#current-banner').length) {
                    $('#current-banner').remove();
                }
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#image-preview')
                            .attr('src', e.target.result)
                            .css('display', 'block');
                    }

                    reader.readAsDataURL(input.files[0]);
                } else {
                    $('#image-preview').css('display', 'none');
                }
            });
        });
    </script>
@endpush
