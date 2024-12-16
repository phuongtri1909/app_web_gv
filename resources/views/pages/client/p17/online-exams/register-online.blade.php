@extends('pages.client.p17.layouts.app')
@section('title', 'Thi trực tuyến')
@section('description', 'Thi trực tuyến')
@section('keyword', 'Thi trực tuyến')

@push('styles')
    <style>
        #register-online {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            min-height: 100vh;
        }

        h2 {
            font-size: 32px;
            font-weight: bold;
            color: #222;
            text-transform: uppercase;
        }

        .form-container {
            width: 800px;
            padding: 25px;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border: 1px solid #e0e0e0;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #111;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
            font-size: 15px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #bbb;
            border-radius: 6px;
            font-size: 15px;
            background: #fff;
            color: #333;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #333;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
            outline: none;
        }

        .captcha-code {
            margin-top: -18px;
            margin-bottom: 18px;
            padding: 5px;
            border-radius: 10px;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
        }

        .form-actions button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
        }

        .back-btn {
            background-color: #fff;
            border: 1px solid #007bff;
            color: #007bff;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 4px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease, transform 0.3s ease;
        }

        .back-btn:hover {
            color: #007bff;
            border-color: #0056b3;
            transform: translateY(-2px);
        }

        .back-icon {
            margin-right: 8px;
            font-size: 16px;
        }

        .submit-btn {
            background: linear-gradient(90deg, #0C63E7, #07C8F9);
            color: white;
            padding: 12px 20px;
            font-size: 14px;
            font-weight: bold;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
                box-shadow: none;
                border: none;
            }

            h2 {
                font-size: 24px;
            }

            .form-group input,
            .form-group select {
                padding: 10px;
                font-size: 14px;
            }

            .captcha-code {
                font-size: 14px;
                padding: 5px;
            }

            .form-actions button {
                padding: 8px 20px;
            }
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 20px;
            }

            .form-group input,
            .form-group select {
                font-size: 13px;
                padding: 8px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script></script>
@endpush

@section('content')
    <section id="register-online" class="py-8">
        <div class="form-container">
            <h2>Nhập thông tin cá nhân</h2>
            <form action="{{ route('p17.submit.competitions.exams.client') }}" method="POST" enctype="multipart/form-data" class="ad-form">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cccd">CCCD <span class="text-danger">*</span></label>
                            <input type="text" id="cccd" name="cccd" class="form-control form-control-sm @error('cccd') is-invalid @enderror" placeholder="Nhập CCCD" value="{{ old('cccd') }}" required>
                            @error('cccd')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="tel" id="phone" name="phone" class="form-control form-control-sm @error('phone') is-invalid @enderror" placeholder="Nhập số điện thoại" value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="ward">Phường</label>
                            <select id="ward" name="ward" class="form-control form-control-sm @error('ward') is-invalid @enderror">
                                @foreach($wards as $ward)
                                   <option value="{{ $ward->id }}" {{ old('ward') == $ward->id ? 'selected' : '' }}>{{ $ward->name }}</option>
                                @endforeach
                            </select>
                            @error('ward')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nhập họ và tên <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control form-control-sm @error('name') is-invalid @enderror" placeholder="Nhập họ và tên" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="dob">Ngày sinh <span class="text-danger">*</span></label>
                            <input type="date" id="dob" name="dob" class="form-control form-control-sm @error('dob') is-invalid @enderror" value="{{ old('dob') }}">
                            @error('dob')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="village">Đường/số nhà</label>
                            <input type="text" id="village" name="village" class="form-control form-control-sm @error('village') is-invalid @enderror" placeholder="Nhập đường/số nhà" value="{{ old('village') }}">
                            @error('village')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label for="captcha">Nhập captcha <span class="text-danger">*</span></label>
                        <input type="text" id="captcha" name="captcha" class="form-control form-control-sm @error('captcha') is-invalid @enderror" placeholder="Nhập captcha" value="{{ old('captcha') }}">
                        @error('captcha')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="captcha-image" class="d-none">Mã captcha</label>
                    <img src="{{ route('p17.generate.captcha') }}" alt="Captcha" id="captcha-image" class="captcha-code">
                </div>
                <div class="form-actions">
                    <button type="button" class="back-btn">
                        <i class="fa-solid fa-arrow-left back-icon"></i> Back
                    </button>
                    <button type="submit" class="submit-btn">Đăng nhập</button>
                </div>
            </form>
        </div>
    </section>
@endsection
