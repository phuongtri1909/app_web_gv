@extends('admin.layouts.app')

@push('styles-admin')
@endpush

@section('content-auth')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h4 class="mb-0">{{ __('edit_testimonial') }}</h4>
            </div>
            <div class="card-body pt-4 p-3">

                <form action="{{ route('papers.update', $papers->id) }}" method="POST" role="form text-left"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('admin.pages.notification.success-error')

                    <div class="form-group">
                        <label for="name">{{ __('name') }}</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name', $papers->name) }}" required>
                        @error('name')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="short_description">{{ __('short_description') }}</label>
                        <textarea class="form-control" id="short_description" name="short_description" rows="4" required>{{ old('short_description', $papers->short_description) }}</textarea>
                        @error('short_description')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="avatar">{{ __('avatar') }}</label>
                        <input type="file" name="avatar" class="form-control" id="avatar" accept="image/*">
                        @if ($papers->avatar)
                            <div class="mt-2">
                                <img src="{{ asset($papers->avatar) }}" width="100px" height="auto" alt="avatar">
                            </div>
                        @endif
                        @error('avatar')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="link">{{ __('link') }}</label>
                        <input type="url" class="form-control" id="link" name="link"
                            value="{{ old('link', $papers->link) }}" required>
                        @error('link')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ __('update') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
@endpush
