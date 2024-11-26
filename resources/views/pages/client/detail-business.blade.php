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
                    <h2 class="responsive-h2">{{ $business->businessMember->business_name }}</h2>
                    <div class="d-flex align-items-baseline business-location">
                        <i class="fa-solid fa-location-dot"></i>
                        <p class="ms-2">{{ $business->businessMember->address }}</p>
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
                                <p>{{ $business->businessMember->business_name }}</p>
                            </div>

                            <div class="d-flex">
                                <p class="fw-semibold me-2">Mã số thuế:</p>
                                <p>{{ $business->businessMember->business_code }}</p>
                            </div>

                            <div class="d-flex">
                                <p class="fw-semibold me-2">Địa chỉ:</p>
                                <p>{{ $business->businessMember->address }}</p>
                            </div>
                            <div class="d-flex">
                                <p class="fw-semibold me-2">SĐT liên hệ:</p>
                                <p>{{ $business->businessMember->phone_zalo }}</p>
                            </div>

                            @if ($business->businessMember->email) 
                                <div class="d-flex">
                                    <p class="fw-semibold me-2">Email:</p>
                                    <p>{{ $business->businessMember->email }}</p>
                                </div>
                            @endif

                            @if ($business->businessMember->businessField)
                                <div class="d-flex">
                                    <p class="fw-semibold me-2">Ngành nghề kinh doanh:</p>
                                    <p>{{ $business->businessMember->businessField->name }}</p>
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
                                <p>{{ Str::title(Str::lower($business->businessMember->representative_name)) }}</p>
                            </div>
                        
                            <div class="d-flex">
                                <p class="fw-semibold me-2">SĐT:</p>
                                <p>{{ $business->businessMember->representative_phone }}</p>
                            </div>
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
