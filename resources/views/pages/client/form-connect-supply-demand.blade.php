@extends('pages.layouts.page')
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
    <section id="form-business" class="form-business mt-5rem">
        <div class="container">
            <div class="row">
                @include('pages.notification.success-error')
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row ">
                        <div class="col-md-4 mb-4">
                            <label for="owner_full_name" class="form-label">Họ tên chủ doanh nghiệp <span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control form-control-sm  @error('owner_full_name') is-invalid @enderror"
                                id="owner_full_name" name="owner_full_name" placeholder="Nhập họ và tên"
                                value="{{ old('owner_full_name') }}">
                            @error('owner_full_name')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        @php
                            $currentYear = date('Y');
                            $startYear = 1800;
                        @endphp
                        <div class="col-6 col-md-4 mb-4">
                            <label for="birth_year" class="form-label @error('birth_year') is-invalid @enderror">Năm sinh
                                <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm" id="birth_year" name="birth_year">
                                <option value="" disabled>Chọn năm sinh</option>
                                @for ($year = $currentYear; $year >= $startYear; $year--)
                                    <option value="{{ $year }}" {{ old('birth_year') == $year ? 'selected' : '' }}>
                                        {{ $year }}</option>
                                @endfor
                            </select>
                            @error('birth_year')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-6 col-md-4 mb-4">
                            <label class="form-label">Giới tính <span class="text-danger">*</span></label>
                            <div class="d-flex justify-content-around">
                                <div class="form-check me-1 ps-0">
                                    <input class="form-check-input" type="radio" name="gender" id="male"
                                        value="male" {{ old('gender') == 'male' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="male">Nam</label>
                                </div>
                                <div class="form-check me-1">
                                    <input class="form-check-input" type="radio" name="gender" id="female"
                                        value="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="female">Nữ</label>
                                </div>
                                <div class="form-check me-1">
                                    <input class="form-check-input" type="radio" name="gender" id="other"
                                        value="other" {{ old('gender') == 'other' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="other">Khác</label>
                                </div>
                            </div>
                            @error('gender')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="residential_address" class="form-label">Địa chỉ cư trú <span
                                    class="text-danger">*</span></label>
                            <input type="address" class="form-control form-control-sm  @error('residential_address') is-invalid @enderror"
                                id="residential_address" placeholder="Nhập địa chỉ" name="residential_address"
                                value="{{ old('residential_address') }}">
                            @error('residential_address')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="business_address" class="form-label">Địa chỉ kinh doanh <span
                                    class="text-danger">*</span></label>
                            <input type="address" class="form-control form-control-sm  @error('business_address') is-invalid @enderror"
                                id="business_address" placeholder="Nhập địa chỉ" name="business_address"
                                value="{{ old('business_address') }}">
                            @error('business_address')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="col-6 col-md-4 mb-4">
                            <label for="phone" class="form-label">Số điện thoại <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm  @error('phone') is-invalid @enderror" id="phone"
                                placeholder="Nhập số điện thoại" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="col-6 col-md-4 mb-4">
                            <label for="business_code" class="form-label">Mã số thuế <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('business_code') is-invalid @enderror"
                                id="business_code" placeholder="Nhập mã số thuế" name="business_code"
                                value="{{ old('business_code') }}">
                            @error('business_code')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="business_name" class="form-label">Tên doanh nghiệp/hộ kinh doanh <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('business_name') is-invalid @enderror"
                                id="business_name" placeholder="Nhập tên doanh nghiệp/hộ kinh doanh" name="business_name"
                                value="{{ old('business_name') }}">
                            @error('business_name')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="business_field" class="form-label">Ngành nghề kinh doanh <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('business_field') is-invalid @enderror"
                                id="business_field" placeholder="Nhập ngành nghề kinh doanh" name="business_field"
                                value="{{ old('business_field') }}">
                            @error('business_field')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror"
                                id="email" placeholder="Nhập email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="fanpage" class="form-label">Fanpage</label>
                            <input type="url" class="form-control form-control-sm @error('fanpage') is-invalid @enderror"
                                id="fanpage" placeholder="Nhập URL fanpage" name="fanpage"
                                value="{{ old('fanpage') }}">
                            @error('fanpage')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="product_info" class="form-label">Thông tin về sản phẩm <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm @error('product_info') is-invalid @enderror" id="product_info"
                                placeholder="Nhập thông tin về sản phẩm" name="product_info">{{ old('product_info') }}</textarea>
                            @error('product_info')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="product_standard" class="form-label">Tiêu chuẩn, xuất xứ <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm @error('product_standard') is-invalid @enderror" id="product_standard"
                                placeholder="Nhập tiêu chuẩn, xuất xứ" name="product_standard">{{ old('product_standard') }}</textarea>
                            @error('product_standard')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="product_avatar" class="form-label">Hình ảnh sản phẩm <span
                                    class="text-danger">*</span></label>
                            <input type="file" class="form-control form-control-sm @error('product_avatar') is-invalid @enderror"
                                id="product_avatar" name="product_avatar" accept="image/*">
                            @error('product_avatar')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                            <img id="avatar_preview" src="#" alt="Avatar Preview" class="img-fluid mt-3"
                                style="display: none; max-height: 200px;">
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="product_images" class="form-label">Hình ảnh sản phẩm (nhiều ảnh)</label>
                            <input type="file" class="form-control form-control-sm @error('product_images') is-invalid @enderror"
                                id="product_images" name="product_images[]" multiple accept="image/*">
                            @error('product_images')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                            <div id="image_preview_container" class="mt-3"></div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="product_price" class="form-label">Giá bán sản phẩm <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-sm @error('product_price') is-invalid @enderror"
                                id="product_price" placeholder="Nhập giá bán sản phẩm" name="product_price"
                                value="{{ old('product_price') }}">
                            @error('product_price')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="product_price_mini_app" class="form-label">Giá bán sản phẩm trên mini app (giảm
                                trên 5%) <span class="text-danger">*</span></label>
                            <input type="number"
                                class="form-control form-control-sm @error('product_price_mini_app') is-invalid @enderror"
                                id="product_price_mini_app" placeholder="Nhập giá bán sản phẩm trên mini app"
                                name="product_price_mini_app" value="{{ old('product_price_mini_app') }}">
                            @error('product_price_mini_app')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="product_price_member" class="form-label">Giá bán sản phẩm dành cho hội viên hội
                                Doanh nghiệp quận <span class="text-danger">*</span></label>
                            <input type="number"
                                class="form-control form-control-sm @error('product_price_member') is-invalid @enderror"
                                id="product_price_member"
                                placeholder="Nhập giá bán sản phẩm dành cho hội viên hội Doanh nghiệp quận"
                                name="product_price_member" value="{{ old('product_price_member') }}">
                            @error('product_price_member')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="price_apply_time" class="form-label">Thời gian áp dụng giá bán <span
                                    class="text-danger">*</span></label>
                            <div class="d-flex">
                                <input type="text" class="form-control form-control-sm @error('start_date') is-invalid @enderror me-2"
                                    id="start_date" placeholder="Từ ngày" name="start_date"
                                    value="{{ old('start_date') }}">
                                <input type="text" class="form-control form-control-sm @error('end_date') is-invalid @enderror"
                                    id="end_date" placeholder="Đến ngày" name="end_date"
                                    value="{{ old('end_date') }}">
                            </div>
                            @error('start_date')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                            @error('end_date')
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
        flatpickr("#start_date", {
            dateFormat: "Y-m-d",
        });
        flatpickr("#end_date", {
            dateFormat: "Y-m-d",
        });

        document.getElementById('product_avatar').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('avatar_preview');
                    img.src = e.target.result;
                    img.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });


        document.getElementById('product_images').addEventListener('change', function(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('image_preview_container');
            previewContainer.innerHTML = ''; // Clear previous previews

            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgDiv = document.createElement('div');
                    imgDiv.classList.add('image-preview', 'position-relative', 'd-inline-block', 'me-2',
                        'mb-2');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-fluid', 'rounded', 'border');
                    img.style.maxHeight = '100px';

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'position-absolute', 'top-0',
                        'end-0', 'm-1');
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
