@extends('admin.layouts.app')
@push('styles-admin')
<style>
            .media-preview {
            position: relative;
            display: inline-block;
            margin: 10px;
        }

        .media-preview img {
            width: 200px;
            height: 200px;
            object-fit: cover;
        }

        .media-preview .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            text-align: center;
            line-height: 25px;
            cursor: pointer;
            font-size: 14px;
        }

        #preview-container {
            display: flex;
            flex-wrap: wrap;
        }
</style>
@endpush
@section('content-auth')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h5 class="mb-0">{{ __('add_forum') }}</h5>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="{{ route('forums.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.pages.notification.success-error')

                    <div class="row">
                        @foreach ($languages as $language)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="{{ 'title-' . $language->locale }}">{{ __('title') }}:
                                        {{ $language->name }}</label>
                                    <input type="text" name="{{ 'title-' . $language->locale }}"
                                        class="form-control @error('title-' . $language->locale) border border-danger rounded-3 @enderror"
                                        id="{{ 'title-' . $language->locale }}"
                                        value="{{ old('title-' . $language->locale) }}">
                                    @error('title-' . $language->locale)
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        <div class="form-group">
                            <label for="image">{{ __('image_forum') }}</label>
                            <input type="file" name="image[]" class="form-control @error('image.*') border border-danger rounded-3 @enderror"
                                id="image" multiple>
                            @error('image.*')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="key_page">{{ __('key_page_fr') }}</label>
                            <input type="text" name="key_page"
                                class="form-control @error('key_page') border border-danger rounded-3 @enderror" id="key_page"
                                value="{{ old('key_page') }}">
                            @error('key_page')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div id="preview-container" class="mb-3"></div>
                        <div class="form-group">
                            <label for="active">{{ __('active') }}</label>
                            <select name="active" class="form-control @error('active') border border-danger rounded-3 @enderror"
                                id="active">
                                <option value="yes">{{ __('yes') }}</option>
                                <option value="no">{{ __('no') }}</option>
                            </select>
                            @error('active')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ __('create') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
<script src="https://cdn.tiny.cloud/1/94rfxe6iw4a63rhexl9m1wnjy9xkor08bhxft539qnuxepbv/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    @foreach($languages as $language)
        tinymce.init({
            selector: '#title-{{ $language->locale }}',
            height: 300,
            plugins: "  advlist  anchor  autolink autoresize autosave  charmap  code codesample directionality  emoticons  fullscreen help image importcss  insertdatetime link linkchecker lists media    nonbreaking pagebreak   preview quickbars save searchreplace table  template tinydrive   visualblocks visualchars wordcount",
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | table',
            toolbar_mode: 'floating',
            setup: function (editor) {
                editor.on('change', function () {
                    tinymce.triggerSave();
                });
            }
        });
    @endforeach
</script>
<script>
    document.querySelector('input[name="image[]"]').addEventListener('change', function(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('preview-container');
        previewContainer.innerHTML = '';

        const maxFiles = 9;

        if (files.length > maxFiles) {
            alert('Bạn chỉ có thể chọn tối đa ' + maxFiles + ' tập tin.');
            event.target.value = '';
            return;
        }

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function(e) {
                const mediaPreview = document.createElement('div');
                mediaPreview.classList.add('media-preview');

                const removeBtn = document.createElement('button');
                removeBtn.classList.add('remove-btn');
                removeBtn.textContent = '×';
                removeBtn.onclick = function() {
                    mediaPreview.remove();
                    removeFileFromList(file);
                };

                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-fluid', 'img-square');
                mediaPreview.appendChild(img);

                mediaPreview.appendChild(removeBtn);
                previewContainer.appendChild(mediaPreview);
            };

            reader.readAsDataURL(file);
        }
    });

    function removeFileFromList(fileToRemove) {
        const fileInput = document.querySelector('input[name="image[]"]');
        const files = Array.from(fileInput.files);
        const filteredFiles = files.filter(file => file !== fileToRemove);
        const dataTransfer = new DataTransfer();
        filteredFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }
</script>
@endpush
