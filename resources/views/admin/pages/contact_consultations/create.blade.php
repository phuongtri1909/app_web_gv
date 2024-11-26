@extends('admin.layouts.app')

@push('styles-admin')
@endpush

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <h5 class="mb-0">{{ __('Tạo kênh tư vấn pháp luật mới') }}</h5>
                </div>
                <div class="card-body pt-4 p-3">

                    @include('admin.pages.notification.success-error')

                    <form action="{{ route('contact-consultations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                <label for="name">{{ __('Tên') }}:</label>
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                <label for="image">{{ __('Ảnh') }}:</label>
                                <input value="{{ old('image') }}" type="file"
                                    class="form-control @error('image') is-invalid @enderror"
                                    id="image" name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <img id="image-preview" src="#" alt="Image Preview"
                                    style="display: none; max-width: 200px; max-height: 200px; margin-top: 10px;">
                            </div>
                            <div class="form-group mb-3 col-md-12">
                                <label for="link">{{ __('Liên kết') }}:</label>
                                <input type="text" name="link" id="link"
                                    class="form-control @error('link') is-invalid @enderror"
                                    value="{{ old('link') }}" required>
                                @error('link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn bg-gradient-primary">{{ __('Tạo') }}</button>
                            <a href="{{ route('contact-consultations.index') }}"
                                class="btn btn-secondary">{{ __('Huỷ') }}</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    <script>
        $(document).ready(function() {
            $('#image').change(function() {
                var input = this;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#image-preview').attr('src', e.target.result).show();
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            });
        });
    </script>
@endpush
