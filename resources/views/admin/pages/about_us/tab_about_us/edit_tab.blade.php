@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        .img-square {
            width: 500px; 
            height: 100px; 
            object-fit: cover;
        }
    </style>
@endpush
@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ __('edit_component') }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4 p-3">

                    @include('admin.pages.notification.success-error')

                    <form action="{{ route('update-process',$tab_image_content->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            @foreach ($languages as $language)
                                <div class="form-group mb-3 col-md-6">
                                    <label for="{{ 'title_'.$language->locale }}">{{ __('title') }}:
                                        {{ $language->name }}</label>
                                    <input type="text" name="{{ 'title_'.$language->locale }}"
                                        id="{{ 'title_'.$language->locale }}"
                                        class="form-control @error('title_'.$language->locale) is-invalid @enderror"
                                        value="{{ old('title_'.$language->locale, $tab_image_content->getTranslation('title',$language->locale)) }}" required>
                                    @error('title_'.$language->locale)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            @endforeach

                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="banner" class="form-label">Banner (1600x355)</label>
                                    <input value="{{ old('banner') }}" type="file" class="form-control @error('banner') is-invalid @enderror" id="banner" name="banner">
                                    @error('banner')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
    
                                <img id="image-preview" src="#" alt="Image Preview"
                                    style="display: none; max-width: 200px; max-height: 200px; margin-top: 10px;">
                            </div>
                            
                        </div>
    
                        <div class="text-center">
                            <button type="submit" class="btn bg-gradient-primary">{{ __('save') }}</button>
                            <a href="{{ route('tabs-admissions.index') }}" class="btn btn-secondary">{{ __('cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts-admin')
@endpush
