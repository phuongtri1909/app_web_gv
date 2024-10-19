@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">{{ __('Edit News') }}</h5>
                </div>
                <div class="card-body">
                    @include('admin.pages.notification.success-error')
                    <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            @foreach ($languages as $language)
                                <div class="form-group mb-3 col-md-6">
                                    <label for="{{ 'title_' . $language->locale }}">{{ __('title') }}:
                                        {{ $language->name }}</label>
                                    <input type="text" name="{{ 'title_' . $language->locale }}"
                                        id="{{ 'title_' . $language->locale }}"
                                        class="form-control @error('title_' . $language->locale) is-invalid @enderror"
                                        value="{{ old('title_' . $language->locale, $news->getTranslation('title', $language->locale)) }}"
                                        required>
                                    @error('title_' . $language->locale)
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3 col-md-6">
                                    <label for="content">{{ __('content') }} {{ $language->name }}</label>
                                    <textarea name="content_{{ $language->locale }}" id="content_{{ $language->locale }}"
                                        class="form-control @error('content_' . $language->locale) is-invalid @enderror" rows="4" required>{{ old('content_' . $language->locale, $news->getTranslation('content', $language->locale)) }}</textarea>
                                    @error('content_' . $language->locale)
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
                            @if ($news->image)
                                <div class="mt-2">
                                    <img src="{{ asset($news->image) }}" class="img-fluid img-thumbnail" width="150"
                                        alt="Current Image">
                                </div>
                            @endif
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="published_at" class="form-label">{{ __('published_at') }}</label>
                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                                id="published_at" name="published_at"
                                value="{{ old('published_at', $news->published_at ? \Carbon\Carbon::parse($news->published_at)->format('Y-m-d\TH:i') : '') }}">
                            @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="categories">{{ __('categories_news') }}</label>
                            <select class="form-control @error('category_id') is-invalid @enderror" id="categories" name="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == $news->category_id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="tags">{{ __('tags') }}</label>
                            <select class="form-control @error('tag_id') is-invalid @enderror" id="tags" name="tag_id">
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}" {{ $tag->id == $news->tag_id ? 'selected' : '' }}>
                                        {{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tag_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <button type="submit" class="btn btn-primary">{{ __('update') }}</button>
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
                selector: '#content_{{ $language->locale }}',
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
