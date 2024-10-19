@extends('admin.layouts.app')

@push('styles-admin')
@endpush

@section('content-auth')
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 px-3">
                <h5 class="mb-0">{{ __('create_content_component1_tab', ['tab'=> $tab->title]) }}</h5>
            </div>
            <div class="card-body pt-4 p-3">
                
                @include('admin.pages.notification.success-error')

                <form action="{{ route('content_one_tab.store',$tab->slug) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        @foreach ($languages as $language)
                            <div class="form-group mb-3 col-md-6">
                                <label for="{{ 'title_'.$language->locale }}">{{ __('title') }}:
                                    {{ $language->name }}</label>
                                <input type="text" name="{{ 'title_'.$language->locale }}"
                                    id="{{ 'title_'.$language->locale }}"
                                    class="form-control @error('title_'.$language->locale) is-invalid @enderror"
                                    value="{{ old('title_'.$language->locale)}}" required>
                                @error('title_'.$language->locale)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3 col-md-6">
                                <label for="content">{{ __('content') }} {{ $language->name }}</label>
                                <textarea name="content_{{ $language->locale }}" id="content_{{ $language->locale }}"
                                    class="form-control @error('content_{{ $language->locale }}') is-invalid @enderror" rows="3"
                                    required>{{ old('content_'.$language->locale) }}</textarea>
                                @error('content_{{ $language->locale }}')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        @endforeach

                        <div class="col-12 col-md-6">
                       
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-primary">{{ __('save') }}</button>
                        <a href="{{ route('content_tab_custom',$tab->slug) }}" class="btn btn-secondary">{{ __('cancel') }}</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts-admin')

@endpush