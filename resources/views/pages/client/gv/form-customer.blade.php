@extends('pages.layouts.page')
@section('bg-page', asset('images/Vayvonkinhdoanh.jpg'))
@section('title-page', __(''))

@push('child-styles')
    <style>
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 700px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="tel"] {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        input[type="radio"] {
            appearance: none;
            -webkit-appearance: none;
            display: inline-block;
            width: 20px;
            height: 20px;
            background-color: white;
            border: 2px solid #ccc;
            margin-right: 8px;
            border-radius: 4px;
            position: relative;
            cursor: pointer;
        }

        input[type="radio"]:checked::after {
            content: '';
            display: block;
            width: 10px;
            height: 10px;
            background-color: #007bff;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 5px;
        }

        .optional-input {
            display: none;
            margin-top: 10px;
        }

        .submit-btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }
    </style>
@endpush

@section('content-page')
    <section id="form-customer">
        <div class="container">
            <div class="row">
                <div class="form-container">
                    <form id="myForm">
                        <div class="form-group">
                            <label for="name">Quý hội viên vui lòng điền thông tin "Họ và tên"</label>
                            <input type="text" id="name" name="name" placeholder="VD:Nguyễn Văn A..." required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Quý hội viên vui lòng điền thông tin "Số điện thoại"</label>
                            <input type="tel" id="phone" name="phone" required pattern="[0-9]{10}"
                                placeholder="VD: 097XXXXXXX">
                        </div>

                        <div class="form-group">
                            <label>Quý hội viên quan tâm đến sản phẩm dành cho</label>
                            <div class="d-flex mx-3">
                                <input type="radio" id="personal" name="interest" value="personal" required>
                                <label for="personal">Cá nhân / Hộ Kinh Doanh</label>
                            </div>
                            <div class="d-flex mx-3">
                                <input type="radio" id="business" name="interest" value="business" required>
                                <label for="business">Doanh nghiệp</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Quý hội viên quan tâm đến sản phẩm dịch vụ nào của ngân hàng</label>
                            <div class="d-flex mx-3">
                                <input type="radio" id="openaccount" name="interest" value="openaccount" required>
                                <label for="openaccount">Mở tài khoản</label>
                            </div>
                            <div class="d-flex mx-3">
                                <input type="radio" id="borrow" name="interest" value="borrow" required>
                                <label for="borrow">Vay</label>
                            </div>
                            <div class="d-flex mx-3">
                                <input type="radio" id="thrifty" name="interest" value="thrifty" required>
                                <label for="thrifty">Tiết kiệm</label>
                            </div>
                            <div class="d-flex mx-3">
                                <input type="radio" id="credit" name="interest" value="credit" required>
                                <label for="credit">Thẻ tín dụng</label>
                            </div>
                            <div class="d-flex mx-3">
                                <input type="radio" id="other" name="interest" value="other" required>
                                <label for="other">Khác</label>
                            </div>
                            <input type="text" id="otherInput" class="optional-input" name="otherInput"
                                placeholder="Vui lòng nhập dịch vụ khác...">
                        </div>

                        <div class="form-group">
                            <label for="time">Quý hội viên mong muốn sẽ được liên hệ vào khung thời gian nào</label>
                            <input type="text" id="time" name="time" placeholder="VD: Từ 7h đến 9h ngày 21/10/2024" required>
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
        document.getElementById('other').addEventListener('change', function() {
            document.getElementById('otherInput').style.display = 'block';
            document.getElementById('otherInput').setAttribute('required', true);
        });

        document.querySelectorAll('input[name="interest"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value !== 'other') {
                    document.getElementById('otherInput').style.display = 'none';
                    document.getElementById('otherInput').removeAttribute('required');
                    document.getElementById('otherInput').value = '';
                }
            });
        });
    </script>
@endpush
