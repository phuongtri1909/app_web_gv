@extends('pages.layouts.page')
@section('title', 'Doanh nghiệp')
@section('description')
    {{-- @section('keyword', implode(', ', $financialSupports->tags->pluck('name')->toArray())) --}}
@section('bg-page', asset('images/Vayvonkinhdoanh.jpg'))
@section('title-page', __(''))

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
    </style>
@endpush
@section('content-page')
    <section id="home-post">
        <div class="container mt-5">
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
@push('child-scripts')
@endpush
