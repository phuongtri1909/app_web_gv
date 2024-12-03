@extends('layouts.app')
@section('title', 'Kết nối giao thương')
@section('description', 'Kết nối giao thương')
@section('keyword', 'Kết nối giao thương')
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
        document.addEventListener('DOMContentLoaded', function () {
            const showMoreButton = document.getElementById('show-more');
            if (showMoreButton) {
                showMoreButton.addEventListener('click', function () {
                    document.querySelectorAll('.category-hidden').forEach(category => {
                        category.classList.remove('category-hidden');
                        category.style.display = 'inline-block';
                    });
                    showMoreButton.style.display = 'none';
                });
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#load-more').click(function() {
                var button = $(this);
                var nextPageUrl = button.data('next-page-url');

                if (nextPageUrl) {
                    $.ajax({
                        url: nextPageUrl,
                        type: 'GET',
                        beforeSend: function() {
                            button.prop('disabled', true).text('Loading...');
                        },
                        success: function(response) {
                            if (response.businesses.length > 0) {
                                response.businesses.forEach(function(item) {
                                    var businessHtml = `
                                        <div class="col">
                                            <a href="{{ url('/client/business') }}/${item.business_member.business_code}" class="card h-100 border-custom">
                                                <img src="{{ asset('') }}${item.avt_businesses}" class="card-img-top img-fluid p-1 logo-business" alt="...">
                                                <div class="card-body d-flex flex-column">
                                                    <h6 class="card-title text-uppercase text-dark">${item.business_member.business_name}</h6>
                                                </div>
                                            </a>
                                        </div>
                                    `;
                                    $('#business-list').append(businessHtml);
                                });

                                button.data('next-page-url', response.next_page_url);
                                button.prop('disabled', false).text('Load More');
                            } else {
                                button.prop('disabled', true).text('No More Businesses');
                            }
                        },
                        error: function() {
                            button.prop('disabled', false).text('Load More');
                        }
                    });
                }
            });
        });
    </script>
@endpush

@section('content')
    <section id="business" class="business mt-5rem mb-5">
        <div class="container">
            @include('pages.components.button-register', [
                'buttonTitle' => 'Đăng ký kết nối giao thương',
                'buttonLink' => route('business.index'),
            ])
            
            <div class="category mt-3">
                <a href="{{ route('business', ['business_field' => '']) }}"
                    class="badge badge-custom rounded-pill p-2 me-2 mb-2 text-dark {{ request('business_field') == '' ? 'active' : '' }}">
                    Tất cả
                </a>
                @foreach ($business_fields as $index => $category)
                    <a href="{{ route('business', ['business_field' => $category->slug]) }}"
                        class="badge badge-custom rounded-pill p-2 me-2 mb-2 text-dark {{ request('business_field') == $category->slug ? 'active' : '' }} {{ $index >= 8 ? 'category-hidden' : '' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
                @if ($business_fields->count() > 8)
                    <div class="text-center mt-4">
                        <a id="show-more" class="fst-italic text-app-gv">Xem tất cả</a>
                    </div>
                @endif
            </div>

            <div class="list-business mt-5">
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-5 g-2 g-md-3"
                    id="business-list">
                    @forelse ($businesses as $item)
                        <div class="col">
                            <a href="{{ route('business.detail', $item->businessMember->business_code) }}"
                                class="card h-100 border-custom">
                                <img src="{{ asset($item->avt_businesses) }}"
                                    class="card-img-top img-fluid p-1 logo-business" alt="...">
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title text-uppercase text-dark">
                                        {{ $item->businessMember->business_name }}</h6>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p>Không có doanh nghiệp nào phù hợp.</p>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="text-center mt-4">
                @if ($businesses->count() > 0 && $businesses->hasMorePages())
                    <button id="load-more" class="btn bg-app-gv rounded-pill text-white"
                        data-next-page-url="{{ $businesses->nextPageUrl() }}">Xem thêm</button>
                @endif
            </div>
        </div>
    </section>
@endsection
