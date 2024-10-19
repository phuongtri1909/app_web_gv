@extends('admin.layouts.app')

@push('styles-admin')
@endpush

@section('content-auth')

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header pb-0 px-3">
            <h4 class="mb-0">{{ __('add_about_us') }}</h4>
        </div>
        <div class="card-body pt-4 p-3">
            <form action="{{ route('aboutUs.store') }}" method="POST" role="form text-left" enctype="multipart/form-data">
                @csrf
                @include('admin.pages.notification.success-error')

                <div class="row">
                    @foreach ($languages as $language)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{ 'title_about-'.$language->locale }}">{{ __('title_about') }}: {{ $language->name }}</label>
                                <div class="@error('title_about-'.$language->locale) border border-danger rounded-3 @enderror">
                                    <input type="text" name="{{ 'title_about-'.$language->locale }}" class="form-control"
                                        id="{{ 'title_about-'.$language->locale }}" value="{{ old('title_about-'.$language->locale) }}" required>
                                    @error('title_about-'.$language->locale)
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endforeach

                     @foreach ($languages as $language)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{ 'subtitle_about-'.$language->locale }}">{{ __('subtitle_about') }}: {{ $language->name }}</label>
                                <div class="@error('subtitle_about-'.$language->locale) border border-danger rounded-3 @enderror">
                                    <input type="text" name="{{ 'subtitle_about-'.$language->locale }}" class="form-control"
                                        id="{{ 'subtitle_about-'.$language->locale }}" value="{{ old('subtitle_about-'.$language->locale) }}" required>
                                    @error('subtitle_about-'.$language->locale)
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                     @endforeach

                    @foreach ($languages as $language)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{ 'title_detail-'.$language->locale }}">{{ __('title_detail') }}: {{ $language->name }}</label>
                                <div class="@error('title_detail-'.$language->locale) border border-danger rounded-3 @enderror">
                                    <input type="text" name="{{ 'title_detail-'.$language->locale }}" class="form-control"
                                        id="{{ 'title_detail-'.$language->locale }}" value="{{ old('title_detail-'.$language->locale) }}" required>
                                    @error('title_detail-'.$language->locale)
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @foreach ($languages as $language)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{ 'subtitle_detail-'.$language->locale }}">{{ __('subtitle_detail') }}: {{ $language->name }}</label>
                                <div class="@error('subtitle_detail-'.$language->locale) border border-danger rounded-3 @enderror">
                                    <input type="text" name="{{ 'subtitle_detail-'.$language->locale }}" class="form-control"
                                        id="{{ 'subtitle_detail-'.$language->locale }}" value="{{ old('subtitle_detail-'.$language->locale) }}" >
                                    @error('subtitle_detail-'.$language->locale)
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
                    <label for="image">{{ __('upload_image_aboutUs') }}</label>
                    <input type="file" name="image" class="form-control" id="image" accept="image/*" required>
                    @error('image')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="link_url">{{ __('link_url') }}</label>
                    <input type="url" name="link_url" class="form-control" id="link_url" value="{{ old('link_url') }}" required>
                    @error('link_url')
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
