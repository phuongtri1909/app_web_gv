@extends('pages.layouts.page')
@section('title', 'Đăng ký kết nối ngân hàng')

@push('child-styles')
    <style>
        .form-container {
            /* background-color: white; */
            /* padding: 20px; */
            border-radius: 8px;
            /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 15px;
        }
        .form-control:focus {
            color: #212529;
            background-color: #fff;
            border-color: #80bdff;
            box-shadow: 0 0 5px rgba(128, 189, 255, 0.5);
            outline: 0;
            box-shadow: unset;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

       .submit-btn:hover {
            background-color: #004494;
        }

        .banner {
        width: 100%;
        height: 400px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f0f0f0;
        }

        .banner img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }
        @media (max-width: 768px) {
        .banner {
                height: auto;
            }
        }
        #form-customer {
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
        .btn-success {
            background-color: #0056b3;
            transition: background-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #004494;
        }
        .btn-submit {
            width: 200px;
            padding: 10px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: block;
            margin: 20px auto;
            text-align: center;
        }
        .btn-submit:hover {
            background-color: #004494;
        }
    </style>
@endpush

@section('content-page')
    <section id="form-customer">
        {{-- <div class="banner">
            <img src="{{asset('images/Vayvonkinhdoanh.jpg')}}" alt="Banner Image">
        </div> --}}
        {{-- <div class="container my-5">
            <div class="row">
                <div class="form-container">
                    @include('pages.notification.success-error')
                    <form id="myForm" action="{{ route('store.form') }}" method="POST">
                        @csrf
                        @if (isset($slug))
                            <input type="hidden" id="slug" name="slug" value="{{ $slug}}">
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="full_name">Họ tên: <span class="text-danger">*</span></label>
                                    <input type="text" id="full_name" name="full_name" class="form-control form-control-sm @error('full_name') is-invalid @enderror" required placeholder="Nhập họ tên" value="{{ old('full_name') }}">
                                    @error('full_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="birth_year">Năm sinh: <span class="text-danger">*</span></label>
                                    <input type="text" id="birth_year" name="birth_year" class="form-control form-control-sm @error('birth_year') is-invalid @enderror" required placeholder="Nhập năm sinh" value="{{ old('birth_year') }}">
                                    @error('birth_year')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender">Giới tính: <span class="text-danger">*</span></label>
                                    <select id="gender" name="gender" class="form-control form-control-sm @error('gender') is-invalid @enderror" required>
                                        <option value="" disabled selected>Chọn giới tính</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Khác</option>
                                    </select>
                                    @error('gender')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_number">Số điện thoại liên hệ: <span class="text-danger">*</span></label>
                                    <input type="tel" id="phone_number" name="phone_number" class="form-control form-control-sm @error('phone_number') is-invalid @enderror" required pattern="[0-9]{10}" placeholder="Nhập số điện thoại" value="{{ old('phone_number') }}">
                                    @error('phone_number')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="residence_address">Địa chỉ cư trú: <span class="text-danger">*</span></label>
                            <input type="text" id="residence_address" name="residence_address" class="form-control form-control-sm @error('residence_address') is-invalid @enderror" required placeholder="Nhập địa chỉ cư trú" value="{{ old('residence_address') }}">
                            @error('residence_address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="business_address">Địa chỉ kinh doanh: <span class="text-danger">*</span></label>
                            <input type="text" id="business_address" name="business_address" class="form-control form-control-sm @error('business_address') is-invalid @enderror" placeholder="Nhập địa chỉ kinh doanh" value="{{ old('business_address') }}">
                            @error('business_address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="company_name">Tên doanh nghiệp/hộ kinh doanh: <span class="text-danger">*</span></label>
                            <input type="text" id="company_name" name="company_name" class="form-control form-control-sm @error('company_name') is-invalid @enderror" placeholder="Nhập tên doanh nghiệp" value="{{ old('company_name') }}">
                            @error('company_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="business_field">Ngành nghề kinh doanh: <span class="text-danger">*</span></label>
                            <input type="text" id="business_field" name="business_field" class="form-control form-control-sm @error('business_field') is-invalid @enderror" placeholder="Nhập ngành nghề kinh doanh" value="{{ old('business_field') }}">
                            @error('business_field')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tax_code">Mã số thuế: <span class="text-danger">*</span></label>
                            <input type="text" id="tax_code" name="tax_code" class="form-control form-control-sm @error('tax_code') is-invalid @enderror" placeholder="Nhập mã số thuế" value="{{ old('tax_code') }}">
                            @error('tax_code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" class="form-control form-control-sm @error('email') is-invalid @enderror" placeholder="Nhập email" value="{{ old('email') }}">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="fanpage">Fanpage:</label>
                            <input type="text" id="fanpage" name="fanpage" class="form-control form-control-sm @error('fanpage') is-invalid @enderror" placeholder="Nhập fanpage" value="{{ old('fanpage') }}">
                            @error('fanpage')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="support_needs">Nhu cầu hỗ trợ, kết nối: <span class="text-danger">*</span></label>
                            <textarea id="support_needs" name="support_needs" class="form-control form-control-sm @error('support_needs') is-invalid @enderror" placeholder="Nhập nhu cầu hỗ trợ, kết nối">{{ old('support_needs') }}</textarea>
                            @error('support_needs')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Gửi</button>
                        </div>
                    </form>

                </div>
            </div>
        </div> --}}
    </section>
@endsection
@push('child-scripts')
<script>
    function toggleOtherInput() {
        const otherInput = document.getElementById('otherInput');
        const otherRadio = document.getElementById('other');
        if (otherRadio.checked) {
            otherInput.style.display = 'block';
            otherInput.required = true;
        } else {
            otherInput.style.display = 'none';
            otherInput.value = '';
            otherInput.required = false;
        }
    }
</script>
@endpush
