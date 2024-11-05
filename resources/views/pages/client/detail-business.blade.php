@extends('layouts.app')
@section('title', 'Chi tiết doanh nghiệp')
@section('description', 'Chi tiết doanh nghiệp')
@section('keyword', 'Chi tiết doanh nghiệp')
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
    @include('pages.components.button-register', ['buttonTitle' => 'Đăng ký DN', 'buttonLink' => route('business.index')])
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
                        <p class="ms-2">{{ $business->business_address }}</p>
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
                                <p>{{ $business->business_name }}</p>
                            </div>
                            <div class="d-flex">
                                <p class="fw-semibold me-2">Địa chỉ:</p>
                                <p>{{ $business->business_address }}</p>
                            </div>
                            <div class="d-flex">
                                <p class="fw-semibold me-2">SĐT liên hệ:</p>
                                <p>{{ $business->phone_number }}</p>
                            </div>
                            {{-- <div class="d-flex">
                                <p class="fw-semibold me-2">Email:</p>
                                <p>{{ $business->email }}</p>
                            </div> --}}
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
                                    <a href="{{ $business->social_channel }}" target="_blank">{{ $business->social_channel }}</a>
                                    {{-- <p>{{ $business->social_channel }}</p> --}}
                                </div>
                            @endif

                        </div>
                    </div>

                    <div class="border border-custom rounded mb-3">
                        <div class="bg-business rounded-top py-2 px-3 mb-3">
                            <h5 class="mb-0 fw-bold text-white">Thông tin Người đại diện</h5>
                        </div>
                        <div class="px-3">
                            <div class="d-flex">
                                <p class="fw-semibold me-2">Họ và tên:</p>
                                <p>{{ Str::title(Str::lower($business->representative_name)) }}</p>
                            </div>
                            <div class="d-flex">
                                <p class="fw-semibold me-2">Chức vụ:</p>
                                <p>Giám đốc chi nhánh</p>
                            </div>
                            <div class="d-flex">
                                <p class="fw-semibold me-2">Email:</p>
                                <p>chautm2@ncb-bank.vn</p>
                            </div>
                            <div class="d-flex">
                                <p class="fw-semibold me-2">Năm sinh:</p>
                                <p>{{ $business->birth_year }}</p>
                            </div>

                            <div class="d-flex">
                                <p class="fw-semibold me-2">Giới tính:</p>
                                <p>
                                    @switch($business->gender)
                                        @case('male')
                                            Nam
                                        @break
                                        @case('female')
                                            Nữ
                                        @break
                                        @default
                                            Khác
                                    @endswitch
                                </p>
                            </div>
                            <div class="d-flex">
                                <p class="fw-semibold me-2">SĐT:</p>
                                <p>
                                    0987.338339-0786.338339
                                </p>
                            </div>

                            {{-- <div class="d-flex">
                                <p class="fw-semibold me-2">Địa chỉ:</p>
                                <p>
                                    {{ $business->address }}
                                </p>
                            </div> --}}

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


                </div>
            </div>
        </div>
    </section>
@endsection
