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

                    <form action="{{ route('tabs-programs.component1pp.store', $tab->id) }}" method="POST"
                        enctype="multipart/form-data">
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
                                    <label for="content">{{ __('content') }} {{ $language->name }}</label>
                                    <textarea name="content_{{ $language->locale }}" id="content_{{ $language->locale }}"
                                        class="form-control @error('content_{{ $language->locale }}') is-invalid @enderror" rows="3" required>{{ old('content_' . $language->locale) }}</textarea>
                                    @error('content_{{ $language->locale }}')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @endforeach

                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">{{ __('image') }}</label>
                                    <input value="{{ old('image') }}" type="file"
                                        class="form-control @error('image') is-invalid @enderror" id="image"
                                        name="image">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <img id="image-preview" src="#" alt="Image Preview"
                                    style="display: none; max-width: 200px; max-height: 200px; margin-top: 10px;">
                            </div>
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
    <script src="https://cdn.tiny.cloud/1/zjp51ea7s0xnyrx2gv55bqdfz99zaqaugg0w5fbt5uxu5q2q/tinymce/6/tinymce.min.js"
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
            tinymce.init({
                selector: '#content_{{ $language->locale }}',
                height: 300,
                plugins: "  advlist  anchor  autolink autoresize autosave  charmap  code codesample directionality  emoticons    fullscreen help image importcss  insertdatetime link linkchecker lists media    nonbreaking pagebreak    preview quickbars save searchreplace table  template tinydrive   visualblocks visualchars wordcount",
                toolbar: 'undo redo | formatselect | bold italic backcolor | \
                          alignleft aligncenter alignright alignjustify | \
                          bullist numlist outdent indent | removeformat | table',
                toolbar_mode: 'floating',
                setup: function(editor) {
                    editor.on('change', function() {
                        tinymce.triggerSave();
                    });
                }
            });
        @endforeach
    </script>
@endpush
