@extends('admin.layouts.app')

@push('styles-admin')
@endpush

@section('content-auth')
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 px-3">
                <h5 class="mb-0">{{ __('add_category') }}</h5>
            </div>
            <div class="card-body pt-4 p-3">
                
                @include('admin.pages.notification.success-error')

                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        @foreach ($languages as $language)
                        <div class="form-group mb-3 col-md-6">
                            <label for="{{ 'name_category-'.$language->locale }}">{{ __('category_name') }}:
                                {{ $language->name }}</label>
                            <input type="text" name="{{ 'name_category-'.$language->locale }}"
                                id="{{ 'name_category-'.$language->locale }}"
                                class="form-control @error('name_category-'.$language->locale) is-invalid @enderror"
                                value="{{ old('name_category-'.$language->locale) }}" required>
                            @error('name_category-'.$language->locale)
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="{{ 'desc_category-'.$language->locale }}">{{ __('description') }}:
                                {{ $language->name }}</label>
                            <textarea name="{{ 'desc_category-'.$language->locale }}"
                                id="{{ 'desc_category-'.$language->locale }}"
                                class="form-control @error('desc_category-'.$language->locale) is-invalid @enderror"
                                rows="3" required>{{ old('desc_category-'.$language->locale) }}</textarea>
                            @error('desc_category-'.$language->locale)
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @endforeach
                    </div>

                    <div class="form-group mb-3">
                        <label for="key_page">{{ __('key_page_2') }}</label>
                        <select name="key_page" id="key_page"
                            class="form-control @error('key_page') is-invalid @enderror" required>
                            <option value="" disabled selected>{{ __('select_key_page') }}</option>
                            @foreach ($keyPages as $key => $value)
                            <option value="{{ $key }}" {{ old('key_page') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                            @endforeach
                        </select>
                        @error('key_page')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-primary">{{ __('save') }}</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">{{ __('cancel') }}</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts-admin')

@endpush