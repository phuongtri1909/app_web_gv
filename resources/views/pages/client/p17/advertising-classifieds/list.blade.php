<div class="listings-grid" id="listingsContainer">
    @if ($query->isEmpty())
        <div class="no-results text-center">
            <p>Không có kết quả phù hợp.</p>
        </div>
    @else
        @foreach ($query as $advertisement)
            <div class="listing-card" data-category="{{ $advertisement->category->slug }}">
                <div class="card-image">
                    @php
                        $primaryFile = $advertisement->files->firstWhere('is_primary', 1);
                    @endphp
                    <img src="{{ $primaryFile ? asset($primaryFile->file_url) : asset('images/p17/default-image.webp') }}"
                        alt="Listing {{ $advertisement->ad_title }}" loading="lazy">
                    <span class="card-badge">{{ $advertisement->category->name }}</span>
                </div>
                <div class="card-content">
                    <h3 class="card-title">{{ $advertisement->ad_title }}</h3>
                    <div class="card-price">{{ $advertisement->ad_price }}đ</div>
                    <div class="card-desc">{!! Str::limit($advertisement->ad_description, 1000) !!}</div>
                    <div class="card-meta">
                        <span class="location">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $advertisement->road->name }}
                        </span>
                        <span class="date">{{ \Carbon\Carbon::parse($advertisement->created_at)->format('d/m/Y') }}</span>
                    </div>
                    <div class="btn-group">
                        <a href="javascript:void(0)" class="view-adve "
                        data-id="{{ $advertisement->id }}" title="{{ __('Xem chi tiết') }}">
                            Chi tiết
                        </a>
                        <a href="tel:{{ $advertisement->ad_contact_phone }}" class="contact-btn">
                            <i class="fas fa-phone-alt me-2"></i> Liên hệ
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
