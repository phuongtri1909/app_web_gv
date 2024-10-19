@extends('admin.layouts.app')

@push('styles-admin')
@endpush

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <h5 class="mb-0">{{ __('edit_content_parent', ['tab' => $tab_content->title]) }}</h5>
                </div>
                <div class="card-body pt-4 p-3">

                    @include('admin.pages.notification.success-error')

                    <form action="{{ route('parents-children.update', $tab_content->id) }}" method="POST"
                        enctype="multipart/form-data">
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
                                        value="{{ old('title_' . $language->locale, $tab_content->getTranslation('title', $language->locale)) }}"
                                        required>
                                    @error('title_' . $language->locale)
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3 col-md-6">
                                    <label for="description">{{ __('description') }}: {{ $language->name }}</label>
                                    <textarea name="description_{{ $language->locale }}" id="description_{{ $language->locale }}"
                                        class="form-control @error('description_{{ $language->locale }}') is-invalid @enderror" rows="3">{{ old('description_' . $language->locale, $tab_content->getTranslation('description', $language->locale)) }}</textarea>
                                    @error('description_{{ $language->locale }}')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @endforeach
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">{{ __('image_parent_ch') }}</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        id="image" name="image">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    @if ($tab_content->image)
                                        <img src="{{ asset($tab_content->image) }}" alt="Image Preview"
                                            style="max-width: 200px; max-height: 200px; margin-top: 10px;">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="delete_image"
                                                name="delete_image">
                                            <label class="form-check-label"
                                                for="delete_image">{{ __('delete_current_image') }}</label>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="link">{{ __('Link') }}</label>
                            <input type="url" name="link" class="form-control" id="link"
                                value="{{ old('link', $tab_content->link) }}">
                            @error('link')
                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="component_type">{{ __('component_type') }}</label>
                            <input type="text" name="component_type" class="form-control" id="component_type"
                                value="{{ old('component_type', $tab_content->component_type) }}" required>
                            @error('component_type')
                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        @foreach ($languages as $language)
                            <div class="form-group mb-3 col-md-6">
                                <label for="{{ 'duration_' . $language->locale }}">{{ __('duration') }}:
                                    {{ $language->name }}</label>
                                <input type="text" name="{{ 'duration_' . $language->locale }}"
                                    id="{{ 'duration_' . $language->locale }}"
                                    class="form-control @error('duration_' . $language->locale) is-invalid @enderror"
                                    value="{{ old('duration_' . $language->locale, $tab_content->getTranslation('duration', $language->locale)) }}"
                                    >
                                @error('duration_' . $language->locale)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @endforeach
                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-primary">{{ __('update') }}</button>
                                <a href="{{ route('parents-children.index', $tab_content->tab_id) }}"
                                    class="btn btn-secondary">{{ __('cancel') }}</a>
                            </div>
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

    <script>
        @foreach ($languages as $language)
            var editor_config = {
                path_absolute: "/",
                selector: '#description_{{ $language->locale }}',
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
