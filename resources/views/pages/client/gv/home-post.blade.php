@extends('pages.layouts.page')
@push('styles')
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

    </style>
@endpush
@push('scripts')
@endpush
@section('content')
    <section id="home-post">
        <div class="banner">
            <img src="{{asset('images/Vayvonkinhdoanh.jpg')}}" alt="Banner Image">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">Dành cho doanh nghiệp / Hộ kinh doanh</div>
                </div>
            </div>

            <div class="row text-center">
                @foreach ($financialSupports as $item)
                    <div class="col-md-3 col-6 title-f mb-3">
                        <a href="#">
                            <div class="icon-box">
                                <img src="{{ asset($item->avt_financial_support) }}" alt="Mở tài khoản"
                                    class="img-fluids custom-img">
                            </div>
                            <div class="icon-text">{{ $item->name }}</div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
