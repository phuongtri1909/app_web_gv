@extends('admin.layouts.app')

@push('styles-admin')
@endpush

@section('content-auth')
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 px-3">
                <h5 class="mb-0">{{ __('add campus') }}</h5>
            </div>
            <div class="card-body pt-4 p-3">
                
                @include('admin.pages.notification.success-error')

                <form action="{{ route('campuses.store') }}" method="POST" enctype="multipart/form-data">
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
                                <label for="description">{{ __('description') }}: {{ $language->name }}</label>
                                <textarea name="description_{{ $language->locale }}" id="description_{{ $language->locale }}"
                                    class="form-control @error('description_{{ $language->locale }}') is-invalid @enderror" rows="3"
                                    required>{{ old('description_'.$language->locale) }}</textarea>
                                @error('description_{{ $language->locale }}')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        @endforeach
                        @foreach ($languages as $language)
                            <div class="form-group mb-3 col-md-6">
                                <label for="{{ 'name_'.$language->locale }}">{{ __('name') }}:
                                    {{ $language->name }}</label>
                                <input type="text" name="{{ 'name_'.$language->locale }}"
                                    id="{{ 'name_'.$language->locale }}"
                                    class="form-control @error('name_'.$language->locale) is-invalid @enderror"
                                    value="{{ old('name_'.$language->locale)}}" required>
                                @error('name_'.$language->locale)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3 col-md-6">
                                <label for="{{'address_'.$language->locale }}">{{ __('address') }}:
                                    {{ $language->name }}</label>
                                <input type="text" name="{{ 'address_'.$language->locale }}"
                                    id="{{ 'address_'.$language->locale }}"
                                    class="form-control @error('address_'.$language->locale) is-invalid @enderror"
                                    value="{{ old('address_'.$language->locale)}}" required>
                                @error('address_'.$language->locale)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        @endforeach

                        <div class="form-group mb-3 col-md-6">
                            <label for="location">{{ __('location') }}</label>
                            <input type="text" name="location"
                                id="location"
                                class="form-control @error('location') is-invalid @enderror"
                                value="{{ old('location')}}" required>
                            @error('location')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="image" class="form-label">{{ __('image') }} (450x350px)</label>
                                <input value="{{ old('image') }}" type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <img id="image-preview" src="#" alt="Image Preview"
                                style="display: none; max-width: 200px; max-height: 200px; margin-top: 10px;">
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="phone">{{ __('phone') }}</label>
                            <input type="phone" name="phone"
                                id="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone')}}">
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-primary">{{ __('save') }}</button>
                        <a href="{{ route('campuses.index') }}" class="btn btn-secondary">{{ __('cancel') }}</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts-admin')
<script>
    $(document).ready(function() {
        $('#image').change(function() {
            var input = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#image-preview').attr('src', e.target.result).show();
                }

                reader.readAsDataURL(input.files[0]);
            }
        });
    });
</script>
@endpush