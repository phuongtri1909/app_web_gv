@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">{{ __('Tạo khảo sát') }}</h5>
                </div>
                <div class="card-body  pt-4 p-3">
                    @include('admin.pages.notification.success-error')
                    <form action="{{ route('survey.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            @foreach ($languages as $language)
                                <div class="form-group mb-3 col-md-6">
                                    <label for="{{ 'title_' . $language->locale }}">{{ __('title') }}:
                                        {{ $language->name }}</label>
                                    <input type="text" name="{{ 'title_' . $language->locale }}"
                                        id="{{ 'title_' . $language->locale }}"
                                        class="form-control @error('title_' . $language->locale) is-invalid @enderror"
                                        value="{{ old('title_' . $language->locale) }}" required>
                                    @error('title_' . $language->locale)
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3 col-12">
                                    <label for="content">{{ __('content') }}: {{ $language->name }}</label>
                                    <textarea name="content_{{ $language->locale }}" id="content_{{ $language->locale }}"
                                        class="form-control my-editor @error('content_{{ $language->locale }}') is-invalid @enderror" rows="3"
                                        >{{ old('content_' . $language->locale) }}</textarea>
                                    @error('content_{{ $language->locale }}')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="image" class="form-label">{{ __('image') }}</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="published_at" class="form-label">{{ __('Ngày bắt đầu') }}</label>
                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                                id="published_at" name="published_at" value="{{ old('published_at') }}">
                            @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="expired_at" class="form-label">{{ __('Ngày hết hạn') }}</label>
                            <input type="datetime-local" class="form-control @error('expired_at') is-invalid @enderror"
                                id="expired_at" name="expired_at" value="{{ old('expired_at') }}">
                            @error('expired_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <input type="hidden" name="category_id" value="{{ $category->id }}">
                        {{-- <div class="form-group">
                            <label for="tags">{{ __('tags') }}</label>
                            <select name="tags" id="tags" class="form-control">
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div> --}}

                        <button type="submit" class="btn btn-primary">{{ __('create') }}</button>
                        <a href="{{ route('survey.index') }}" class="btn btn-secondary">{{ __('cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    <script>
        @foreach ($languages as $language)
            CKEDITOR.replace("content_{{ $language->locale }}", {
            });
        @endforeach
    </script>
@endpush
