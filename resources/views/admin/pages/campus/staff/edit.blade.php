@extends('admin.layouts.app')

@push('styles-admin')
@endpush

@section('content-auth')
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 px-3">
                <h5 class="mb-0">{{ __('edit_personnel') }}</h5>
            </div>
            <div class="card-body pt-4 p-3">
                
                @include('admin.pages.notification.success-error')

                <form action="{{ route('staffs.update',$personnel->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group mb-3 col-md-6">
                            <label for="full_name">{{ __('full_name') }}</label>
                            <input type="text" name="full_name"
                                id="full_name"
                                class="form-control @error('full_name') is-invalid @enderror"
                                value="{{ old('full_name',$personnel->full_name)}}" required>
                            @error('full_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        @foreach ($languages as $language)
                            <div class="form-group mb-3 col-md-6">
                                <label for="{{ 'position_'.$language->locale }}">{{ __('position') }}:
                                    {{ $language->name }}</label>
                                <input type="text" name="{{ 'position_'.$language->locale }}"
                                    id="{{ 'position_'.$language->locale }}"
                                    class="form-control @error('position_'.$language->locale) is-invalid @enderror"
                                    value="{{ old('position_'.$language->locale,$personnel->getTranslation('position',$language->locale))}}" required>
                                @error('position_'.$language->locale)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3 col-md-6">
                                <label for="description">{{ __('description') }}: {{ $language->name }}</label>
                                <textarea name="description_{{ $language->locale }}" id="description_{{ $language->locale }}"
                                    class="form-control @error('description_{{ $language->locale }}') is-invalid @enderror" rows="3"
                                    required>{{ old('description_'.$language->locale,$personnel->getTranslation('description',$language->locale)) }}</textarea>
                                @error('description_{{ $language->locale }}')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        @endforeach

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="image" class="form-label">{{ __('avatar') }} (400x300px)</label>
                                <input value="{{ old('image') }}" type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <img id="image-preview" src="{{ asset($personnel->image) }}" alt="Image Preview"
                                style="max-width: 200px; max-height: 200px; margin-top: 10px;" class="mb-3">
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-primary">{{ __('save') }}</button>
                        <a href="{{ route('campuses.show',$campus->id) }}" class="btn btn-secondary">{{ __('cancel') }}</a>
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