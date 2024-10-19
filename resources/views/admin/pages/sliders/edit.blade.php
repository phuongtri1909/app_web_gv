@extends('admin.layouts.app')

@push('styles-admin')
@endpush

@section('content-auth')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header pb-0 px-3">
            <h4 class="mb-0">{{ __('edit_slider') }}</h4>
        </div>
        <div class="card-body pt-4 p-3">
            <form action="{{ route('sliders.update', $slider->id) }}" method="POST" role="form text-left" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.pages.notification.success-error')
                <div class="row mt-4">
                    @foreach ($languages as $language)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{ 'slider_title-' . $language->locale }}">{{ __('slider_title') }}: {{ $language->name }}</label>
                                <input type="text" name="{{ 'slider_title-' . $language->locale }}"
                                    class="form-control" id="{{ 'slider_title-' . $language->locale }}"
                                    value="{{ old('slider_title-' . $language->locale, $translatedTitles[$language->locale]) }}" required>
                                @error('slider_title-' . $language->locale)
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @endforeach

                    @foreach ($languages as $language)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{ 'title-' . $language->locale }}">{{ __('title') }}: {{ $language->name }}</label>
                                <input type="text" name="{{ 'title-' . $language->locale }}"
                                    class="form-control" id="{{ 'title-' . $language->locale }}"
                                    value="{{ old('title-' . $language->locale, $translatedTitlesAlt[$language->locale]) }}" required>
                                @error('title-' . $language->locale)
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @endforeach

                    @foreach ($languages as $language)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{ 'subtitle-' . $language->locale }}">{{ __('subtitle') }}: {{ $language->name }}</label>
                                <input type="text" name="{{ 'subtitle-' . $language->locale }}"
                                    class="form-control" id="{{ 'subtitle-' . $language->locale }}"
                                    value="{{ old('subtitle-' . $language->locale, $translatedSubtitles[$language->locale]) }}" >
                                @error('subtitle-' . $language->locale)
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @endforeach

                    @foreach ($languages as $language)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{ 'description-' . $language->locale }}">{{ __('description') }}: {{ $language->name }}</label>
                                <textarea name="{{ 'description-' . $language->locale }}" class="form-control"
                                        id="{{ 'description-' . $language->locale }}" rows="4" required>{{ old('description-' . $language->locale, $translatedDescriptions[$language->locale]) }}</textarea>
                                @error('description-' . $language->locale)
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @endforeach

                    <div class="form-group">
                        <label for="image_slider">{{ __('upload_image') }}</label>
                        <input type="file" name="image_slider" class="form-control" id="image_slider" accept="image/*">
                        @if($slider->image_slider)
                            <img src="{{ asset($slider->image_slider) }}" alt="Slider Image" class="img-thumbnail mt-2" width="150">
                        @endif
                        @error('image_slider')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="learn_more_url">{{ __('learn_more_url') }}</label>
                        <input type="url" name="learn_more_url" class="form-control" id="learn_more_url"
                            value="{{ old('learn_more_url', $slider->learn_more_url) }}" required>
                        @error('learn_more_url')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="active">{{ __('active') }}</label>
                        <select name="active" class="form-control" id="active" required>
                            <option value="yes" {{ old('active', $slider->active) == 'yes' ? 'selected' : '' }}>{{ __('yes') }}</option>
                            <option value="no" {{ old('active', $slider->active) == 'no' ? 'selected' : '' }}>{{ __('no') }}</option>
                        </select>
                        @error('active')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="key_page">{{ __('key_page') }}</label>
                        <input type="text" class="form-control" id="key_page" name="key_page"
                            value="{{ old('key_page', $slider->key_page) }}" required>
                        @error('key_page')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ __('update') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts-admin')
@endpush
