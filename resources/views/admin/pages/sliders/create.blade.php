@extends('admin.layouts.app')

@push('styles-admin')
@endpush

@section('content-auth')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header pb-0 px-3">
            <h4 class="mb-0">{{ __('add_new_slider') }}</h4>
        </div>
        <div class="card-body pt-4 p-3">
            <form action="{{ route('sliders.store') }}" method="POST" role="form text-left" enctype="multipart/form-data">
                @csrf
                @include('admin.pages.notification.success-error')

                <div class="row">
                    @foreach ($languages as $language)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{ 'slider_title-'.$language->locale }}">{{ __('slider_title') }}: {{ $language->name }}</label>
                                <div class="@error('slider_title-'.$language->locale) border border-danger rounded-3 @enderror">
                                    <input type="text" name="{{ 'slider_title-'.$language->locale }}" class="form-control"
                                        id="{{ 'slider_title-'.$language->locale }}" value="{{ old('slider_title-'.$language->locale) }}" required>
                                    @error('slider_title-'.$language->locale)
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @foreach ($languages as $language)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{ 'title-'.$language->locale }}">{{ __('title') }}: {{ $language->name }}</label>
                                <div class="@error('title-'.$language->locale) border border-danger rounded-3 @enderror">
                                    <input type="text" name="{{ 'title-'.$language->locale }}" class="form-control"
                                        id="{{ 'title-'.$language->locale }}" value="{{ old('title-'.$language->locale) }}" required>
                                    @error('title-'.$language->locale)
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @foreach ($languages as $language)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{ 'subtitle-'.$language->locale }}">{{ __('subtitle') }}: {{ $language->name }}</label>
                                <div class="@error('subtitle-'.$language->locale) border border-danger rounded-3 @enderror">
                                    <input type="text" name="{{ 'subtitle-'.$language->locale }}" class="form-control"
                                        id="{{ 'subtitle-'.$language->locale }}" value="{{ old('subtitle-'.$language->locale) }}" >
                                    @error('subtitle-'.$language->locale)
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @foreach ($languages as $language)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{ 'description-'.$language->locale }}">{{ __('description') }}: {{ $language->name }}</label>
                                <div class="@error('description-'.$language->locale) border border-danger rounded-3 @enderror">
                                    <textarea name="{{ 'description-'.$language->locale }}" class="form-control"
                                        id="{{ 'description-'.$language->locale }}" rows="4" required>{{ old('description-'.$language->locale) }}</textarea>
                                    @error('description-'.$language->locale)
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="form-group">
                    <label for="image_slider">{{ __('upload_image_1') }}</label>
                    <input type="file" name="image_slider" class="form-control" id="image_slider" accept="image/*" required>
                    @error('image_slider')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="learn_more_url">{{ __('learn_more_url') }}</label>
                    <input type="url" name="learn_more_url" class="form-control" id="learn_more_url" value="{{ old('learn_more_url') }}" required>
                    @error('learn_more_url')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="active">{{ __('active') }}</label>
                    <select name="active" class="form-control" id="active" required>
                        <option value="yes">{{ __('yes') }}</option>
                        <option value="no">{{ __('no') }}</option>
                    </select>
                    @error('active')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="key_page">{{ __('key_page') }}</label>
                    <input type="text" class="form-control" id="key_page" name="key_page" required>
                    @error('key_page')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ __('create') }}</button>
            </form>
        </div>

    </div>
</div>
@endsection

@push('scripts-admin')
@endpush
