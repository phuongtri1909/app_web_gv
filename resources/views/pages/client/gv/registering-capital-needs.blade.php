@extends('pages.layouts.page')

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

        #form-business {
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
                            <label for="business_name" class="form-label">Tên doanh nghiệp <span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control form-control-sm @error('business_name') is-invalid @enderror"
                                id="business_name" name="business_name" placeholder="Nhập tên doanh nghiệp"
                                value="{{ old('business_name') }}">
                            @error('business_name')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="business_code" class="form-label">Mã số doanh nghiệp/Mã số thuế <span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control form-control-sm @error('business_code') is-invalid @enderror"
                                id="business_code" name="business_code" placeholder="Nhập mã số doanh nghiệp/mã số thuế"
                                value="{{ old('business_code') }}">
                            @error('business_code')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="business_type" class="form-label">Loại hình doanh nghiệp <span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control form-control-sm @error('business_type') is-invalid @enderror"
                                id="business_type" name="business_type" placeholder="Nhập loại hình doanh nghiệp"
                                value="{{ old('business_type') }}">
                            @error('business_type')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label for="address" class="form-label">Địa chỉ trụ sở chính <span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control form-control-sm @error('address') is-invalid @enderror" id="address"
                                name="address" placeholder="Nhập địa chỉ trụ sở chính" value="{{ old('address') }}">
                            @error('address')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="phone" class="form-label">Điện thoại <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('phone') is-invalid @enderror"
                                id="phone" name="phone" placeholder="Nhập số điện thoại" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="fax" class="form-label">Fax</label>
                            <input type="text" class="form-control form-control-sm @error('fax') is-invalid @enderror"
                                id="fax" name="fax" placeholder="Nhập số fax" value="{{ old('fax') }}">
                            @error('fax')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror"
                                id="email" name="email" placeholder="Nhập email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="representative_name" class="form-label">Người đại diện pháp luật <span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control form-control-sm @error('representative_name') is-invalid @enderror"
                                id="representative_name" name="representative_name" placeholder="Nhập tên người đại diện"
                                value="{{ old('representative_name') }}">
                            @error('representative_name')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="gender" class="form-label">Giới tính <span class="text-danger">*</span></label>
                            <select id="gender" name="gender" class="form-control form-control-sm">
                                <option value="" disabled selected>Chọn giới tính</option>
                                <option value="male">Nam</option>
                                <option value="female">Nữ</option>
                                <option value="other">Khác</option>
                            </select>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="interest_rate">Lãi suất:</label>
                            <input type="text" class="form-control form-control-sm" id="interest_rate"
                                name="interest_rate" placeholder="Nhập lãi suất mong muốn">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="finance">Tài chính:</label>
                            <input type="text" class="form-control form-control-sm" id="finance" name="finance"
                                placeholder="Nhập số tiền tài chính (đồng)">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="mortgage_policy">Chính sách vay thế chấp:</label>
                            <input type="text" class="form-control form-control-sm" id="mortgage_policy"
                                name="mortgage_policy" placeholder="Nhập chính sách vay thế chấp">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="unsecured_policy">Tín chấp:</label>
                            <input type="text" class="form-control form-control-sm" id="unsecured_policy"
                                name="unsecured_policy" placeholder="Nhập thông tin tín chấp">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="purpose">Mục đích:</label>
                            <input type="text" class="form-control form-control-sm" id="purpose" name="purpose"
                                placeholder="Nhập mục đích vay">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="bank_connection">Kết nối ngân hàng:</label>
                            <input type="text" class="form-control form-control-sm" id="bank_connection"
                                name="bank_connection" placeholder="Nhập tên ngân hàng kết nối">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="feedback">Phản ánh về việc giải quyết của ngân hàng:</label>
                            <textarea class="form-control form-control-sm" id="feedback" name="feedback" rows="3"
                                placeholder="Nhập phản ánh của bạn"></textarea>
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
