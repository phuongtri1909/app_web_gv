@extends('layouts.app')
@section('title', 'Đăng ký doanh nghiệp')
@section('description', 'Đăng ký doanh nghiệp')
@section('keyword', 'Đăng ký doanh nghiệp')
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

        .error-message,.error-message1 {
            color: red;
            margin-top: 10px;
        }
        .btn-success{
            background-color: #0056b3;
            transition: background-color 0.3s ease;
        }
        .btn-success:hover{
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
    .btn:disabled{
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
                            <label for="">Hình ảnh đại diện doanh nghiệp</label>
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
                                value="{{ old('avt_businesses') }}" style="display: none;" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label for="representative_name" class="form-label">Họ tên chủ doanh nghiệp <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('representative_name') is-invalid @enderror"
                                id="representative_name" name="representative_name" placeholder="Nhập họ tên chủ doanh nghiệp"
                                value="{{ old('representative_name') }}" required>
                            @error('representative_name')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="birth_year" class="form-label">Năm sinh:<span class="text-danger">*</span></label>
                            <input type="text" id="birth_year" name="birth_year" class="form-control form-control-sm @error('birth_year') is-invalid @enderror" required placeholder="Nhập năm sinh" value="{{ old('birth_year') }}">
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
                            <input type="tel" class="form-control form-control-sm @error('phone_number') is-invalid @enderror"
                                id="phone" placeholder="Nhập số điện thoại" name="phone_number"
                                value="{{ old('phone_number') }}" required>
                            @error('phone_number')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="address" class="form-label">Địa chỉ cư trú <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('address') is-invalid @enderror"
                                id="address" placeholder="Nhập địa chỉ" name="address" value="{{ old('address') }}" required>
                            @error('address')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="business_address" class="form-label">Địa chỉ kinh doanh:<span class="text-danger">*</span></label>
                            <input type="text" id="business_address" name="business_address" class="form-control form-control-sm @error('business_address') is-invalid @enderror" placeholder="Nhập địa chỉ kinh doanh" value="{{ old('business_address') }}" required>
                            @error('business_address')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label for="ward" class="form-label">Phường:</label>
                            <select class="form-select form-control form-select-sm @error('ward_id') is-invalid @enderror" id="ward" name="ward_id">
                                @foreach ($wards as $ward)
                                    <option value="{{ $ward->id }}" {{ old('ward_id') == $ward->id ? 'selected' : '' }}>{{ $ward->name }}</option>
                                @endforeach
                            </select>
                            @error('ward_id')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="businessName" class="form-label @error('business_name') is-invalid @enderror">Tên doanh nghiệp <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('business_name') is-invalid @enderror" id="businessName" name="business_name"
                                placeholder="Nhập tên doanh nghiệp" value="{{ old('business_name') }}" required>
                            @error('business_name')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="business_fields" class="form-label">Ngành nghề kinh doanh:</label>
                            <select class="form-select form-control form-select-sm @error('business_fields') is-invalid @enderror" id="business_fields" name="business_fields">
                                @foreach ($business_fields as $field)
                                    <option value="{{ $field->id }}" {{ old('business_fields') == $field->id ? 'selected' : '' }}>{{ $field->name }}</option>
                                @endforeach
                            </select>
                            @error('business_fields')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="license" class="form-label @error('business_license') is-invalid @enderror">Giấy phép kinh doanh</label>
                            <div class="input-group">
                                <input type="file" id="file-uploads" name="business_license" accept="application/pdf"
                                    value="{{ old('business_license') }}" style="display: none;" required >
                                <button type="button" class="btn btn-success @error('business_license') is-invalid @enderror" id="upload-button">
                                    <i class="bi bi-upload"></i> Upload
                                </button>
                            </div>
                            @error('business_license')
                                <div class="invalid-feedback d-block text-center" role="alert">{{ $message }}</div>
                            @enderror
                            <div id="upload-list" class="mt-2"></div>
                            <div id="error-message" class="error-message text-danger"></div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-md-4 mb-4">
                            <label for="businessCode" class="form-label">Mã số thuế <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('business_code') is-invalid @enderror"
                                id="businessCode" name="business_code" placeholder="Nhập mã số thuế"
                                value="{{ old('business_code') }}" required>
                            @error('business_code')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="email" class="form-label">Email doanh nghiệp</label>
                            <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror"
                                id="email" placeholder="Nhập email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="social" class="form-label">Fanpage</label>
                            <input type="url" class="form-control form-control-sm @error('social_channel') is-invalid @enderror"
                                id="social" placeholder="Nhập link fanpage" value="{{ old('social_channel') }}"
                                name="social_channel">
                            @error('social_channel')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="form-label">Thông tin doanh nghiệp</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" rows="4" placeholder="Thông tin doanh nghiệp" name="description">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                    </div>

                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </form>

            </div>
        </div>
    </section>
@endsection


@push('scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script>
        document.getElementById('upload-button').addEventListener('click', function() {
            const fileInput = document.getElementById('file-uploads');
            fileInput.click();

            fileInput.addEventListener('change', function() {
                const uploadList = document.getElementById('upload-list');
                const errorMessage = document.getElementById('error-message');
                uploadList.innerHTML = '';
                errorMessage.textContent = '';

                const files = fileInput.files;

                const uploadButton = document.getElementById('upload-button');
                if (files.length > 0) {
                    uploadButton.disabled = true;

                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        const fileItem = document.createElement('div');
                        fileItem.classList.add('uploaded-file');


                        const removeIcon = document.createElement('i');
                        removeIcon.classList.add('fa-solid', 'fa-trash');
                        removeIcon.style.cursor = 'pointer';
                        removeIcon.style.marginLeft = '10px';


                        removeIcon.addEventListener('click', function() {

                            uploadList.removeChild(fileItem);
                            errorMessage.textContent = '';
                            const newFiles = Array.from(fileInput.files).filter((_, index) =>
                                index !== i);
                            const dataTransfer = new DataTransfer();
                            newFiles.forEach(file => dataTransfer.items.add(file));
                            fileInput.files = dataTransfer.files;


                            if (newFiles.length === 0) {
                                uploadButton.disabled = false;
                            }
                        });

                        if (file.type === 'application/pdf') {
                            const fileIcon = document.createElement('i');
                            fileIcon.classList.add('bi', 'bi-file-earmark-pdf');
                            const fileName = document.createElement('span');
                            fileName.textContent = file.name;
                            fileItem.appendChild(fileIcon);
                            fileItem.appendChild(fileName);
                            fileItem.appendChild(removeIcon);
                            uploadList.appendChild(fileItem);
                        } else if (file.type.startsWith('image/')) {
                            const img = document.createElement('img');
                            img.src = URL.createObjectURL(file);
                            img.alt = file.name;
                            img.style.maxWidth = '100px';
                            img.style.marginRight = '10px';
                            img.style.width = '75px';
                            img.style.height = '65px';
                            const fileIcon = document.createElement('span');
                            fileIcon.textContent = file.name;
                            fileItem.appendChild(img);
                            fileItem.appendChild(fileIcon);
                            fileItem.appendChild(removeIcon);
                            errorMessage.textContent = file.name +
                                ' không hợp lệ: Vui lòng chỉ tải lên tệp PDF.';
                            uploadList.appendChild(fileItem);
                        } else {
                            const fileIcon = document.createElement('span');
                            fileIcon.textContent = file.name;
                            fileIcon.style.marginRight = '10px';
                            const fileTypeIcon = document.createElement('i');
                            fileTypeIcon.classList.add('bi', 'bi-file-earmark');
                            fileItem.appendChild(fileTypeIcon);
                            fileItem.appendChild(fileIcon);
                            fileItem.appendChild(removeIcon);

                            errorMessage.textContent = file.name +
                                ' không hợp lệ: Vui lòng chỉ tải lên tệp PDF.';
                            uploadList.appendChild(fileItem);
                        }
                    }
                } else {
                    errorMessage.textContent = 'Vui lòng chọn tệp để tải lên.';
                }
            });
        });
    </script>

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
