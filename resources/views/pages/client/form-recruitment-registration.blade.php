@extends('pages.layouts.page')
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
        .btn-success{
            background-color: #0056b3;
            transition: background-color 0.3s ease;
        }
        .btn-success:hover{
            background-color: #004494;
        }
        .error-message,
        .error-message1 {
            color: red;
            margin-top: 10px;
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
                @include('pages.notification.success-error')
                <form action="{{route('recruitment.registration.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label for="business_name" class="form-label">Tên doanh nghiệp <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('business_name') is-invalid @enderror" id="business_name" name="business_name" placeholder="Nhập tên doanh nghiệp" value="{{ old('business_name') }}">
                            @error('business_name')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="business_code" class="form-label">Mã số doanh nghiệp/Mã số thuế <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('business_code') is-invalid @enderror" id="business_code" name="business_code" placeholder="Nhập mã số doanh nghiệp/Mã số thuế" value="{{ old('business_code') }}">
                            @error('business_code')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="category_business_id" class="form-label">Loại hình doanh nghiệp <span
                                    class="text-danger">*</span></label>
                            <select class="form-select form-control form-select-sm" id="category_business_id" name="category_business_id">
                                @foreach ($category_business as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_business_id')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="head_office_address" class="form-label">Địa chỉ trụ sở chính <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('head_office_address') is-invalid @enderror" id="head_office_address" name="head_office_address" placeholder="Nhập địa chỉ trụ sở chính" value="{{ old('head_office_address') }}">
                            @error('head_office_address')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="phone" class="form-label">Điện thoại <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control form-control-sm @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Nhập số điện thoại" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="fax" class="form-label">Fax</label>
                            <input type="text" class="form-control form-control-sm @error('fax') is-invalid @enderror" id="fax" name="fax" placeholder="Nhập số fax" value="{{ old('fax') }}">
                            @error('fax')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" id="email" name="email" placeholder="Nhập email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="representative_name" class="form-label">Người đại diện pháp luật <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('representative_name') is-invalid @enderror" id="representative_name" name="representative_name" placeholder="Nhập tên người đại diện pháp luật" value="{{ old('representative_name') }}">
                            @error('representative_name')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label">Giới tính <span class="text-danger">*</span></label>
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

                        <div class="col-md-12 mb-4">
                            <label for="recruitment_info" class="form-label">Thông tin đăng ký tuyển dụng nhân sự <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm @error('recruitment_info') is-invalid @enderror" id="recruitment_info" name="recruitment_info" placeholder="Nhập thông tin đăng ký tuyển dụng nhân sự">{{ old('recruitment_info') }}</textarea>
                            @error('recruitment_info')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
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
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

@endpush
