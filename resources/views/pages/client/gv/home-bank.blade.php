@extends('pages.layouts.page')
@section('title', 'Kết nối ngân hàng')
@push('child-styles')
    <style>
        .icon-box {
            width: 100px;
            height: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
        }

        .icon-text {
            margin-top: 10px;
            text-align: center;
        }

        .section-title {
            text-align: left;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .title-f a {
            color: black;
            font-size: 17px;
        }

        .custom-img {
            width: 100px;
            height: 100px;
        }

        @media (max-width: 576px) {

            .custom-img {
                width: 70px;
                height: 70px;
            }

            .title-f a {
                font-size: 15px;
            }

            .icon-text {
                margin-top: 0px;
                text-align: center;
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

        @media (max-width: 768px) {
            .banner {
                height: auto;

            }

            .contact-form .btn,
            .info-form .btn-info {
                padding: 10px 2rem;
                width: 100%;
            }

            .info-form {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media screen and (max-width: 480px) {

            .contact-form .btn,
            .info-form .btn-info {
                padding: 10px 1.5rem !important;
            }
        }

        .contact-form .btn {
            padding: 10px 4rem;
            background: #0056b3;
            margin-bottom: 10px;
            color: #fff;
        }

        .btn:hover {
            background-color: #4584e8;
            opacity: 0.8;
            box-shadow: 0px 4px 15px rgba(69, 132, 232, 0.4);
        }

        .info-form .btn-info {
            padding: 10px 4rem;
            background: #ec1e28;
            margin-bottom: 10px;
            color: #fff;
            border-radius: 5px;
            text-align: center;
        }

        .info-form {
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }
    </style>
@endpush
@push('child-scripts')
@endpush
@section('content-page')
    @include('pages.components.button-register', ['buttonTitle' => 'KN Ngân hàng', 'buttonLink' => route('show.form')])
    <section id="home-post">
        <div class="banner">
            <img src="{{ asset('images/Vayvonkinhdoanh.jpg') }}" alt="Banner Image">
        </div>
        <div class="container my-4">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">Ngân hàng</div>
                </div>
            </div>
            <div class="row text-center">
                @foreach ($banks as $item)
                <div class="col-md-3 col-6 title-f mb-3">
                    <a href="{{ route('show.financical', $item->slug) }}">
                        <div class="icon-box">
                            <img src="{{asset($item->avt_bank)}}" alt="{{$item->name}}" class="img-fluids custom-img">
                        </div>
                        <div class="icon-text">{{$item->name}}</div>
                    </a>
                </div>
                @endforeach
            </div>

           
            <h6 class="fw-bolder">Hội Doanh Nghiệp Quận Gò Vấp sẽ liên tục cập nhật thông tin chính sách của các ngân hàng tới Quý Hội Viên</h6>
            
        </div>
    </section>
@endsection
