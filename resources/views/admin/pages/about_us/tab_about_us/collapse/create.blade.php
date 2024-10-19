@extends('admin.layouts.app')

@push('styles-admin')
<style>
    .form-group img {
        width: 200px;
        height: 200px;
        object-fit: cover;
    }
</style>
@endpush

@section('content-auth')
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 px-3">
                <h5 class="mb-0">{{ __('create_collapse') }}</h5>
            </div>
            <div class="card-body pt-4 p-3">

                @include('admin.pages.notification.success-error')

                <form action="{{ route('store.collapse', $tab->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        @foreach ($languages as $language)
                            <div class="form-group mb-3 col-md-6">
                                <label for="{{ 'title_'.$language->locale }}">{{ __('title') }}: {{ $language->name }}</label>
                                <input type="text" name="{{ 'title_'.$language->locale }}" id="{{ 'title_'.$language->locale }}" class="form-control @error('title_'.$language->locale) is-invalid @enderror" value="{{ old('title_'.$language->locale) }}" required>
                                @error('title_'.$language->locale)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3 col-md-6">
                                <label for="content">{{ __('description') }} {{ $language->name }}</label>
                                <textarea name="content_{{ $language->locale }}" id="content_{{ $language->locale }}" class="form-control @error('content_'.$language->locale) is-invalid @enderror" rows="4" required>{{ old('content_'.$language->locale) }}</textarea>
                                @error('content_'.$language->locale)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        @endforeach

                        @if($tab->slug == 'our-philosophy')
                            
                            <div class="form-group mb-3 col-md-6">
                                <label for="bg_color">{{ __('background color') }}</label>
                                <input type="color" name="bg_color" id="bg_color" class="form-control @error('bg_color') is-invalid @enderror" value="{{ old('bg_color') }}">
                                @error('bg_color')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        @endif

                        <div class="form-group mb-3 col-md-6">
                            <label for="image">{{ __('image') }}
                                 @if($tab->slug == 'our-philosophy') 
                                    (1920x430)
                                @else
                                    (360x360)
                                @endif
                            </label>
                            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                            @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <img id="image-preview" src="#" alt="Image Preview"
                                        style="display:none;width: 100%; max-height: 200px; margin-top: 10px;">
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-primary">{{ __('save') }}</button>
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
