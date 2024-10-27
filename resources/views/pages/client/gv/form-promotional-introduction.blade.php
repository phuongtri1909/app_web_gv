@extends('pages.layouts.page')
@section('title', 'Đăng ký điểm đến')

@push('child-styles')
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

        /* input[type="file"] {
            display: none;
        } */

        .form-control:focus,
        .form-control:hover,
        .upload-label:focus,
        .upload-label:hover {
            border-color: #80bdff;
            box-shadow: 0 0 5px rgba(128, 189, 255, 0.5);
            outline: 0;
        }

        .ant-upload-list-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .ant-upload-list-item-thumbnail {
            margin-right: 10px;
        }

        .ant-upload-list-item-name {
            flex-grow: 1;
        }

        .ant-upload-list-item-actions {
            margin-left: 10px;

        }

        .ant-upload-list-item-action {
            border: none !important;
            background-color: unset !important;
        }

        .error-message,
        .error-message1 {
            color: red;
            margin-top: 10px;
        }

        .btn-success {
            background-color: #0056b3;
            transition: background-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #004494;
        }

        @media (max-width: 768px) {

            .btn-success {
                padding: 8px;
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {


            .btn-success {
                padding: 6px;
                font-size: 12px;
            }
        }

        .btn:disabled {
            background-color: #004494;
        }

        #start-promotion{
            position: relative;
            margin: 30px auto;
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


@section('content-page')
    <section id="start-promotion">
        <div class="container my-4">
            <div class="row">
                @include('pages.notification.success-error')
                <form action="{{ route('form.promotional.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label for="representative_name" class="form-label">Họ tên chủ doanh nghiệp <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control form-control-sm @error('representative_name') is-invalid @enderror"
                                id="representative_name" name="representative_name" placeholder="Nhập họ tên"
                                value="{{ old('representative_name') }}">
                            @error('representative_name')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="birth_year" class="form-label">Năm sinh:<span class="text-danger">*</span></label>
                            <input type="text" id="birth_year" name="birth_year" class="form-control form-control-sm @error('birth_year') is-invalid @enderror"
                                required placeholder="Nhập năm sinh" value="{{ old('birth_year') }}">
                            @error('birth_year')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Giới tính:<span class="text-danger">*</span></label>
                            <div class="d-flex align-items-center">
                                <div class="form-check me-3">
                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="genderMale" value="male" {{ old('gender') == 'male' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="genderMale">
                                        Nam
                                    </label>
                                </div>
                                <div class="form-check me-3">
                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="genderFemale" value="female" {{ old('gender') == 'female' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="genderFemale">
                                        Nữ
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="genderOther" value="other" {{ old('gender') == 'other' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="genderOther">
                                        Khác
                                    </label>
                                </div>
                            </div>
                            @error('gender')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="tel"
                                class="form-control form-control-sm @error('phone_number') is-invalid @enderror"
                                id="phone" placeholder="Nhập số điện thoại" name="phone_number"
                                value="{{ old('phone_number') }}">
                            @error('phone_number')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="address" class="form-label">Địa chỉ cư trú <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control form-control-sm @error('address') is-invalid @enderror" id="address"
                                placeholder="Nhập địa chỉ" name="address" value="{{ old('address') }}">
                            @error('address')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="business_address" class="form-label">Địa chỉ kinh doanh:<span class="text-danger">*</span></label>
                            <input type="text" id="business_address" name="business_address"
                                class="form-control form-control-sm" placeholder="Nhập địa chỉ kinh doanh" value="{{ old('business_address') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label for="businessName" class="form-label @error('business_name') is-invalid @enderror">Tên
                                doanh nghiệp/hộ kinh doanh: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="businessName"
                                name="business_name" placeholder="Nhập tên doanh nghiệp" value="{{ old('business_name') }}">
                            @error('business_name')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="license" class="form-label">Giấy phép kinh doanh:<span class="text-danger">*</span></label>
                            <input type="file" class="form-control form-control-sm" id="license" accept="application/pdf" name="license">
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="business_field" class="form-label">Ngành nghề kinh doanh <span class="text-danger">*</span></label>
                            <select id="business_field" name="business_field" class="form-control form-control-sm @error('business_field') is-invalid @enderror">
                                <option value="" disabled selected>Chọn ngành nghề kinh doanh</option>
                                @foreach($business_fields as $field)
                                    <option value="{{ $field->name }}" {{ old('business_field') == $field->name ? 'selected' : '' }}>{{ $field->name }}</option>
                                @endforeach
                            </select>
                            @error('business_field')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label for="businessCode" class="form-label">Mã số thuế <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control form-control-sm @error('business_code') is-invalid @enderror"
                                id="businessCode" name="business_code" placeholder="Nhập mã số thuế"
                                value="{{ old('business_code') }}">
                            @error('business_code')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="email" class="form-label">Email doanh nghiệp <span class="text-danger">*</span></label>
                            <input type="email"
                                class="form-control form-control-sm @error('email') is-invalid @enderror"
                                id="email" placeholder="Nhập email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="social" class="form-label">Fanpage</label>
                            <input type="url"
                                class="form-control form-control-sm @error('social_channel') is-invalid @enderror"
                                id="social" placeholder="Nhập link fanpage" value="{{ old('social_channel') }}"
                                name="social_channel">
                            @error('social_channel')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <label class="mb-2">Thông tin về doanh nghiệp, sản phẩm:<span class="text-danger">*</span></label>
                        <div class="col-md-4 mb-4">
                            <label for="logo" class="form-label">Logo/ Hình ảnh đại diện doanh nghiệp:</label>
                            <input type="file" accept="image/*" id="logo" name="logo" class="form-control form-control-sm  @error('logo') is-invalid @enderror">
                            @error('logo')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                            <div id="logo_preview_container" class="mt-3"></div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="product_image" class="form-label">Hình ảnh doanh nghiệp, sản phẩm:</label>
                            <input type="file" accept="image/*" id="product_image" name="product_image[]" class="form-control form-control-sm @error('product_image') is-invalid @enderror" multiple>
                            @error('logo')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                            <div id="product_image_preview_container" class="mt-3"></div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="product_image" class="form-label">Video doanh nghiệp, sản phẩm:</label>
                            <input type="file" accept="video/*" id="product_video" name="product_video" class="form-control form-control-sm @error('product_video') is-invalid @enderror">
                            @error('product_video')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                            <div id="product_video_preview_container" class="mt-3"></div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Gửi thông tin</button>
                </form>

            </div>
        </div>
    </section>
@endsection

@push('child-scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        function previewFiles(input, previewContainerId, isVideo = false, maxFiles = 5) {
            const previewContainer = document.getElementById(previewContainerId);
            previewContainer.innerHTML = ''; 
            let files = Array.from(input.files);
            if (files.length > maxFiles) {
                alert(`Chỉ được tối đa ${maxFiles} ảnh. Các ảnh thừa đã bị loại bỏ.`);
                
                const dataTransfer = new DataTransfer();
                files.slice(0, maxFiles).forEach(file => dataTransfer.items.add(file));
                input.files = dataTransfer.files;
                files = Array.from(input.files); 
            }
    
            files.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const mediaDiv = document.createElement('div');
                    mediaDiv.classList.add('media-preview', 'position-relative', 'd-inline-block', 'me-2', 'mb-2');
    
                    if (isVideo) {
                        const video = document.createElement('video');
                        video.src = e.target.result;
                        video.classList.add('img-fluid', 'rounded', 'border');
                        video.style.maxHeight = '100px';
                        video.controls = true;
                        mediaDiv.appendChild(video);
                    } else {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('img-fluid', 'rounded', 'border');
                        img.style.maxHeight = '100px';
                        mediaDiv.appendChild(img);
                    }
    
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'position-absolute', 'top-0', 'end-0', 'm-1');
                    removeBtn.innerHTML = '&times;';
                    removeBtn.addEventListener('click', function() {
                        mediaDiv.remove();
                        removeFileFromInput(input, index); 
                        previewFiles(input, previewContainerId, isVideo, maxFiles); 
                    });
    
                    mediaDiv.appendChild(removeBtn);
                    previewContainer.appendChild(mediaDiv);
                };
                reader.readAsDataURL(file);
            });
        }
    
  
        function removeFileFromInput(input, indexToRemove) {
            const dataTransfer = new DataTransfer();
            Array.from(input.files).forEach((file, index) => {
                if (index !== indexToRemove) dataTransfer.items.add(file); 
            });
            input.files = dataTransfer.files; 
        }

        document.getElementById('logo').addEventListener('change', function() {
            previewFiles(this, 'logo_preview_container');
        });
    
        document.getElementById('product_image').addEventListener('change', function() {
            previewFiles(this, 'product_image_preview_container', false, 5);
        });
    
        document.getElementById('product_video').addEventListener('change', function() {
            previewFiles(this, 'product_video_preview_container', true);
        });
    </script>
    
    
@endpush
