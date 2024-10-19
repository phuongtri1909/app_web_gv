@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">{{ __('edit_category') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('categories-questions.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            @foreach ($languages as $language)
                            <div class="form-group mb-3 col-md-6">
                                <label for="{{ 'name_'.$language->locale }}">{{ __('title') }}: {{ $language->name }}</label>
                                <input type="text" name="{{ 'name_'.$language->locale }}" id="{{ 'name_'.$language->locale }}" class="form-control @error('name_'.$language->locale) is-invalid @enderror" value="{{ old('name_'.$language->locale, $category->getTranslation('name', $language->locale)) }}" required>
                                @error('name_'.$language->locale)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('update') }}</button>
                        <a href="{{ route('categories-questions.index') }}" class="btn btn-secondary">{{ __('cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
