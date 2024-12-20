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

            let nextPageUrl = "{{ $products->nextPageUrl() }}";
            const loadMoreButton = document.getElementById('load-more');

            loadMoreButton.addEventListener('click', function() {
                if (nextPageUrl) {
                    fetch(nextPageUrl, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        nextPageUrl = data.next_page_url;
                        const productContainer = document.querySelector('.row.row-cols-2.row-cols-sm-3.g-3.px-1.mb-3');
                        data.products.forEach(product => {
                            const productHtml = `
                                <div class="col">
                                    <a href="/product/${product.slug}" class="card h-100 border-custom text-dark p-md-2">
                                        <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                                            <img src="/${product.product_avatar}" class="card-img-top img-fluid p-1 logo-business" alt="...">
                                        </div>
                                        <div class="px-1 d-flex flex-column">
                                            <span class="fs-7">${product.business_member.business_name}</span>
                                            <p class="fw-semibold mb-0 fs-7 lh-1">${product.name_product}</p>
                                            <p class="mb-0">${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product.price)}</p>
                                        </div>
                                    </a>
                                </div>
                            `;
                            productContainer.insertAdjacentHTML('beforeend', productHtml);
                        });

                        if (!nextPageUrl) {
                            loadMoreButton.style.display = 'none';
                        }
                    })
                    .catch(error => console.error('Error loading more products:', error));
                }
            });
        });
    </script>
@endpush

@section('content')
    <section id="business" class="business mt-5rem mb-5">
        <div class="container">
            @include('pages.components.button-register', [
                'buttonTitle' => 'Kết nối cung cầu',
                'buttonLink' => route('connect.supply.demand'),
            ])
            
            <div class="category mt-3">
                <a href="{{ route('business.products') }}"
                    class="badge badge-custom rounded-pill p-2 me-2 mb-2 text-dark {{ request('category') == '' ? 'active' : '' }}">Tất
                    cả</a>
                @foreach ($category_product_business as $index => $category)
                    <a href="{{ route('business.products', ['category' => $category->slug]) }}"
                        class="badge badge-custom rounded-pill p-2 me-2 mb-2 text-dark {{ request('category') == $category->slug ? 'active' : '' }} {{ $index >= 8 && request('category') != $category->slug ? 'category-hidden' : '' }}">{{ $category->name }}</a>
                @endforeach
                @if ($category_product_business->count() > 8)
                    <div class="text-center">
                        <a id="show-more" class="fst-italic text-app-gv">Xem tất cả</a>
                    </div>
                @endif
            </div>

            <div class="mt-3">
                <div class="bg-business rounded-top py-2 px-3 mb-3">
                    <h5 class="mb-0 fw-bold text-dark">Sản phẩm</h5>
                </div>

                @if ($products->isEmpty())
                    <div class="col-12 text-center">
                        <p class="text-muted fw-bold text-app-gv">Không có dữ liệu</p>
                    </div>
                @else
                    <div class="row row-cols-2 row-cols-sm-3 g-3 px-1 mb-3">
                        @foreach ($products as $product)
                            <div class="col">
                                <a href="{{ route('product.detail', $product->slug) }}"
                                    class="card h-100 border-custom text-dark p-md-2">
                                    <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                                        <img src="{{ asset($product->product_avatar) }}"
                                            class="card-img-top img-fluid p-1 logo-business" alt="...">
                                    </div>
                                    <div class="px-1 d-flex flex-column">
                                        <span class="fs-7">{{ $product->businessMember->business_name }}</span>
                                        <p class="fw-semibold mb-0 fs-7 lh-1">{{ $product->name_product }}</p>
                                        <p class="mb-0">{{ number_format($product->price, 0, ',', '.') }} ₫</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center">
                        <button id="load-more" class="btn bg-app-gv rounded-pill text-white">Xem thêm</button>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection