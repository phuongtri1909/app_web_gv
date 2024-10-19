@extends('admin.layouts.app')

@push('styles-admin')
<!-- Thêm các style tùy chỉnh nếu cần -->
@endpush

@section('content-auth')
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 px-3">
                <h5 class="mb-0">{{ __('edit_slide_program') }}</h5>
            </div>
            <div class="card-body pt-4 p-3">

                @include('admin.pages.notification.success-error')

                <form action="{{ route('slide_program.update', $slideProgram->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Để cập nhật tài nguyên, cần dùng PUT method -->
                    <div class="row">
                        <input type="hidden" name="program_id" value="{{$slideProgram->program_id}}">
    
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="img">{{ __('upload_img_350x150') }}</label>
                                <input type="file" name="img" id="img" class="form-control">
                                @if ($slideProgram->img)
                                    <img src="{{ asset($slideProgram->img) }}" alt="Image" class="img-thumbnail mt-2" width="150">
                                @endif
                                @error('img')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn bg-gradient-primary">{{ __('save') }}</button>
                            <a href="{{ route('slider_programms.index', ['program_id' => $slideProgram->program_id]) }}" class="btn btn-secondary">{{ __('cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts-admin')
<!-- Thêm các script tùy chỉnh nếu cần -->
@endpush
