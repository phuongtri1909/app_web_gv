@extends('pages.layouts.page')
{{-- @section('bg-page', asset('images/Vayvonkinhdoanh.jpg')) --}}

@push('child-styles')
    <style>
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

        input[type="text"],
        input[type="tel"],
        input[type="email"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

       .submit-btn {
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
        .form-container {
            padding: 15px;
        }
        .banner {
                height: auto;
            }
        input[type="text"],
        input[type="tel"],
        input[type="email"],
        textarea,
        select {
            font-size: 14px;
        }

        .submit-btn {
            padding: 8px;
            font-size: 14px;
        }
    }

    @media (max-width: 480px) {
        .form-container {
            padding: 10px;
        }

        input[type="text"],
        input[type="tel"],
        input[type="email"],
        textarea,
        select {
            font-size: 12px;
        }

        .submit-btn {
            padding: 6px;
            font-size: 12px;
        }
    }
    </style>
@endpush

@section('content-page')
    <section id="form-customer">
        <div class="banner">
            <img src="{{asset('images/Vayvonkinhdoanh.jpg')}}" alt="Banner Image">
        </div>
        <div class="container my-5">
            <div class="row">
                <div class="form-container">
                    @include('pages.notification.success-error')
                    <form id="myForm" action="{{ route('store.form') }}" method="POST">
                        @csrf
                        <input type="hidden" id="financial_support_id" name="financial_support_id" value="{{ $financialSupportId }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="full_name">Họ tên:</label>
                                    <input type="text" id="full_name" name="full_name" class="form-control" required placeholder="Nhập họ tên">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="birth_year">Năm sinh:</label>
                                    <input type="text" id="birth_year" name="birth_year" class="form-control" required placeholder="Nhập năm sinh">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender">Giới tính:</label>
                                    <select id="gender" name="gender" class="form-control" required>
                                        <option value="" disabled selected>Chọn giới tính</option>
                                        <option value="male">Nam</option>
                                        <option value="female">Nữ</option>
                                        <option value="other">Khác</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_number">Số điện thoại liên hệ:</label>
                                    <input type="tel" id="phone_number" name="phone_number" class="form-control" required pattern="[0-9]{10}" placeholder="Nhập số điện thoại">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="residence_address">Địa chỉ cư trú:</label>
                            <input type="text" id="residence_address" name="residence_address" class="form-control" required placeholder="Nhập địa chỉ cư trú">
                        </div>

                        <div class="form-group">
                            <label for="business_address">Địa chỉ kinh doanh:</label>
                            <input type="text" id="business_address" name="business_address" class="form-control" placeholder="Nhập địa chỉ kinh doanh">
                        </div>

                        <div class="form-group">
                            <label for="company_name">Tên doanh nghiệp/hộ kinh doanh:</label>
                            <input type="text" id="company_name" name="company_name" class="form-control" placeholder="Nhập tên doanh nghiệp">
                        </div>

                        <div class="form-group">
                            <label for="business_field">Ngành nghề kinh doanh:</label>
                            <input type="text" id="business_field" name="business_field" class="form-control" placeholder="Nhập ngành nghề kinh doanh">
                        </div>

                        <div class="form-group">
                            <label for="tax_code">Mã số thuế:</label>
                            <input type="text" id="tax_code" name="tax_code" class="form-control" placeholder="Nhập mã số thuế">
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Nhập email">
                        </div>

                        <div class="form-group">
                            <label for="fanpage">Fanpage:</label>
                            <input type="text" id="fanpage" name="fanpage" class="form-control" placeholder="Nhập fanpage">
                        </div>

                        <div class="form-group">
                            <label for="support_needs">Nhu cầu hỗ trợ, kết nối:</label>
                            <textarea id="support_needs" name="support_needs" class="form-control" placeholder="Nhập nhu cầu hỗ trợ, kết nối"></textarea>
                        </div>

                        <button type="submit" class="submit-btn">Gửi</button>
                    </form>
                </div>
            </div>
        </div>
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
