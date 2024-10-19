@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        .media-preview {
            position: relative;
            display: inline-block;
            margin: 10px;
        }

        .media-preview img,
        .media-preview video {
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
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">{{ __('add_new_media') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('tabs-environment.section.store.detail', $tabContent->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3 col-md-12">
                            <label for="type" class="form-label">{{ __('media_type') }}</label>
                            <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                                <option value="image">{{ __('image') }}</option>
                                <option value="video">{{ __('video') }}</option>
                            </select>
                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3 col-md-12">
                            <label for="file" class="form-label">{{ __('upload_new_media') }}</label>
                            <input type="file" name="files[]" class="form-control @error('files.*') is-invalid @enderror"
                                multiple required>
                            @error('files.*')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        @if ($errors->has('files'))
                            <div class="alert alert-danger">
                                {{ $errors->first('files') }}
                            </div>
                        @endif
                        <div id="preview-container" class="mb-3"></div>
                        <button type="submit" class="btn btn-primary">{{ __('create') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    <script>
        document.querySelector('input[name="files[]"]').addEventListener('change', function(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('preview-container');
            previewContainer.innerHTML = '';

            const maxFiles = 10;

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

                    if (file.type.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('img-fluid', 'img-square');
                        mediaPreview.appendChild(img);
                    } else if (file.type.startsWith('video/')) {
                        const video = document.createElement('video');
                        video.src = e.target.result;
                        video.controls = true;
                        video.classList.add('img-fluid', 'img-square');
                        mediaPreview.appendChild(video);
                    }

                    mediaPreview.appendChild(removeBtn);
                    previewContainer.appendChild(mediaPreview);
                };

                reader.readAsDataURL(file);
            }
        });

        function removeFileFromList(fileToRemove) {
            const fileInput = document.querySelector('input[name="files[]"]');
            const files = Array.from(fileInput.files);
            const filteredFiles = files.filter(file => file !== fileToRemove);
            const dataTransfer = new DataTransfer();
            filteredFiles.forEach(file => dataTransfer.items.add(file));
            fileInput.files = dataTransfer.files;
        }
    </script>
@endpush
