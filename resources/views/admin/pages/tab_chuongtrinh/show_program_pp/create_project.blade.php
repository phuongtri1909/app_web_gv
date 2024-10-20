@extends('admin.layouts.app')

@push('styles-admin')
@endpush

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <h5 class="mb-0">{{ __('create_content_tab', ['tab' => $tab->title]) }}</h5>
                </div>
                <div class="card-body pt-4 p-3">

                    @include('admin.pages.notification.success-error')

                    <form action="{{ route('tabs-programs.component3pp.store', $tab->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            @foreach ($languages as $language)
                                <div class="form-group mb-3 col-md-6">
                                    <label for="project_name">{{ __('title') }} {{ $language->name }}</label>
                                    <textarea name="project_name_{{ $language->locale }}" id="project_name_{{ $language->locale }}"
                                        class="form-control @error('project_name_{{ $language->locale }}') is-invalid @enderror" rows="3" required>{{ old('project_name_' . $language->locale) }}</textarea>
                                    @error('project_namet_{{ $language->locale }}')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3 col-md-6">
                                    <label for="content">{{ __('content') }} {{ $language->name }}</label>
                                    <textarea name="content_{{ $language->locale }}" id="content_{{ $language->locale }}"
                                        class="form-control @error('content_{{ $language->locale }}') is-invalid @enderror" rows="3" >{{ old('content_' . $language->locale) }}</textarea>
                                    @error('content_{{ $language->locale }}')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @endforeach

                            <div class=" col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="date" class="form-label">{{ __('date') }}</label>
                                    <input value="{{ old('date') }}" type="date"
                                        class="form-control @error('date') is-invalid @enderror" id="date"
                                        name="date">
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">{{ __('type') }}</label>
                                    <select name="type" id="type"
                                        class="form-control @error('type') is-invalid @enderror">
                                        <option value="1">{{ __('left') }}</option>
                                        <option value="2">{{ __('right') }}</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="image" class="form-label">{{ __('image') }}</label>
                                <input value="{{ old('image') }}" type="file"
                                    class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <img id="image-preview" src="#" alt="Image Preview"
                                style="display: none; max-width: 200px; max-height: 200px; margin-top: 10px;">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn bg-gradient-primary">{{ __('save') }}</button>
                            <a href="{{ route('show_content', $tab->id) }}"
                                class="btn btn-secondary">{{ __('cancel') }}</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    <script src="https://cdn.tiny.cloud/1/zjp51ea7s0xnyrx2gv55bqdfz99zaqaugg0w5fbt5uxu5q2q/tinymce/5/tinymce.min.js"
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
