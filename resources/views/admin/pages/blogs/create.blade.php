@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">{{ __('create_news') }}</h5>
                </div>
                <div class="card-body  pt-4 p-3">
                    @include('admin.pages.notification.success-error')
                    <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            @foreach ($languages as $language)
                                <div class="form-group mb-3 col-md-6">
                                    <label for="{{ 'title_' . $language->locale }}">{{ __('title') }}:
                                        {{ $language->name }}</label>
                                    <input type="text" name="{{ 'title_' . $language->locale }}"
                                        id="{{ 'title_' . $language->locale }}"
                                        class="form-control @error('title_' . $language->locale) is-invalid @enderror"
                                        value="{{ old('title_' . $language->locale) }}" required>
                                    @error('title_' . $language->locale)
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3 col-md-6">
                                    <label for="content">{{ __('content') }}: {{ $language->name }}</label>
                                    <textarea name="content_{{ $language->locale }}" id="content_{{ $language->locale }}"
                                        class="form-control my-editor @error('content_{{ $language->locale }}') is-invalid @enderror" rows="3"
                                        >{{ old('content_' . $language->locale) }}</textarea>
                                    @error('content_{{ $language->locale }}')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="image" class="form-label">{{ __('image') }}</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="published_at" class="form-label">{{ __('published_at') }}</label>
                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                                id="published_at" name="published_at" value="{{ old('published_at') }}">
                            @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="categories">{{ __('categories_news') }}</label>
                            <select name="categories" id="categories" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tags">{{ __('tags') }}</label>
                            <select name="tags" id="tags" class="form-control">
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('create') }}</button>
                        <a href="{{ route('news.index') }}" class="btn btn-secondary">{{ __('cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    <script src="https://cdn.tiny.cloud/1/94rfxe6iw4a63rhexl9m1wnjy9xkor08bhxft539qnuxepbv/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        @foreach ($languages as $language)
            var editor_config = {
                path_absolute: "/",
                selector: '#content_s{{ $language->locale }}',
                relative_urls: false,
                plugins: [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table directionality",
                    "emoticons template paste textpattern"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
                file_picker_callback: function(callback, value, meta) {
                    var x = window.innerWidth || document.documentElement.clientWidth || document
                        .getElementsByTagName(
                            'body')[0].clientWidth;
                    var y = window.innerHeight || document.documentElement.clientHeight || document
                        .getElementsByTagName('body')[0].clientHeight;

                    var cmsURL = editor_config.path_absolute + 'admin/laravel-filemanager/?editor=' + meta
                    .fieldname;
                    if (meta.filetype == 'image') {
                        cmsURL = cmsURL + "&type=Images";
                    } else {
                        cmsURL = cmsURL + "&type=Files";
                    }

                    tinyMCE.activeEditor.windowManager.openUrl({
                        url: cmsURL,
                        title: 'Filemanager',
                        width: x * 0.8,
                        height: y * 0.8,
                        resizable: "yes",
                        close_previous: "no",
                        onMessage: (api, message) => {
                            callback(message.content);
                        }
                    });
                }
            };
            tinymce.init(editor_config);
        @endforeach
    </script>
@endpush
