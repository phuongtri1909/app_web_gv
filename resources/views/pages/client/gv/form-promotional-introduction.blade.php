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
                <form action="{{ route('business.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label for="representative_name" class="form-label">Họ tên chủ doanh nghiệp <span
                                    class="text-danger">*</span></label>
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
                            <input type="text" id="birth_year" name="birth_year" class="form-control form-control-sm"
                                required placeholder="Nhập năm sinh">
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="gender" class="form-label">Giới tính:<span class="text-danger">*</span></label>
                            <select id="gender" name="gender" class="form-control form-select-sm form-control-sm" required>
                                <option value="" disabled selected>Chọn giới tính</option>
                                <option value="male">Nam</option>
                                <option value="female">Nữ</option>
                                <option value="other">Khác</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text"
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
                                class="form-control form-control-sm" placeholder="Nhập địa chỉ kinh doanh">
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
                            <input type="text" class="form-control form-control-sm" id="license" name="license"
                                placeholder="Nhập giấy phép kinh doanh">
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="business_field" class="form-label">Ngành nghề kinh doanh <span class="text-danger">*</span></label>
                            <select id="business_field" name="business_field" class="form-control form-control-sm @error('business_field') is-invalid @enderror">
                                <option value="" disabled selected>Chọn ngành nghề kinh doanh</option>
                                <option value="Ẩm thực">Ẩm thực</option>
                                <option value="Nhà hàng">Nhà hàng</option>
                                <option value="Khách sạn">Khách sạn</option>
                                <option value="Du lịch">Du lịch</option>
                                <option value="Thể thao">Thể thao</option>
                                <option value="Sản xuất">Sản xuất</option>
                                <option value="Thương mại">Thương mại</option>
                                <option value="Thời trang">Thời trang</option>
                                <option value="Điện máy">Điện máy</option>
                                <option value="Công nghệ">Công nghệ</option>
                                <option value="Y tế">Y tế</option>
                                <option value="Giáo dục">Giáo dục</option>
                                <option value="Khác">Khác</option>
                            </select>
                            @error('business_field')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label for="businessCode" class="form-label">Mã số thuế <span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control form-control-sm @error('business_code') is-invalid @enderror"
                                id="businessCode" name="business_code" placeholder="Nhập mã số thuế"
                                value="{{ old('business_code') }}">
                            @error('business_code')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="email" class="form-label">Email doanh nghiệp <span
                                    class="text-danger">*</span></label>
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
                        <label class="mb-2">Thông tin về doanh nghiệp, sản phẩm:<span
                            class="text-danger">*</span></label>
                        <div class="col-md-4 mb-4">
                            <label for="logo" class="form-label">Logo/ Hình ảnh đại diện doanh nghiệp:</label>
                            <input type="file" id="logo" name="logo" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="product_image" class="form-label">Hình ảnh doanh nghiệp, sản phẩm:</label>
                            <input type="file" id="product_image" name="product_image" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="product_video" class="form-label">Video về doanh nghiệp, sản phẩm:</label>
                            <input type="file" id="product_video" name="product_video" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="text-end my-3">
                        <button type="submit" class="btn btn-success">Đăng ký</button>
                    </div>
                </form>

            </div>
        </div>
    </section>
@endsection

@push('child-scripts')
@endpush
