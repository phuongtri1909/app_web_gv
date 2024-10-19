@extends('admin.layouts.app')

@push('styles-admin')
@endpush

@section('content-auth')
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 px-3">
                <h5 class="mb-0">{{ __('new_tab_parent') }}</h5>
            </div>
            <div class="card-body pt-4 p-3">

                @include('admin.pages.notification.success-error')

                <form action="{{ route('tabs-parents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        @foreach ($languages as $language)
                            <div class="form-group mb-3 col-md-6">
                                <label for="{{ 'title_'.$language->locale }}">{{ __('title') }}:
                                    {{ $language->name }}</label>
                                <input type="text" name="{{ 'title_'.$language->locale }}"
                                    id="{{ 'title_'.$language->locale }}"
                                    class="form-control @error('title_'.$language->locale) is-invalid @enderror"
                                    value="{{ old('title_'.$language->locale) }}" required>
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
                        <a href="{{ route('tabs-parents.index') }}" class="btn btn-secondary">{{ __('cancel') }}</a>
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
            $('#banner').change(function() {
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
