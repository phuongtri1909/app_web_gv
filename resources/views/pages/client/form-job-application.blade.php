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
                @include('pages.notification.success-error')
                <form action="{{ route('job.application.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label for="full_name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('full_name') is-invalid @enderror" id="full_name" name="full_name" placeholder="Nhập họ và tên" value="{{ old('full_name') }}">
                            @error('full_name')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="birth_year" class="form-label">Năm sinh <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('birth_year') is-invalid @enderror" id="birth_year" name="birth_year" placeholder="Nhập năm sinh" value="{{ old('birth_year') }}">
                            @error('birth_year')
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

                        <div class="col-md-4 mb-4">
                            <label for="phone" class="form-label">Điện thoại <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Nhập số điện thoại" value="{{ old('phone') }}">
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

                        <div class="col-md-12 mb-4">
                            <label for="introduction" class="form-label">Thông tin/giới thiệu bản thân <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm @error('introduction') is-invalid @enderror" id="introduction" name="introduction" placeholder="Nhập thông tin/giới thiệu bản thân">{{ old('introduction') }}</textarea>
                            @error('introduction')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-4">
                            <label for="job_registration" class="form-label">Đăng ký tìm việc <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm @error('job_registration') is-invalid @enderror" id="job_registration" name="job_registration" placeholder="Nhập thông tin đăng ký tìm việc">{{ old('job_registration') }}</textarea>
                            @error('job_registration')
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