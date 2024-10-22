@extends('layouts.app')
@section('title', 'Chi tiết sản phẩm')
@push('styles')
    <style>
        .swiper {
            width: 100%;
            height: 200px;
            margin-left: auto;
            margin-right: auto;
            z-index: 0;
        }

        .swiper-slide {
            background-size: cover;
            background-position: center;
        }

        .mySwiper2 {
            height: 300px;
            width: 100%;
        }

        @media (min-width: 768px) {
            .mySwiper2 {
                height: 500px;
                width: 700px;
            }

            .mySwiper {
                width: 50% !important;
            }
        }

        .mySwiper {
            height: 115px;
            width: 100%;
            box-sizing: border-box;
            padding: 10px 0;
        }

        .mySwiper .swiper-slide {
            width: 25%;
            height: 100%;
            opacity: 0.4;
        }

        .mySwiper .swiper-slide-thumb-active {
            opacity: 1;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: scale-down;
        }

        .swiper-pagination {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            color: #fff;
            font-size: 16px;
            z-index: 10;
        }
    </style>
@endpush

@push('scripts')
    <script>
        var swiper = new Swiper(".mySwiper", {
            loop: true,
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
        });
        var swiper2 = new Swiper(".mySwiper2", {
            loop: true,
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: swiper,
            },
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            on: {
                slideChange: function() {
                    var currentSlide = this.realIndex + 1;
                    var totalSlides = this.slides.length;
                    document.getElementById('swiper-pagination').innerText = currentSlide + ' / ' + totalSlides;
                },
            },
        });
    </script>
@endpush

@section('content')
    <section id="detail-product-business" class="detail-product-business mt-5rem">
        <div class="container">
            <div>
                <div class="swiper mySwiper2" style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff">
                    <div class="swiper-wrapper">
                        @foreach($product->productImages as $image)
                            <div class="swiper-slide">
                                <img src="{{ asset($image->image) }}" />
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div id="swiper-pagination" class="swiper-pagination">1 / 10</div>
                </div>
                <div class="swiper mySwiper" thumbsSlider="">
                    <div class="swiper-wrapper">
                        @foreach($product->productImages as $image)
                            <div class="swiper-slide">
                                <img src="{{ asset($image->image) }}" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div>
                <p class="text-uppercase">{{ $product->business->business_name }}</p>
                <p class="fw-semibold">{{ $product->name_product }}</p>

                <div class="d-flex justify-content-between">
                    <div>
                        <p class="fw-semibold text-danger">Giá: {{ number_format($product->price, 0, ',', '.') }} ₫</p>
                    </div>
                </div>

                <div class="border border-custom rounded mb-3">
                    <div class="bg-business rounded-top py-2 px-3 mb-3">
                        <h5 class="mb-0 fw-bold text-dark">Thông tin Người đại diện</h5>
                    </div>
                    <div class="d-flex px-3">
                        <p class="fw-semibold me-2">Họ và tên:</p>
                        <p>{{ Str::title(Str::lower($product->business->representative_name)) }}</p>
                    </div>
                </div>

                <div class="border border-custom rounded mb-3">
                    <div class="bg-business rounded-top py-2 px-3 mb-3">
                        <h5 class="mb-0 fw-bold text-dark">Thông tin doanh nghiệp</h5>
                    </div>
                    <div class="px-3">
                        <div class="d-flex">
                            <p class="fw-semibold me-2">Số điện thoại:</p>
                            <p>{{ $product->business->phone_number }}</p>
                        </div>
                        <div class="d-flex">
                            <p class="fw-semibold me-2">Email:</p>
                            <p>{{ $product->business->email }}</p>
                        </div>
                        @if ($product->business->fax_number)
                            <div class="d-flex">
                                <p class="fw-semibold me-2">Fax:</p>
                                <p>{{ $product->business->fax_number }}</p>
                            </div>
                        @endif
                        @if ($product->business->business_license)
                            <div class="d-flex">
                                <p class="fw-semibold me-2">Giấy phép:</p>
                                <a href="{{ asset($product->business->business_license) }}" target="_blank"
                                    rel="noopener noreferrer">
                                    Xem giấy phép
                                </a>
                            </div>
                        @endif
                        @if ($product->business->social_channel)
                            <div class="d-flex">
                                <p>{{ $product->business->social_channel }}</p>
                            </div>
                        @endif

                    </div>
                </div>

                <div class="border border-custom rounded mb-3">
                    <div class="bg-business rounded-top py-2 px-3 mb-3">
                        <h5 class="mb-0 fw-bold text-dark">Giới thiệu sản phẩm</h5>
                    </div>
                    <div class="px-3">
                        @if ($product->business->description)
                            <p class="mb-0">{!! $product->business->description !!}</p>
                        @else
                            <p class="mb-0">Chưa có thông tin</p>
                        @endif
                    </div>
                </div>

                @if($product->product_story)
                    <div class="border border-custom rounded mb-3">
                        <div class="bg-business rounded-top py-2 px-3 mb-3">
                            <h5 class="mb-0 fw-bold text-dark">Câu chuyện sản phẩm</h5>
                        </div>
                        <div class="px-3">
                            <p class="mb-0">{!! $product->product_story !!}</p>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </section>
@endsection
