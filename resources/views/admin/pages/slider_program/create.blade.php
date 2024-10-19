@extends('admin.layouts.app')

@push('styles-admin')
<!-- Thêm các style tùy chỉnh nếu cần -->
@endpush

@section('content-auth')
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 px-3">
                <h5 class="mb-0">{{ __('create_slide_program') }}</h5>
            </div>
            <div class="card-body pt-4 p-3">

                @include('admin.pages.notification.success-error')

                <form action="{{ route('slide_program.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="program_id" value="{{ $program_id }}">
                
                        <div class="form-group">
                            <label for="img">{{ __('upload_img_350x150') }}</label>
                            <input type="file" name="img[]" class="form-control" id="img" accept="image/*" multiple required>
                            @error('img')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn bg-gradient-primary">{{ __('save') }}</button>
                            <a href="{{ route('slider_programms.index', ['program_id' => $program_id]) }}" class="btn btn-secondary">{{ __('cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts-admin')

@endpush
