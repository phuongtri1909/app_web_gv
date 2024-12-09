@extends('pages.client.p17.layouts.app')
@section('title', 'Quảng cáo - Rao vặt')
@section('description', 'Quảng cáo - Rao vặt')
@section('keyword', 'Quảng cáo - Rao vặt')

@push('styles')
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
            gap: 8px;
            margin-bottom: 24px;
            overflow-x: auto;
            padding-bottom: 8px;
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

        .view-btn {
            width: 100%;
            padding: 12px;
            background: #0ea5e9;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            transition: background 0.2s;
        }

        .view-btn:hover {
            background: #0284c7;
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const listingsContainer = document.getElementById('listingsContainer');
            const searchInput = document.getElementById('searchInput');
            const tabs = document.querySelectorAll('.tab-btn');
            const loadingIndicator = document.getElementById('loadingIndicator');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');

                    const category = tab.dataset.category;
                    filterListings(category);
                });
            });
            let searchTimeout;
            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    const searchTerm = e.target.value.toLowerCase();
                    searchListings(searchTerm);
                }, 300);
            });
            let page = 1;
            let loading = false;

            window.addEventListener('scroll', () => {
                if (loading) return;

                if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 500) {
                    loadMoreListings();
                }
            });

            function filterListings(category) {
                const listings = document.querySelectorAll('.listing-card');
                listings.forEach(listing => {
                    if (category === 'all' || listing.dataset.category === category) {
                        listing.style.display = 'block';
                    } else {
                        listing.style.display = 'none';
                    }
                });
            }

            function searchListings(term) {
                const listings = document.querySelectorAll('.listing-card');
                listings.forEach(listing => {
                    const title = listing.querySelector('.card-title').textContent.toLowerCase();
                    const desc = listing.querySelector('.card-desc').textContent.toLowerCase();

                    if (title.includes(term) || desc.includes(term)) {
                        listing.style.display = 'block';
                    } else {
                        listing.style.display = 'none';
                    }
                });
            }

            async function loadMoreListings() {
                loading = true;
                loadingIndicator.classList.remove('hidden');

                try {
                    await new Promise(resolve => setTimeout(resolve, 1000));
                    page++;
                    loading = false;
                    loadingIndicator.classList.add('hidden');
                } catch (error) {
                    console.error('Error loading more listings:', error);
                    loading = false;
                    loadingIndicator.classList.add('hidden');
                }
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
                    <select class="filter-select">
                        <option value="">Giá</option>
                        <option value="0-1000000">Dưới 1 triệu</option>
                        <option value="1000000-5000000">1-5 triệu</option>
                        <option value="5000000+">Trên 5 triệu</option>
                    </select>
                    <select class="filter-select">
                        <option value="">Khu vực</option>
                        <option value="cau-giay">Cầu Giấy</option>
                        <option value="hoan-kiem">Hoàn Kiếm</option>
                    </select>
                </div>
            </div>

           
            <div class="category-tabs">
                <button class="tab-btn active" data-category="all">Tất cả</button>
                <button class="tab-btn" data-category="services">Dịch vụ</button>
                <button class="tab-btn" data-category="house-rentals">Nhà cho thuê</button>
            </div>

            
            <div class="listings-grid" id="listingsContainer">
                @foreach (range(1, 6) as $i)
                    <div class="listing-card" data-category="{{ $i % 2 == 0 ? 'services' : 'house-rentals' }}">
                        <div class="card-image">
                            <img src="https://picsum.photos/400/300?random={{ $i }}"
                                alt="Listing {{ $i }}" loading="lazy">
                            <span class="card-badge">{{ $i % 2 == 0 ? 'Dịch vụ' : 'Nhà cho thuê' }}</span>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">Listing Title {{ $i }}</h3>
                            <div class="card-price">{{ number_format(rand(1000000, 10000000)) }}đ</div>
                            <p class="card-desc">Mô tả ngắn gọn về listing này...</p>
                            <div class="card-meta">
                                <span class="location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $i % 2 == 0 ? 'Cầu Giấy' : 'Hoàn Kiếm' }}
                                </span>
                                <span class="date">{{ now()->subDays(rand(1, 10))->format('d/m/Y') }}</span>
                            </div>
                            <button class="view-btn">Xem chi tiết</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="loadingIndicator" class="loading-indicator hidden">
                <div class="spinner"></div>
                <span>Đang tải...</span>
            </div>
        </div>
    </section>
@endsection
