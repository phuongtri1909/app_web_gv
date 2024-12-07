@extends('admin.layouts.app')

@push('styles-admin')
    <style>

    </style>
@endpush

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <h5 class="mb-0">{{ __('Sửa mẫu email') }}</h5>
                </div>
                <div class="card-body pt-4 p-3">

                    @include('admin.pages.notification.success-error')

                    <form action="{{ route('email_templates.update', $emailTemplate->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                <label for="name">{{ __('Tên mẫu email') }}:</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $emailTemplate->name) }}"
                                    required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3 col-md-12">
                                <label for="content">{{ __('Nội dung mẫu email') }}:</label>
                                <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="5"
                                    required>{{ old('content', $emailTemplate->content) }}</textarea>
                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn bg-gradient-primary">{{ __('Cập nhật mẫu email') }}</button>
                            <a href="{{ route('email_templates.index') }}"
                                class="btn btn-secondary">{{ __('Hủy') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    <script>
        CKEDITOR.replace("content", {});
    </script>
@endpush