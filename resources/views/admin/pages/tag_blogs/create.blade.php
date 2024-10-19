@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">{{ __('tags_add') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('tags-news.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            @foreach ($languages as $language)
                                <div class="form-group mb-3 col-md-6">
                                    <label for="{{ 'name_' . $language->locale }}">{{ __('name_tags') }}:
                                        {{ $language->name }}</label>
                                    <input type="text" name="{{ 'name_' . $language->locale }}"
                                        id="{{ 'name_' . $language->locale }}"
                                        class="form-control @error('name_' . $language->locale) is-invalid @enderror"
                                        value="{{ old('name_' . $language->locale) }}" required>
                                    @error('name_' . $language->locale)
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('create') }}</button>
                        <a href="{{ route('tags-news.index') }}" class="btn btn-secondary">{{ __('cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
