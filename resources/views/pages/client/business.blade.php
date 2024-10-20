@extends('pages.layouts.page')
@push('styles')
    <style>
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
            @include('admin.pages.notification.success-error')
            <h2 class="fw-bold">{{ $businesses->count() }} Doanh nghiệp</h2>
            <div class="category mt-3">
                <a href="{{ route('business', ['category' => '']) }}"
                    class="badge badge-custom rounded-pill p-2 me-2 mb-2 text-dark {{ request('category') == 'tat-ca' ? 'active' : '' }}">Tất cả</a>
                @foreach ($category_product_business as $index => $category)
                    <a href="{{ route('business', ['category' => $category->slug]) }}"
                        class="badge badge-custom rounded-pill p-2 me-2 mb-2 text-dark {{ request('category') == $category->slug ? 'active' : '' }} {{ $index >= 8 && request('category') != $category->slug ? 'category-hidden' : '' }}">{{ $category->name }}</a>
                @endforeach
                @if ($category_product_business->count() > 8)
                    <div class="text-center mt-4">
                        <a id="show-more" class="fst-italic">Xem tất cả</a>
                    </div>
                @endif
            </div>

            <div class="list-business mt-5">
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-5 g-1 g-md-3">
                    @foreach ($businesses as $item)
                        <div class="col">
                            <a href="{{ route('business.detail', $item->business_code) }}" class="card h-100 border-custom">
                                <img src="{{ asset($item->avt_businesses) }}"
                                    class="card-img-top img-fluid p-1 logo-business" alt="...">
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title text-uppercase text-dark">{{ $item->business_name }}</h6>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection