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

        p {
            margin-bottom: 0;
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
    @include('pages.components.button-register', [
        'buttonTitle' => 'Kết nối cung cầu',
        'buttonLink' => route('connect.supply.demand'),
    ])
    <section id="detail-product-business" class="detail-product-business mt-5rem">
        <div class="container">
            <div>
                <div class="swiper mySwiper2" style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="{{ asset($product->product_avatar) }}" />
                        </div>
                        @foreach ($product->productImages as $image)
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
                        <div class="swiper-slide">
                            <img src="{{ asset($product->product_avatar) }}" />
                        </div>
                        @foreach ($product->productImages as $image)
                            <div class="swiper-slide">
                                <img src="{{ asset($image->image) }}" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div>
                @if ($product->businessMember->link)
                    <a href="{{ $product->businessMember->link }}" class="text-decoration-none text-dark" target="_blank">
                        <p class="text-uppercase">{{ $product->businessMember->business_name }}<i class="fa-solid fa-up-right-from-square ms-2"></i></p>
                    </a>
                @else
                    <p class="text-uppercase">{{ $product->businessMember->business_name }}</p>
                    
                @endif
                
                <p class="fw-semibold">{{ $product->name_product }}</p>

                <div class="d-flex justify-content-between">
                    <div>
                        <p class="fw-semibold text-danger">Giá: {{ number_format($product->price, 0, ',', '.') }} ₫ - Giá
                            thành viên: {{ number_format($product->price_member, 0, ',', '.') }} ₫</p>
                    </div>
                </div>

                <div class="border border-custom rounded mb-3 mt-3">
                    <div class="bg-business rounded-top py-2 px-3 mb-3">
                        <h5 class="mb-0 fw-bold text-dark">Giới thiệu sản phẩm</h5>
                    </div>



                    <div class="px-3">

                        <div class="d-flex">
                            <p class="fw-semibold me-2">Danh mục:</p>
                            <p>{{ $product->categoryProduct->name }}</p>
                        </div>

                        @if ($product->related_confirmation_document)
                            <p class="fw-semibold me-2">Giấy tờ xác nhận liên quan:</p>
                            @php
                                $relatedDocuments = json_decode($product->related_confirmation_document, true);
                            @endphp
                            <div class="row g-2">
                                @if (!empty($relatedDocuments))
                                    @foreach ($relatedDocuments as $item)
                                    <div class="col-4 col-sm-3 col-md-2 ">
                                        <a href="{{ asset($item) }}" target="_blank" class=" btn btn-outline-warning">Xem giấy tờ</a>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        @endif

                        @if ($product->description)
                            <p class="fw-semibold me-2">Mô tả:</p>
                            <p class="mb-0">{!! $product->description !!}</p>
                        @else
                            <p class="mb-0">Chưa có thông tin</p>
                        @endif
                    </div>
                </div>

                <div class="border border-custom rounded mb-3">
                    <div class="bg-business rounded-top py-2 px-3 mb-3">
                        <h5 class="mb-0 fw-bold text-dark">Thông tin doanh nghiệp</h5>
                    </div>
                    <div class="px-3">
                        <div class="d-flex">
                            <p>{{ $product->businessMember->business_name }}</p>
                        </div>

                        <div class="d-flex">
                            <p class="fw-semibold me-2">Mã số thuế:</p>
                            <p>{{ $product->businessMember->business_code }}</p>
                        </div>

                        <div class="d-flex">
                            <p class="fw-semibold me-2">Địa chỉ:</p>
                            <p>{{ $product->businessMember->address }}</p>
                        </div>
                        <div class="d-flex">
                            <p class="fw-semibold me-2">SĐT liên hệ:</p>
                            <p>{{ $product->businessMember->phone_zalo }}</p>
                        </div>

                        @if ($product->businessMember->email)
                            <div class="d-flex">
                                <p class="fw-semibold me-2">Email:</p>
                                <p>{{ $product->businessMember->email }}</p>
                            </div>
                        @endif

                        @if ($product->business_field_id)
                            <div class="d-flex">
                                <p class="fw-semibold me-2">Ngành nghề kinh doanh:</p>
                                <p>{{ implode(', ',  $product->business_field_id ) }}</p>
                            </div>
                        @endif

                    </div>
                </div>

                <div class="border border-custom rounded mb-3">
                    <div class="bg-business rounded-top py-2 px-3 mb-3">
                        <h5 class="mb-0 fw-bold text-dark">Thông tin Người đại diện</h5>
                    </div>
                    <div class="px-3">
                        <div class="d-flex">
                            <p class="fw-semibold me-2">Họ và tên:</p>
                            <p>{{ Str::title(Str::lower($product->businessMember->representative_full_name)) }}</p>
                        </div>

                        <div class="d-flex">
                            <p class="fw-semibold me-2">SĐT:</p>
                            <p>{{ $product->businessMember->representative_phone }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
