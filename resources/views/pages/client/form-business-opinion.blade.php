@extends('pages.layouts.page')
@section('title', 'Ý kiên doanh nghiệp')
@section('description', 'Ý kiên doanh nghiệp')
@push('styles')
    <style>
        .form-control:focus,
        .form-control:hover,
        .upload-label:focus,
        .upload-label:hover {
            border-color: #00d274;
            box-shadow: 0 0 0 2px rgba(5, 255, 95, 0.1);
            outline: 0;
        }

        .error-message,
        .error-message1 {
            color: red;
            margin-top: 10px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('content')
    <section id="form-business-opinion" class="form-business-opinion mt-5rem">
        <div class="container">
            <div class="row">
                @include('pages.notification.success-error')
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label for="opinion" class="form-label">Ý kiến <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm @error('opinion') is-invalid @enderror" id="opinion" name="opinion" placeholder="Nhập ý kiến">{{ old('opinion') }}</textarea>
                            @error('opinion')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-4">
                            <label for="attached_images" class="form-label">Hình ảnh đính kèm <span class="text-danger">*</span></label>
                            <input type="file" class="form-control form-control-sm @error('attached_images') is-invalid @enderror" id="attached_images" name="attached_images[]" multiple accept="image/*">
                            @error('attached_images')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                            <div id="image_preview_container" class="mt-3"></div>
                        </div>

                        <div class="col-md-12 mb-4">
                            <label for="suggestions" class="form-label">Kiến nghị, đề xuất <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm @error('suggestions') is-invalid @enderror" id="suggestions" name="suggestions" placeholder="Nhập kiến nghị, đề xuất">{{ old('suggestions') }}</textarea>
                            @error('suggestions')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="owner_full_name" class="form-label">Họ tên chủ doanh nghiệp</label>
                            <input type="text" class="form-control form-control-sm @error('owner_full_name') is-invalid @enderror" id="owner_full_name" name="owner_full_name" placeholder="Nhập họ và tên" value="{{ old('owner_full_name') }}">
                            @error('owner_full_name')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-6 col-md-6 mb-4">
                            <label for="birth_year" class="form-label">Năm sinh</label>
                            <input type="text" class="form-control form-control-sm @error('birth_year') is-invalid @enderror" id="birth_year" name="birth_year" placeholder="Nhập năm sinh" value="{{ old('birth_year') }}">
                            @error('birth_year')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-6 col-md-6 mb-4">
                            <label class="form-label">Giới tính</label>
                            <div class="d-flex justify-content-around">
                                <div class="form-check me-1 ps-0">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ old('gender') == 'male' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="male">Nam</label>
                                </div>
                                <div class="form-check me-1">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="female">Nữ</label>
                                </div>
                                <div class="form-check me-1">
                                    <input class="form-check-input" type="radio" name="gender" id="other" value="other" {{ old('gender') == 'other' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="other">Khác</label>
                                </div>
                            </div>
                            @error('gender')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="phone" class="form-label">Số điện thoại liên hệ</label>
                            <input type="text" class="form-control form-control-sm @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Nhập số điện thoại" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-4">
                            <label for="residential_address" class="form-label">Địa chỉ cư trú</label>
                            <input type="text" class="form-control form-control-sm @error('residential_address') is-invalid @enderror" id="residential_address" name="residential_address" placeholder="Nhập địa chỉ cư trú" value="{{ old('residential_address') }}">
                            @error('residential_address')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-4">
                            <label for="business_name" class="form-label">Tên doanh nghiệp/hộ kinh doanh</label>
                            <input type="text" class="form-control form-control-sm @error('business_name') is-invalid @enderror" id="business_name" name="business_name" placeholder="Nhập tên doanh nghiệp/hộ kinh doanh" value="{{ old('business_name') }}">
                            @error('business_name')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-4">
                            <label for="business_address" class="form-label">Địa chỉ kinh doanh</label>
                            <input type="text" class="form-control form-control-sm @error('business_address') is-invalid @enderror" id="business_address" name="business_address" placeholder="Nhập địa chỉ kinh doanh" value="{{ old('business_address') }}">
                            @error('business_address')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        

                        <div class="col-md-12 mb-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" id="email" name="email" placeholder="Nhập email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-6 col-md-12 mb-4">
                            <label for="business_license" class="form-label">Giấy phép kinh doanh</label>
                            <input type="file" class="form-control form-control-sm @error('business_license') is-invalid @enderror" id="business_license" name="business_license" accept="application/pdf">
                            @error('business_license')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-6 col-md-12 mb-4">
                            <label for="fanpage" class="form-label">Fanpage</label>
                            <input type="url" class="form-control form-control-sm @error('fanpage') is-invalid @enderror" id="fanpage" name="fanpage" placeholder="Nhập URL fanpage" value="{{ old('fanpage') }}">
                            @error('fanpage')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="text-end my-3">
                        <button type="submit" class="btn btn-success">Lưu xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.getElementById('attached_images').addEventListener('change', function(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('image_preview_container');
            previewContainer.innerHTML = ''; // Clear previous previews

            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgDiv = document.createElement('div');
                    imgDiv.classList.add('image-preview', 'position-relative', 'd-inline-block', 'me-2', 'mb-2');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-fluid', 'rounded', 'border');
                    img.style.maxHeight = '100px';

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'position-absolute', 'top-0', 'end-0', 'm-1');
                    removeBtn.innerHTML = '&times;';
                    removeBtn.addEventListener('click', function() {
                        imgDiv.remove();
                    });

                    imgDiv.appendChild(img);
                    imgDiv.appendChild(removeBtn);
                    previewContainer.appendChild(imgDiv);
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endpush