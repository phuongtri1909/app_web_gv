@extends('pages.client.p17.layouts.app')
@section('title', 'Quảng cáo - Rao vặt')
@section('description', 'Quảng cáo - Rao vặt')
@section('keyword', 'Quảng cáo - Rao vặt')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <style>
        .classified-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 16px;
        }

        .search-filters {
            margin-bottom: 24px;
            display: grid;
            gap: 16px;
            grid-template-columns: 1fr auto;
        }

        .search-box {
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 12px 40px 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
        }

        .search-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #64748b;
        }

        .filters {
            display: flex;
            gap: 8px;
        }

        .filter-select {
            padding: 8px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            min-width: 120px;
        }
        .category-tabs {
            display: flex;
            flex-wrap: wrap; 
            gap: 10px;
            justify-content: space-between; 
            margin-bottom: 24px;
        }
        .tab-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            background: #f1f5f9;
            font-size: 14px;
            font-weight: 500;
            white-space: nowrap;
            transition: all 0.2s;
        }

        .tab-btn.active {
            background: #0ea5e9;
            color: white;
        }

        .listings-grid {
            display: grid;
            gap: 24px;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        }

        .listing-card {
            border-radius: 12px;
            overflow: hidden;
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .listing-card:hover {
            transform: translateY(-4px);
        }

        .card-image {
            position: relative;
            padding-top: 66.67%;
        }

        .card-image img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            padding: 4px 8px;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            border-radius: 4px;
            font-size: 12px;
        }

        .card-content {
            padding: 16px;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .card-price {
            color: #ef4444;
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 8px;
        }

        .card-desc {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 16px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-meta {
            display: flex;
            justify-content: space-between;
            color: #64748b;
            font-size: 12px;
            margin-bottom: 16px;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .view-adve {
            color: #000001;
            font-weight: 600;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .view-adve:hover,
        .view-adve:focus {
            color: #0056b3;
        }

        .contact-btn {
            color: #28a745;
            font-weight: 600;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .contact-btn:hover,
        .contact-btn:focus {
            color: #218838;
        }

        .btn i {
            transition: transform 0.3s ease;
        }

        .btn:hover i {
            transform: translateX(5px);
        }

        .loading-indicator {
            text-align: center;
            padding: 24px;
        }

        .hidden {
            display: none;
        }

        @media (max-width: 768px) {
            .search-filters {
                grid-template-columns: 1fr;
            }

            .filters {
                overflow-x: auto;
                padding-bottom: 8px;
            }
        }
    </style>
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const listingsContainer = document.getElementById('listingsContainer');
            const searchInput = document.getElementById('searchInput');
            const areaFilter = document.getElementById('areaFilter');
            const priceFilter = document.getElementById('priceFilter');
            const tabs = document.querySelectorAll('.tab-btn');
            let searchTimeout;
            let page = 1;
            let loading = false;
            let currentRoadId = null;
            let currentCategory = 'all';

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => {
                        t.classList.remove('active');
                        t.style.transition = 'background-color 0.3s, transform 0.3s';
                        t.style.transform = 'scale(1)';
                    });
                    tab.classList.add('active');
                    tab.style.transition = 'background-color 0.3s, transform 0.3s';
                    tab.style.transform = 'scale(1.1)';
                    currentCategory = tab.dataset.category;
                    filterListings(currentCategory);
                });
            });

            areaFilter.addEventListener('change', () => {
                currentRoadId = areaFilter.value || null;
                updateFilter('road_id', currentRoadId);
            });

            priceFilter.addEventListener('change', () => {
                if (currentRoadId) updateFilter('road_id', null);
                updateFilter('price_range', priceFilter.value);
            });

            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    const searchTerm = e.target.value.toLowerCase();
                    searchTerm.length < 2 ? filterListings(currentCategory) : searchListings(
                        searchTerm, currentCategory);
                }, 300);
            });
            function filterListings(category) {
                const listings = document.querySelectorAll('.listing-card');
                let hasResults = false;
                listings.forEach(listing => {
                    const matchesCategory = category === 'all' || listing.dataset.category === category;
                    listing.style.display = matchesCategory ? 'block' : 'none';
                    hasResults = hasResults || matchesCategory;
                });
            }

            function searchListings(term, category) {
                const listings = document.querySelectorAll('.listing-card');
                let hasResults = false;
                listings.forEach(listing => {
                    const title = listing.querySelector('.card-title').textContent.toLowerCase();
                    const desc = listing.querySelector('.card-desc').textContent.toLowerCase();
                    const matchesSearch = title.includes(term) || desc.includes(term);
                    const matchesCategory = category === 'all' || listing.dataset.category === category;
                    listing.style.display = matchesSearch && matchesCategory ? 'block' : 'none';
                    hasResults = hasResults || (matchesSearch && matchesCategory);
                });
            }

            function updateFilter(param, value) {
                const urlParams = new URLSearchParams(window.location.search);
                value ? urlParams.set(param, value) : urlParams.delete(param);
                window.location.search = urlParams.toString();
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.view-adve').click(function() {
                var adsId = $(this).data('id');
                $.ajax({
                    url: '/admin/advertisements/' + adsId,
                    type: 'GET',
                    success: function(response) {
                        var formattedDate = dayjs(response.created_at).format(
                            'DD/MM/YYYY HH:mm');
                        $('#modal-ad-title').text(response.ad_title || '-');
                        $('#modal-ad-description').html(response.ad_description || '-');
                        $('#modal-ad-price').text(response.ad_price + 'đ' || '-');
                        // $('#modal-ad-full-name').text(response.ad_full_name || '-');
                        // $('#modal-ad-cccd').text(response.ad_cccd || '-');
                        $('#modal-ad-contact-phone').text(response.ad_contact_phone || '-');
                        $('#modal-category-name').text(response.category_name || '-');
                        var productImagesHtml = '';
                        if (response.files && response.files.length > 0) {
                            response.files.forEach(function(file) {
                                productImagesHtml += '<a href="/' + file.file_url +
                                    '" data-fancybox="gallery" >';
                                productImagesHtml += '<img src="/' + file.file_url +
                                    '" alt="Product Image" class="img-fluid product-thumbnail" style="max-width: 100px; margin: 5px;">';
                                productImagesHtml += '</a>';
                            });
                        } else {
                            productImagesHtml = '-';
                        }
                        $('#modal-images').html(productImagesHtml);

                        $('#modal-type-name').text(response.type_name || '-');
                        $('#modal-created-at').text(formattedDate || '-');
                        $('#modal-road-name').text(response.road_name || '-');
                        const statusBadgeClass = {
                            'active': 'bg-success',
                            'inactive': 'bg-danger',
                            'pending': 'bg-warning'
                        } [response.ad_status] || 'bg-secondary';
                        const statusText = {
                            'active': 'Hiển thị',
                            'inactive': 'Không hiển thị',
                            'pending': 'Đang chờ'
                        } [response.ad_status] || '-';

                        $('#modal-ad-status')
                            .removeClass('bg-success bg-danger bg-warning bg-secondary')
                            .addClass(statusBadgeClass)
                            .text(statusText);


                        $('#advertisementDetailModal').modal('show');
                    },
                    error: function(error) {
                        console.log(error);

                        showToast('Có lỗi xảy ra. Vui lòng thử lại sau.', 'error');
                    }
                });
            });
            $(document).on('click', '.product-thumbnail', function() {
                var imageUrl = $(this).attr('src');
                $('#modal-large-image').attr('src', imageUrl);
                $('#viewImageModal').modal('show');
            });
            $(document).on('click', '.product-thumbnail1', function() {
                var imageUrl = $(this).attr('src');
                $('#modal-large-image').attr('src', imageUrl);
                $('#viewImageModal').modal('show');
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            let page = 1; 
            let isLoading = false;

            $(window).scroll(function() {
            
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                    if (!isLoading) {
                        loadMoreListings();
                    }
                }
            });

            function loadMoreListings() {
                isLoading = true;
                page++; 

        
                $('#loadMoreSpinner').show();

                $.ajax({
                    url: '?page=' + page, 
                    type: 'GET',
                    success: function(data) {
                        
                        $('#loadMoreSpinner').hide();

                        if (!data || data.trim() === '') {
                            
                            $('#loadMoreSpinner').text('Đã tải hết dữ liệu').fadeOut();
                            $(window).off('scroll'); 
                            return;
                        }
                        // $('#listingsContainer').append(data);
                        // isLoading = false; 
                    },
                    error: function() {
                        isLoading = false; 
                        $('#loadMoreSpinner').hide();
                        showToast('Có lỗi xảy ra khi tải dữ liệu', 'error');
                    }
                });
            }
        });
    </script>

