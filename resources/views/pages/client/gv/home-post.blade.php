@if ($financialSupports->isNotEmpty() || $bankServicers->isNotEmpty())
    @extends('pages.layouts.page')
    @section('title', 'Kết nối ngân hàng '  . $bank->name)
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
        .contact-form .btn{
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
        .info-form .btn-info{
            padding: 10px 4rem;
            background: #ec1e28;
            margin-bottom: 10px;
            color: #fff;
            border-radius: 5px;
            text-align: center;
        }
        .info-form{
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }
        .waves{display: block !important}
        </style>
    @endpush
    @push('child-scripts')
    @endpush
    @section('content-page')
    @include('pages.components.button-register', ['buttonTitle' => 'Đăng ký nhu cầu', 'buttonLink' => route('show.form')])
        <section id="home-post">
            <div class="banner">
                <img src="{{asset('images/Vayvonkinhdoanh.jpg')}}" alt="Banner Image">
            </div>
            <div class="container my-4">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">Dành cho doanh nghiệp / Hộ kinh doanh</div>
                    </div>
                </div>

                <div class="row text-center">
                    @if ($financialSupports->isNotEmpty())
                        @foreach ($financialSupports as $item)
                            <div class="col-md-3 col-6 title-f mb-3">
                                <a href="{{route('post-detail',$item->slug)}}">
                                    <div class="icon-box">
                                        <img src="{{ asset($item->avt_financial_support) }}" alt="{{ $item->name }}"
                                            class="img-fluids custom-img">
                                    </div>
                                    <div class="icon-text">{{ $item->name }}</div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="container my-4">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">Dành cho chủ doanh nghiệp / Chủ cơ sở kinh doanh</div>
                    </div>
                </div>

                <div class="row text-center">
                    @if ($bankServicers->isNotEmpty())
                        @foreach ($bankServicers as $item)
                            <div class="col-md-3 col-6 title-f mb-3">
                                <a href="{{route('post-detail',$item->slug)}}">
                                    <div class="icon-box">
                                        <img src="{{ asset($item->avt_bank_services) }}" alt="{{ $item->name }}"
                                            class="img-fluids custom-img">
                                    </div>
                                    <div class="icon-text">{{ $item->name }}</div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="contact-form">
                            <a href="" role="button" class="btn">Liên hệ</a>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="border border-custom rounded mb-3">
                            <div class="bg-business rounded-top py-2 px-3 mb-3">
                                <h5 class="mb-0 fw-bold text-dark">NCB Cộng Hòa</h5>
                            </div>
                            <div class="px-3">
                                <div class="d-flex">
                                    <p class="fw-semibold me-2 mb-0">Địa chỉ:</p>
                                    <p class="mb-0">18H Cộng Hòa, Phường 4, Quận Tân Bình, Thành phố Hồ Chí Minh</p>
                                </div>
                                <div class="d-flex">
                                    <p class="fw-semibold me-2 mb-0">Số điện thoại:</p>
                                    <p class="mb-0">(08)38125352</p>
                                </div>
                                <div class="d-flex">
                                    <p class="fw-semibold me-2 mb-0">Số Fax:</p>
                                    <p class="mb-0">(08)38125351</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection
@endif

