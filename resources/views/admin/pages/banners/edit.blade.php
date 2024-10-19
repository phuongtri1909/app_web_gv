@extends('admin.layouts.app')

@push('styles-admin')

@endpush

@section('content-auth')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header pb-0 px-3">
            <h4 class="mb-0">{{ __('edit_banner') }}</h4>
        </div>
        <div class="card-body pt-4 p-3">
            <form action="{{ route('banners.update', $banner->id) }}"  role="form text-left"  method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.pages.notification.success-error')
                @method('PUT')
                <div class="form-group">
                    <label for="video">{{ __('upload_video') }}</label>
                    <input type="file" name="path" class="form-control" id="media" accept="video/*,image/*">
                    @if($banner->path)
                        <small>Video hiện tại: <a href="{{ asset($banner->path) }}" target="_blank">Xem video</a></small>
                    @endif
                    @error('path')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="thumbnail">{{ __('thumbnail') }}</label>
                    <input type="file" name="thumbnail" class="form-control" id="thumbnail" accept="image/*">
                    @error('thumbnail')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="key_page">{{ __('key_page') }}</label>
                    <input type="text" class="form-control" id="key_page" name="key_page" value="{{ $banner->key_page }}" required>
                    @error('key_page')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="active">{{ __('active') }}</label>
                    <select class="form-control" id="active" name="active" required>
                        <option value="yes" {{ $banner->active == 'yes' ? 'selected' : '' }}>{{ __('yes') }}</option>
                        <option value="no" {{ $banner->active == 'no' ? 'selected' : '' }}>{{ __('no') }}</option>
                    </select>
                    @error('active')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{__('update')}}</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts-admin')
@endpush
