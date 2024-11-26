@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <h5 class="mb-0">{{ __('Cập nhật kênh tư vấn pháp luật') }}</h5>
                </div>
                <div class="card-body pt-4 p-3">

                    @include('admin.pages.notification.success-error')

                    <form action="{{ route('contact-consultations.update', $contactConsultation->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                <label for="name">{{ __('Tên') }}:</label>
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $contactConsultation->name) }}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3 col-12 col-md-6">
                            <label for="link">{{ __('Liên kết') }}</label>
                            <input type="url" name="link" id="link"
                                   class="form-control @error('link') is-invalid @enderror"
                                   value="{{ old('link', $contactConsultation->link) }}" required>
                            @error('link')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-12 col-md-12">
                            <div class="mb-3">
                                <label for="image" class="form-label">{{ __('Ảnh') }}</label>
                                <input value="{{ old('image', $contactConsultation->image) }}" type="file"
                                       class="form-control @error('image') is-invalid @enderror"
                                       id="image" name="image">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @if($contactConsultation->image)
                                <img id="image-preview" src="{{ asset($contactConsultation->image) }}" alt="Image Preview"
                                     style="display: block; max-width: 200px; max-height: 200px; margin-top: 10px;">
                            @else
                                <img id="image-preview" src="#" alt="Image Preview"
                                     style="display: none; max-width: 200px; max-height: 200px; margin-top: 10px;">
                            @endif
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn bg-gradient-primary">{{ __('Cập nhật') }}</button>
                            <a href="{{ route('contact-consultations.index') }}" class="btn btn-secondary">{{ __('Hủy') }}</a>
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