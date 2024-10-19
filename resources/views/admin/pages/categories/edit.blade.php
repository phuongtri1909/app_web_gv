@extends('admin.layouts.app')

@push('styles-admin')
@endpush

@section('content-auth')
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 px-3">
                <h5 class="mb-0">{{ __('edit_category') }}</h5>
            </div>
            <div class="card-body pt-4 p-3">

                @include('admin.pages.notification.success-error')

                <form action="{{ route('categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT') 
                    
                    @foreach ($languages as $language)
                        <div class="form-group mb-3">
                            <label for="name_category_{{ $language->locale }}">{{ __('category_name')  }} {{ $language->name }} </label>
                            <input type="text" name="name_category_{{ $language->locale }}" id="name_category_{{ $language->locale }}"
                                class="form-control @error('name_category_{{ $language->locale }}') is-invalid @enderror"
                                value="{{ old('name_category_' . $language->locale, $category->getTranslation('name_category',$language->locale)) }}" required>
                            @error('name_category_{{ $language->locale }}')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="desc_category">{{ __('description') }} {{ $language->name }}</label>
                            <textarea name="desc_category_{{ $language->locale }}" id="desc_category_{{ $language->locale }}"
                                class="form-control @error('desc_category_{{ $language->locale }}') is-invalid @enderror" rows="3"
                                required>{{ old('desc_category', $category->getTranslation('desc_category',$language->locale)) }}</textarea>
                            @error('desc_category_{{ $language->locale }}')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    @endforeach
                    

                   

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
<!-- Thêm các script tùy chỉnh nếu cần -->
@endpush
