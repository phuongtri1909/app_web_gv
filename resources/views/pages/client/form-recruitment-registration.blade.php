@extends('layouts.app')
@section('title', 'Đăng ký tuyển dụng')
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

        .btn-success {
            background-color: #0056b3;
            transition: background-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #004494;
        }

        .error-message,
        .error-message1 {
            color: red;
            margin-top: 10px;
            font-size: 12px;
        }

        #form-business {
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
        <div class="container">
            <div class="row">

                <form action="{{ route('recruitment.registration.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-md-12 mb-4">
                            <label for="recruitment_title" class="form-label ">Tiêu đề tuyển dụng <span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control form-control-sm @error('recruitment_title') is-invalid @enderror"
                                id="recruitment_title" name="recruitment_title" value="{{ old('recruitment_title') }}"
                                placeholder="Nhập tiêu đề tuyển dụng" required>
                            <span class="error-message"></span>
                            @error('recruitment_title')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-4">
                            <label for="recruitment_content" class="form-label">Thông tin công việc tuyển dụng <span
                                    class="text-danger">*</span></label>
                            <textarea required class="form-control form-control-sm @error('recruitment_content') is-invalid @enderror"
                                id="recruitment_content" name="recruitment_content"> {{ old('recruitment_content') }}</textarea>
                            <span class="error-message"></span>
                            @error('recruitment_content')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6 mb-4">
                            <label for="recruitment_images" class="form-label">Hình ảnh công việc (Tối đa 4 ảnh) <span
                                    class="text-danger">*</span></label>
                            <input type="file"
                                class="form-control form-control-sm @error('recruitment_images') is-invalid @enderror"
                                id="recruitment_images" name="recruitment_images[]" multiple
                                accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                            @error('recruitment_images')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                            <div id="image_preview_container" class="mt-3"></div>
                        </div>


                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                    </div>
                    @if ($errors->has('error'))
                        <div class="invalid-feedback d-block text-center" role="alert">{{ $errors->first('error') }}</div>
                    @endif
                    <div id="recaptcha-error" class="text-danger text-center mt-2"></div>
                    <div class="text-center my-3">
                        <button type="submit" class="btn bg-app-gv rounded-pill text-white">Tuyển dụng</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        document.getElementById('recruitment_images').addEventListener('change', function(event) {
            const files = event.target.files;
            if (files.length > 4) {
                showToast('Chỉ được chọn tối đa 4 ảnh sản phẩm', 'error');
                event.target.value = ''; // Clear the input
            } else {
                // Optionally, you can add code here to preview the selected images
                const previewContainer = document.getElementById('image_preview_container');
                previewContainer.innerHTML = ''; // Clear previous previews
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('img-thumbnail', 'me-2', 'mb-2');
                        img.style.maxWidth = '100px';
                        img.style.maxHeight = '100px';
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            }
        });
    </script>

    <script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js')}}"></script>
    <script src="{{ asset('ckeditor/config.js')}}"></script>
    <script>
        CKEDITOR.replace("recruitment_content", {
        });
    </script>
@endpush
