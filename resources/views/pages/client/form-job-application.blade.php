@extends('layouts.app')
@section('title', 'Đăng ký tìm việc')
@push('styles')
    <style>
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
        #form-job-application{
            position: relative;
            margin: 30px auto;
            /* padding: 20px 0px 20px 0px; */
            max-width: 800px;
            background-color: #f8f9fa;
            border-radius: 8px;
            background: url('{{ asset('images/logo.png') }}') no-repeat;
            background-size: 30%;
            background-attachment: fixed;
            background-position: center center;
            z-index: 1;
        }
        .btn-success{
            background-color: #0056b3;
            transition: background-color 0.3s ease;
        }
        .btn-success:hover{
            background-color: #004494;
        }

        .btn:disabled{
            background-color: #004494;
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
    <section id="form-job-application" class="form-job-application mt-5rem">
        <div class="container">
            <div class="row">

                <form action="{{ route('job.application.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label for="full_name" class="form-label">Họ tên người lao động <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('full_name') is-invalid @enderror" id="full_name" name="full_name" placeholder="Nhập họ và tên" value="{{ old('full_name') }}" >
                            <span class="error-message"></span>
                            @error('full_name')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="birth_year" class="form-label">Năm sinh <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('birth_year') is-invalid @enderror" id="birth_year" name="birth_year" placeholder="Nhập năm sinh" value="{{ old('birth_year') }}" >
                            <span class="error-message"></span>
                            @error('birth_year')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label">Giới tính <span class="text-danger">*</span></label>
                            <div class="d-flex justify-content-around">
                                <div class="form-check me-1 ps-0">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ old('gender') == 'male' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="male">Nam</label>
                                </div>
                                <div class="form-check me-1">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ old('gender') == 'female' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="female">Nữ</label>
                                </div>
                                <div class="form-check me-1">
                                    <input class="form-check-input" type="radio" name="gender" id="other" value="other" {{ old('gender') == 'other' ? 'checked' : '' }} >
                                    <label class="form-check-label" for="other">Khác</label>
                                </div>
                            </div>
                            <span class="error-message gender-error"></span>
                            @error('gender')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="phone" class="form-label">Số điện thoại liên lạc<span class="text-danger">*</span></label>
                            <input type="tel" class="form-control form-control-sm @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Nhập số điện thoại" value="{{ old('phone') }}" >
                            <span class="error-message"></span>
                            @error('phone')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-4">
                            <label for="job_registration" class="form-label">Thông tin công việc cần tìm kiếm <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm @error('job_registration') is-invalid @enderror" id="job_registration" name="job_registration" placeholder="Nhập thông tin đăng ký tìm việc" >{{ old('job_registration') }}</textarea>
                            <span class="error-message"></span>
                            @error('job_registration')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="license" class="form-label">Upload CV:<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="file" id="file-uploads" name="cv" class=" @error('cv') is-invalid @enderror"
                                value="{{ old('cv') }}" style="display: none;">
                            <button type="button" class="btn bg-app-gv rounded-pill text-white" id="upload-button">
                                <i class="bi bi-upload"></i> Upload
                            </button>
                        </div>
                        @error('cv')
                            <div class="invalid-feedback d-block text-center" role="alert">{{ $message }}</div>
                        @enderror
                        <div id="upload-list" class="mt-2"></div>
                        <div id="error-message" class="error-message text-danger"></div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                    </div>
                    @if ($errors->has('error'))
                        <div class="invalid-feedback d-block text-center" role="alert">{{ $errors->first('error') }}</div>
                    @endif
                    <div id="recaptcha-error" class="text-danger text-center mt-2"></div>
                    <div class="text-center my-3">
                        <button type="submit" class="btn bg-app-gv rounded-pill text-white">Tìm việc</button>
                    </div>
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

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    if (file.type !== 'application/pdf') {
                        errorMessage.textContent = 'Vui lòng chỉ tải lên tệp PDF.';
                        showToast('vui lòng chỉ tải lên tệp PDF.', 'error');
                        fileInput.value = '';
                        return;
                    }

                    uploadButton.disabled = true;
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
    document.querySelector("form").addEventListener("submit", function(e) {
        const fileInput = document.getElementById("file-uploads");
        const errorMessage = document.getElementById("error-message");
        const recaptchaResponse = grecaptcha.getResponse();
        const recaptchaError = document.getElementById('recaptcha-error');

        if (!recaptchaResponse) {
            e.preventDefault();
            recaptchaError.textContent = 'Vui lòng hoàn thành CAPTCHA để tiếp tục.';
        } else {
            recaptchaError.textContent = '';
        }

        if (fileInput.files.length === 0) {
            e.preventDefault();
            errorMessage.textContent = "Vui lòng chọn file để tải lên.";
        } else {
            errorMessage.textContent = '';
        }
    });

</script>
@endpush
