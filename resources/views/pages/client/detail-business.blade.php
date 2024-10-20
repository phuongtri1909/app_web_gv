@extends('pages.layouts.page')
@push('styles')
    <style>
        .bg-business {
            background: linear-gradient(269.85deg, #30b3d4 0%, #121212 54.89%);
        }

        .logo-business {
            width: 120px;
            height: 120px;
            object-fit: scale-down;
        }

        .business-location {
            justify-content: center
        }


        @media (min-width: 768px) {
            .logo-business {
                width: 160px;
                height: 160px
            }

            .business-location {
                justify-content: start
            }
        }

        p {
            margin-bottom: 0;
        }

        .border-custom {
            box-shadow: 0 0px 5px 1px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            border-color: rgb(236, 236, 236);
        }
    </style>
@endpush

@push('scripts')
    <script></script>
@endpush

@section('content')
    <section id="business" class="business mt-5rem mb-5">
        <div class="bg-business ">
            <div class="container py-4 d-md-flex text-center">
                <div class="rounded ">
                    <img class="bg-white rounded logo-business" src="{{ asset($business->avt_businesses) }}" alt="">
                </div>
                <div class="ms-3 text-white mt-3 md-md-0">
                    <h2 class="responsive-h2">{{ $business->business_name }}</h2>
                    <div class="d-flex align-items-baseline business-location">
                        <i class="fa-solid fa-location-dot"></i>
                        <p class="ms-2">{{ $business->address }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="mt-4 row">
                <div class="col-12 col-md-4">
                    <div class="border border-custom rounded mb-3">
                        <div class="bg-business rounded-top py-2 px-3 mb-3">
                            <h5 class="mb-0 fw-bold text-white">Thông tin doanh nghiệp</h5>
                        </div>
                        <div class="px-3">
                            <div class="d-flex">
                                <p class="fw-semibold me-2">Số điện thoại:</p>
                                <p>{{ $business->phone_number }}</p>
                            </div>
                            <div class="d-flex">
                                <p class="fw-semibold me-2">Email:</p>
                                <p>{{ $business->email }}</p>
                            </div>
                            @if ($business->fax_number)
                                <div class="d-flex">
                                    <p class="fw-semibold me-2">Fax:</p>
                                    <p>{{ $business->fax_number }}</p>
                                </div>
                            @endif
                            @if ($business->business_license)
                                <div class="d-flex">
                                    <p class="fw-semibold me-2">Giấy phép:</p>
                                    <a href="{{ asset($business->business_license) }}" target="_blank"
                                        rel="noopener noreferrer">
                                        Xem giấy phép
                                    </a>
                                </div>
                            @endif
                            @if ($business->social_channel)
                                <div class="d-flex">
                                    <p>{{ $business->social_channel }}</p>
                                </div>
                            @endif

                        </div>
                    </div>

                    <div class="border border-custom rounded mb-3">
                        <div class="bg-business rounded-top py-2 px-3 mb-3">
                            <h5 class="mb-0 fw-bold text-white">Thông tin Người đại diện</h5>
                        </div>
                        <div class="d-flex px-3">
                            <p class="fw-semibold me-2">Họ và tên:</p>
                            <p>{{ Str::title(Str::lower($business->representative_name)) }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-8">
                    <div class="border border-custom rounded">

                        <div class="bg-business rounded-top py-2 px-3 mb-3">
                            <h5 class="mb-0 fw-bold text-white">Giới thiệu doanh nghiệp</h5>
                        </div>
                        @if ($business->description)
                            <p class="px-3">{!! $business->description !!}</p>
                        @else
                            <p class="px-3">Chưa có thông tin</p>
                        @endif


                    </div>

                    <div class="border border-custom rounded mt-3">

                        <div class="bg-business rounded-top py-2 px-3 mb-3">
                            <h5 class="mb-0 fw-bold text-white">Sản phẩm</h5>
                        </div>

                        <div class="row row-cols-2 row-cols-sm-3 g-3 px-1">
                            @include('admin.pages.notification.success-error')
                            @foreach ($business->products as $product)
                                <div class="col">
                                    <a href="{{ route('product.detail', $product->slug) }}"
                                        class="card h-100 border-custom text-dark">
                                        <div class="d-flex justify-content-center align-items-center"
                                            style="height: 200px;">
                                            <img src="{{ asset($product->product_avatar) }}"
                                                class="card-img-top img-fluid p-1 logo-business" alt="...">
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <span>{{ $business->business_name }}</span>
                                            <p class="fw-semibold mb-0">{{ $product->name_product }}</p>
                                            <p class="mb-0">{{ number_format($product->price, 0, ',', '.') }} ₫</p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
