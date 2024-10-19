@extends('admin.layouts.app')

@push('styles-admin')
<style>
    .form-group img{
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
                <h5 class="mb-0">{{ __('edit_content_pedagody') }}</h5>
            </div>
            <div class="card-body pt-4 p-3">

                @include('admin.pages.notification.success-error')

                <form action="{{ route('tabs-programs.component2pp.update', $tab_drop_content->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        @foreach ($languages as $language)
                            <div class="form-group mb-3 col-md-6">
                                <label for="{{ 'title_'.$language->locale }}">{{ __('title') }}: {{ $language->name }}</label>
                                <input type="text" name="{{ 'title_'.$language->locale }}" id="{{ 'title_'.$language->locale }}" class="form-control @error('title_'.$language->locale) is-invalid @enderror" value="{{ old('title_'.$language->locale, $tab_drop_content->getTranslation('title', $language->locale)) }}" required>
                                @error('title_'.$language->locale)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3 col-md-6">
                                <label for="content">{{ __('description') }} {{ $language->name }}</label>
                                <textarea name="content_{{ $language->locale }}" id="content_{{ $language->locale }}" class="form-control @error('content_'.$language->locale) is-invalid @enderror" rows="4" required>{{ old('content_'.$language->locale, $tab_drop_content->getTranslation('content', $language->locale)) }}</textarea>
                                @error('content_'.$language->locale)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        @endforeach

                        <div class="form-group mb-3 col-md-12">
                            <label for="icon">{{ __('icon') }}</label>
                            <input type="text" name="icon" id="icon" class="form-control @error('icon') is-invalid @enderror" value="{{ old('icon', $tab_drop_content->icon) }}" >
                            @error('icon')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3 col-md-2">
                            <label for="bg_color">{{ __('background color') }}</label>
                            <input type="color" name="bg_color" id="bg_color" class="form-control @error('bg_color') is-invalid @enderror" value="{{ old('bg_color', $tab_drop_content->bg_color) }}" >
                            @error('bg_color')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3 col-md-12">
                            <label for="image">{{ __('image') }}</label>
                            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                            @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @if($tab_drop_content->image)
                            <div class="form-group mb-3 col-md-12">
                                <label>{{ __('current_image') }}</label>
                                <div>
                                    <img src="{{ asset($tab_drop_content->image) }}" class="img-fluid img-square" alt="Image">
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-primary">{{ __('save') }}</button>
                        <a href="{{ route('tabs-programs.component2', $tab_drop_content->tab_id) }}" class="btn btn-secondary">{{ __('cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts-admin')
<script src="https://cdn.tiny.cloud/1/94rfxe6iw4a63rhexl9m1wnjy9xkor08bhxft539qnuxepbv/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        @foreach($languages as $language)
            tinymce.init({
                selector: '#content_{{ $language->locale }}',
                height: 300,
                plugins: "  advlist  anchor  autolink autoresize autosave  charmap  code codesample directionality  emoticons    fullscreen help image importcss  insertdatetime link linkchecker lists media    nonbreaking pagebreak    preview quickbars save searchreplace table  template tinydrive   visualblocks visualchars wordcount",
                toolbar: 'undo redo | formatselect | bold italic backcolor | \
                      alignleft aligncenter alignright alignjustify | \
                      bullist numlist outdent indent | removeformat | table',
                toolbar_mode: 'floating',
                setup: function (editor) {
                    editor.on('change', function () {
                        tinymce.triggerSave();
                    });
                }
            });
        @endforeach
    </script>
@endpush
