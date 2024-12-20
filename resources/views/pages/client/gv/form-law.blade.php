@extends('layouts.app')
@section('title', 'Đăng ký tư vấn pháp luật')
@push('styles')
    <style>
        .legal-advice-form {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            /* background-color: #f9f9f9; */
            padding: 20px;
            border-radius: 8px;
            /* box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); */
        }

        .legal-advice-form h3 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .form-group textarea {
            resize: vertical;
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

        .form-control:focus {
            color: #212529;
            background-color: #fff;
            outline: 0;
            box-shadow: unset;
            border-color: #80bdff;
            box-shadow: 0 0 5px rgba(128, 189, 255, 0.5);
        }

        @media (max-width: 768px) {
            .legal-advice-form {
                padding: 15px;
            }

            .legal-advice-form h3 {
                font-size: 20px;
            }

            .form-group input,
            .form-group textarea {
                font-size: 14px;
                padding: 8px;
            }

            .btn-submit {
                padding: 8px;
                font-size: 16px;
            }

            .banner {
                height: auto;

            }
        }
        .btn-success {
            background-color: #0056b3;
            transition: background-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #004494;
        }
        @media (max-width: 480px) {
            .legal-advice-form {
                padding: 10px;
            }

            .legal-advice-form h3 {
                font-size: 18px;
            }

            .form-group input,
            .form-group textarea {
                font-size: 12px;
                padding: 6px;
            }

            .btn-success {
                padding: 6px;
                font-size: 14px;
            }
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
        h3{
            text-transform: uppercase;
        }
        #form-law {
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
    <section id="form-law">
        {{-- <div class="banner">
            <img src="{{ asset('images/Vayvonkinhdoanh.jpg') }}" alt="Banner Image">
        </div> --}}
        <div class="container my-5">
            <div class="row">
                
                <form action="{{ route('legal.advice.store') }}" method="POST" class="legal-advice-form">
                    @csrf
                    <h3>Tư Vấn Pháp Luật</h3>

                    <div class="form-group">
                        <label for="name">Họ và tên:<span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control form-control-sm @error('name') is-invalid @enderror" placeholder="Nhập họ tên" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Số Điện Thoại:<span class="text-danger">*</span></label>
                        <input type="tel" id="phone" name="phone" class="form-control form-control-sm @error('phone') is-invalid @enderror" placeholder="Nhập số điện thoại" required>
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control form-control-sm @error('email') is-invalid @enderror" placeholder="Nhập email" >
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Địa Chỉ:<span class="text-danger">*</span></label>
                        <input type="text" id="address" name="address" class="form-control form-control-sm @error('address') is-invalid @enderror" placeholder="Nhập địa chỉ" required>
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="company_name">Tên Công Ty/Đơn Vị:<span class="text-danger">*</span></label>
                        <input type="text" id="company_name" name="company_name" class="form-control form-control-sm @error('company_name') is-invalid @enderror" placeholder="Nhập tên công ty hoặc đơn vị" required>
                        @error('company_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="advice_content">Nội Dung Cần Tư Vấn:<span class="text-danger">*</span></label>
                        <textarea id="advice_content" name="advice_content" class="form-control form-control-sm @error('advice_content') is-invalid @enderror" placeholder="Mô tả chi tiết vấn đề cần tư vấn" rows="5" required></textarea>
                        @error('advice_content')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                        @if ($errors->has('error'))
                            <div class="invalid-feedback" role="alert">{{ $errors->first('error') }}</div>
                        @endif
                    </div>

                    <div class="text-end my-3">
                        <button type="submit" class="btn btn-success">Gửi Yêu Cầu</button>
                    </div>
                </form>


            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

@endpush