@endpush


@section('content')
    <section id="advertising-classifieds" class="py-8">
        <div class="classified-container">
            <div class="search-filters">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Tìm kiếm..." class="search-input">
                    <button class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="filters">
                    <select class="filter-select" id="priceFilter" name="price_range">
                        <option value="">Giá</option>
                        <option value="0-1000000" {{ request()->price_range == '0-1000000' ? 'selected' : '' }}>Dưới 1 triệu
                        </option>
                        <option value="1000000-5000000" {{ request()->price_range == '1000000-5000000' ? 'selected' : '' }}>
                            1-5 triệu</option>
                        <option value="5000000+" {{ request()->price_range == '5000000+' ? 'selected' : '' }}>Trên 5 triệu
                        </option>
                    </select>
                    <select class="filter-select" id="areaFilter" name="road_id">
                        <option value="">Khu vực</option>
                        @foreach ($roads as $road)
                            <option value="{{ $road->slug }}" {{ request()->road_id == $road->slug ? 'selected' : '' }}>
                                {{ $road->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if ($categories->isNotEmpty())
                <div class="category-tabs-wrapper">
                    <div class="category-tabs">
                        <button class="tab-btn {{ request()->category == null ? 'active' : '' }}" data-category="all">
                            Tất cả
                        </button>
                        @foreach ($categories as $category)
                            <button class="tab-btn {{ request()->category == $category->slug ? 'active' : '' }}"
                                data-category="{{ $category->slug }}">
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        
            <div id="listingsContainer">
                @include('pages.client.p17.advertising-classifieds.list', ['query' => $query])
            </div>
            <div id="loadMoreSpinner" class="text-center" style="display: none;">
                Đang tải.....
            </div>
            
            <div class="modal fade" id="advertisementDetailModal" tabindex="-1"
                aria-labelledby="advertisementDetailModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="card shadow-lg">
                            <div class="card-header bg-gradient-info p-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="text-black mb-0">
                                        <i class="fas fa-ad me-2"></i>
                                        {{ __('Thông tin chi tiết') }}
                                    </h5>
                                    <button type="button" class="btn btn-link text-black" data-bs-dismiss="modal">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-12 text-center">
                                        <h6 id="modal-ad-title" class="fw-bold text-primary"></h6>
                                        {{-- <span id="modal-ad-status" class="badge badge-sm"></span> --}}
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-group">
                                            <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                <i class="fas fa-phone me-2"></i>{{ __('Số điện thoại') }}
                                            </label>
                                            <p id="modal-ad-contact-phone" class="text-sm mb-2"></p>
                                        </div>
                                        <div class="info-group">
                                            <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                <i class="fas fa-money-bill-wave me-2"></i>{{ __('Giá') }}
                                            </label>
                                            <p id="modal-ad-price" class="text-sm mb-2"></p>
                                        </div>
                                        <div class="info-group">
                                            <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                <i class="fas fa-map-marker-alt me-2"></i>{{ __('Đường') }}
                                            </label>
                                            <p id="modal-road-name" class="text-sm mb-2"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-group">
                                            <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                <i class="fas fa-tags me-2"></i>{{ __('Danh mục') }}
                                            </label>
                                            <p id="modal-category-name" class="text-sm mb-2"></p>
                                        </div>
                                        <div class="info-group">
                                            <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                <i class="fas fa-list-alt me-2"></i>{{ __('Loại hình') }}
                                            </label>
                                            <p id="modal-type-name" class="text-sm mb-2"></p>
                                        </div>
                                        <div class="info-group">
                                            <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                <i class="fas fa-clock me-2"></i>{{ __('Ngày đăng ký') }}
                                            </label>
                                            <p id="modal-created-at" class="text-sm mb-2"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">

                                    <div class="col-12">
                                        <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                            <i class="fas fa-file-alt me-2"></i>{{ __('Mô tả') }}
                                        </label>
                                        <p id="modal-ad-description" class="text-sm mb-2"></p>
                                    </div>
                                    <div class="info-group">
                                        <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                            <i class="fas fa-image me-2"></i>{{ __('Hình ảnh') }}
                                        </label>
                                        <p id="modal-images" class="text-sm mb-2"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
