@extends('layouts.app')
@section('title', 'Kết nối giao thương')
@section('description', 'Kết nối giao thương')
@section('keyword', 'Kết nối giao thương')
@push('styles')
    <style>
        .upload-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .upload-label {
            cursor: pointer;
        }

        .upload-box {
            width: 200px;
            height: 200px;
            border: 2px dashed #ccc;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-radius: 4px;
            transition: border-color 0.3s;
            position: relative;
            overflow: hidden;
        }

        .image-preview {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-preview-container {
            position: absolute;
            flex-direction: row;
            gap: 5px;
        }

        .image-preview:hover .image-preview-container {
            display: flex;
        }

        .control-icon {
            font-size: 15px;
            cursor: pointer;
            padding: 5px;
            color: #fff
        }

        .preview-image {
            max-width: 100%;
            max-height: 100%;
            display: block;
        }

        .upload-box:hover {
            border-color: #999;
        }

        .upload-icon {
            font-size: 24px;
            color: #666;
        }

        .upload-text {
            color: #666;
            font-size: 14px;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .image-preview-container:hover .image-overlay {
            opacity: 1;
        }

        input[type="file"] {
            display: none;
        }

        .form-control:focus,
        .form-control:hover,
        .upload-label:focus,
        .upload-label:hover {
            border-color: #80bdff;
            box-shadow: 0 0 5px rgba(128, 189, 255, 0.5);
            outline: 0;
        }

        .error-message,
        .error-message1 {
            color: red;
            margin-top: 10px;
            font-size: 12px;
        }
        .btn:disabled {
            background-color: #004494;
        }

        #form-business {
            position: relative;
            /* margin: 30px auto; */
            /* padding: 20px 0px 20px 0px; */
            /* max-width: 800px; */
            background-color: #f8f9fa;
            border-radius: 8px;
            background: url('{{ asset('images/logo.png') }}') no-repeat;
            background-size: 30%;
            background-attachment: fixed;
            background-position: center center;
            z-index: 1;
        }

        form {
            position: relative;
            z-index: 1;
            background-color: rgba(255, 255, 255, 0.9);
            /* padding: 20px; */
            border-radius: 8px;
        }
    </style>
@endpush

@section('content')
    <section id="form-business" class="form-business mt-5rem">
        <div class="container my-4">
            <div class="row">

                <form action="{{ route('business.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12 mb-5">
                        <div class="avt-business text-center mb-2">
                            <label for="">Hình ảnh đại diện doanh nghiệp (200x200px) <span class="text-danger">*</span></label>
                        </div>
                        <div class="upload-container @error('avt_businesses') is-invalid @enderror">
                            <label for="file-upload" class="upload-label">
                                <div class="upload-box">
                                    <span class="upload-icon" id="upload-icon">+</span>
                                    <span class="upload-text" id="upload-text">Tải hình lên</span>
                                    <div id="image-preview" class="image-preview"></div>
                                </div>
                            </label>
                            <div id="error-message1" class="error-message text-danger"></div>
                            @error('avt_businesses')
                                <div class="invalid-feedback d-block text-center" role="alert">{{ $message }}</div>
                            @enderror
                            <input id="file-upload" type="file" accept="image/*" name="avt_businesses"
                                value="{{ old('avt_businesses') }}" style="display: none;">
                        </div>
                    </div>
                    
                       
                    <div class="mb-4">
                        <label for="description" class="form-label">Thông tin doanh nghiệp <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" rows="4"
                            placeholder="Thông tin doanh nghiệp" name="description">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback" role="alert">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                    </div>
                    @if ($errors->has('error'))
                        <div class="invalid-feedback d-block text-center" role="alert">{{ $errors->first('error') }}
                        </div>
                    @endif
                    <div id="recaptcha-error" class="text-danger text-center mt-2"></div>
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </form>
            </div>
        </div>
    </section>
@endsection


@push('scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script>
        const fileInput = document.getElementById('file-upload');
        const imagePreview = document.getElementById('image-preview');
        const uploadIcon = document.getElementById('upload-icon');
        const uploadText = document.getElementById('upload-text');
        const errorMessage = document.getElementById('error-message1');
        fileInput.addEventListener('change', function() {
            const file = fileInput.files[0];
            errorMessage.textContent = '';

            if (file) {
                if (!file.type.startsWith('image/')) {
                    errorMessage.textContent = 'Tệp không hợp lệ: Vui lòng chỉ tải lên hình ảnh.';
                    fileInput.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function() {
                    const img = document.createElement('img');
                    img.src = reader.result;
                    img.className = 'preview-image';
                    img.id = 'uploaded-image';

                    const imagePreviewContainer = document.createElement('div');
                    imagePreviewContainer.className = 'image-preview-container';

                    const overlay = document.createElement('div');
                    overlay.className = 'image-overlay';

                    const deleteIcon = document.createElement('span');
                    deleteIcon.className = 'control-icon delete-icon';
                    deleteIcon.innerHTML = '<i class="fa-solid fa-trash"></i>';
                    deleteIcon.onclick = function() {
                        const img = document.getElementById('uploaded-image');
                        img.remove();
                        imagePreview.innerHTML = '';
                        uploadIcon.style.display = 'block';
                        uploadText.style.display = 'block';
                    };

                    const previewIcon = document.createElement('span');
                    previewIcon.className = 'control-icon preview-icon';
                    previewIcon.innerHTML = '<i class="fas fa-eye"></i>';
                    previewIcon.onclick = function() {
                        const img = document.getElementById('uploaded-image');
                        const imgWindow = window.open("");
                        imgWindow.document.write("<img src='" + img.src + "' style='max-width:100%;'>");
                    };

                    overlay.appendChild(deleteIcon);
                    overlay.appendChild(previewIcon);
                    imagePreviewContainer.appendChild(img);
                    imagePreviewContainer.appendChild(overlay);
                    imagePreview.appendChild(imagePreviewContainer);

                    uploadIcon.style.display = 'none';
                    uploadText.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
