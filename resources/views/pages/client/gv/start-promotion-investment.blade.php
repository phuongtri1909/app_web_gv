@extends('layouts.app')
@section('title', 'Đăng ký Khởi nghiệp, Xúc tiến thương mại – Kêu gọi đầu tư')

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

        .error-message,
        .error-message1 {
            color: red;
            margin-top: 10px;
            font-size: 12px;
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


@section('content')
    <section id="start-promotion">
        <div class="container my-4">
            <div class="row">
                <form action="{{ route('form.start.promotion.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label for="name" class="form-label">Họ tên <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control form-control-sm @error('name') is-invalid @enderror"
                                id="name" name="name" placeholder="Nhập họ tên"
                                value="{{ old('name') }}">
                            <span class="error-message"></span>
                            @error('name')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <div class="col-md-4 mb-4">
                            <label for="birth_year" class="form-label">Năm sinh <span class="text-danger">*</span></label>
                            <input type="number"
                                class="form-control form-control-sm @error('birth_year') is-invalid @enderror"
                                id="birth_year" name="birth_year" placeholder="Nhập năm sinh"
                                value="{{ old('birth_year') }}">
                            @error('birth_year')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Giới tính <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-center">
                                <div class="form-check me-3">
                                    <input class="form-check-input @error('gender') is-invalid @enderror"
                                        type="radio" name="gender" id="genderMale" value="male"
                                        {{ old('gender') == 'male' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="genderMale">Nam</label>
                                </div>
                                <div class="form-check me-3">
                                    <input class="form-check-input @error('gender') is-invalid @enderror"
                                        type="radio" name="gender" id="genderFemale" value="female"
                                        {{ old('gender') == 'female' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="genderFemale">Nữ</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('gender') is-invalid @enderror"
                                        type="radio" name="gender" id="genderOther" value="other"
                                        {{ old('gender') == 'other' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="genderOther">Khác</label>
                                </div>
                            </div>
                            @error('gender')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control form-control-sm @error('phone') is-invalid @enderror"
                                id="phone" name="phone" placeholder="Nhập số điện thoại"
                                value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <div class="col-md-6 mb-4">
                            <label for="startup_address" class="form-label">Địa chỉ cư trú <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('startup_address') is-invalid @enderror"
                                id="startup_address" name="startup_address"
                                placeholder="Nhập địa chỉ cư trú" value="{{ old('startup_address') }}">
                            @error('startup_address')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                
                    <div class="row">
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
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label for="startup_activity_info" class="form-label">Thông tin hoạt động khởi nghiệp</label>
                            <textarea class="form-control form-control-sm @error('startup_activity_info') is-invalid @enderror"
                                id="startup_activity_info" name="startup_activity_info"
                                placeholder="Nhập thông tin">{{ old('startup_activity_info') }}</textarea>
                            @error('startup_activity_info')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row ">
                        <label>Nhu cầu hỗ trợ, kết nối:<span class="text-danger">*</span></label>

                        <div>
                            @foreach ($business_support_needs as $support_need)
                                <div>
                                    <label>
                                        <input type="checkbox" name="support_need[]" id="support_need_{{ $support_need->id }}" value="{{ $support_need->id }}" {{ is_array(old('support_need')) && in_array($support_need->id, old('support_need')) ? 'checked' : '' }}>
                                        {{ $support_need->name }}
                                    </label>                                    
                                </div>
                            @endforeach
                            <span class="support-need-error error-message"></span> 
                        </div>                        
                    </div>
                    {{-- <div class="d-flex justify-content-center">
                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                    </div>
                    @if ($errors->has('error'))
                        <div class="invalid-feedback d-block text-center" role="alert">{{ $errors->first('error') }}</div>
                    @endif
                    <div id="recaptcha-error" class="text-danger text-center mt-2"></div> --}}
                    <div class="text-end my-3">
                        <button type="submit" class="btn btn-success">Đăng ký</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush
