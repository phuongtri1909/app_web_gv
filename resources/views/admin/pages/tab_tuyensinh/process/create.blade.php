@extends('admin.layouts.app')

@push('styles-admin')
@endpush

@section('content-auth')
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 px-3">
                <h5 class="mb-0">{{ __('add_process') }}</h5>
            </div>
            <div class="card-body pt-4 p-3">
                
                @include('admin.pages.notification.success-error')

                <form action="{{ route('admission-process.store') }}" method="POST">
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
                                <label for="content">{{ __('description') }} {{ $language->name }}</label>
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
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-primary">{{ __('save') }}</button>
                        <a href="{{ route('tabs-admissions.show', $tab->id) }}" class="btn btn-secondary">{{ __('cancel') }}</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts-admin')

@endpush