@extends('layouts.app')
@section('title', 'Kết nối cung cầu')
@section('description', 'Kết nối cung cầu')
@section('keyword', 'Kết nối cung cầu')
@push('styles')
    <style>
        .fs-7 {
            font-size: 0.7rem;
        }

        

        .logo-business {
            object-fit: contain;
            height: 200px;
        }

        .badge-custom {
            position: relative;
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            background: #fff;
            color: #000;
            z-index: 0;
            transition: transform 0.3s ease-in-out, background 0.3s ease-in-out;
            box-shadow: 0 0px 5px 1px rgba(0, 0, 0, 0.1);
        }

        .badge-custom.active {
            background: linear-gradient(45deg, rgba(173, 216, 230, 0.5), rgba(0, 0, 0, 0.5));
            color: #303030 !important;
            animation: hoverAnimation 0.6s infinite;
        }

        .badge-custom:hover {
            animation: hoverAnimation 0.6s infinite;
            background: linear-gradient(45deg, rgba(173, 216, 230, 0.5), rgba(0, 0, 0, 0.5));
            color: #303030 !important;
            animation: hoverAnimation 0.6s infinite;
        }

        @keyframes hoverAnimation {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        .border-custom {
            box-shadow: 0 0px 5px 1px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            border-color: rgb(236, 236, 236);
        }

        .category-hidden {
            display: none;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const showMoreButton = document.getElementById('show-more');
            const hiddenCategories = document.querySelectorAll('.category-hidden');

            showMoreButton.addEventListener('click', function() {
                hiddenCategories.forEach(category => {
                    category.style.display = 'inline-block';
                });
                showMoreButton.style.display = 'none';
            });
        });
    </script>
@endpush

@section('content')
    <section id="business" class="business mt-5rem mb-5">
        <div class="container">
            @include('pages.components.button-register', [
                'buttonTitle' => 'Đăng ký SP',
                'buttonLink' => route('connect.supply.demand'),
            ])
            @include('admin.pages.notification.success-error')
            <div class="category mt-3">
                <a href="{{ route('business.products', ['category' => '']) }}"
                    class="badge badge-custom rounded-pill p-2 me-2 mb-2 text-dark {{ request('category') == '' ? 'active' : '' }}">Tất
                    cả</a>
                @foreach ($category_product_business as $index => $category)
                    <a href="{{ route('business.products', ['category' => $category->slug]) }}"
                        class="badge badge-custom rounded-pill p-2 me-2 mb-2 text-dark {{ request('category') == $category->slug ? 'active' : '' }} {{ $index >= 8 && request('category') != $category->slug ? 'category-hidden' : '' }}">{{ $category->name }}</a>
                @endforeach
                @if ($category_product_business->count() > 8)
                    <div class="text-center mt-4">
                        <a id="show-more" class="fst-italic">Xem tất cả</a>
                    </div>
                @endif
            </div>

            <div class="mt-3">

                <div class="bg-business rounded-top py-2 px-3 mb-3">
                    <h5 class="mb-0 fw-bold text-white">Sản phẩm</h5>
                </div>

                <div class="row row-cols-2 row-cols-sm-3 g-3 px-1  mb-3">
                    @include('admin.pages.notification.success-error')
                    @foreach ($products as $product)
                        <div class="col">
                            <a href="{{ route('product.detail', $product->slug) }}"
                                class="card h-100 border-custom text-dark">
                                <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                                    <img src="{{ asset($product->product_avatar) }}"
                                        class="card-img-top img-fluid p-1 logo-business" alt="...">
                                </div>
                                <div class="px-1 d-flex flex-column">
                                    <span class="fs-7">{{ $product->business->business_name }}</span>
                                    <p class="fw-semibold mb-0 fs-7 lh-1">{{ $product->name_product }}</p>
                                    <p class="mb-0">{{ number_format($product->price, 0, ',', '.') }} ₫</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
