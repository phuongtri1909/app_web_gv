@extends('pages.layouts.page')
{{-- @section('bg-page', asset('images/Vayvonkinhdoanh.jpg')) --}}

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
                        <input type="text" name="honey_pot" style="display:none;">
                        <input type="hidden" id="financial_support_id" name="financial_support_id" value="{{ $financialSupportId }}">
                        <div class="form-group">
                            <label for="name">Quý hội viên vui lòng điền thông tin "Họ và tên"</label>
                            <input type="text" id="name" name="name" placeholder="VD: Nguyễn Văn A..." required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Quý hội viên vui lòng điền thông tin "Số điện thoại"</label>
                            <input type="tel" id="phone" name="phone_number" required pattern="[0-9]{10}" placeholder="VD: 097XXXXXXX">
                        </div>

                        <div class="form-group">
                            <label>Quý hội viên quan tâm đến sản phẩm dành cho</label>
                            @foreach ($business_type as $type)
                                <div class="d-flex mx-3">
                                    <input type="radio" id="{{ $type->name }}" name="interest" value="{{ $type->id }}" required>
                                    <label for="{{ $type->name }}">{{ $type->name }}</label>
                                </div>
                            @endforeach
                        </div>


                        <div class="form-group">
                            <label>Quý hội viên quan tâm đến sản phẩm dịch vụ nào của ngân hàng</label>
                            @foreach ($bank_services as $service)
                                <div class="d-flex mx-3">
                                    <input type="radio" id="{{ $service->name }}" name="bank_service" value="{{ $service->id }}" required onchange="toggleOtherInput()">
                                    <label for="{{ $service->name }}">{{ $service->name }}</label>
                                </div>
                            @endforeach
                            <div class="d-flex mx-3">
                                <input type="radio" id="other" name="bank_service" value="other" required onchange="toggleOtherInput()">
                                <label for="other">Khác</label>
                            </div>
                            <input type="text" id="otherInput" class="optional-input" name="otherInput" placeholder="Vui lòng nhập dịch vụ khác..." style="display:none;">
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
