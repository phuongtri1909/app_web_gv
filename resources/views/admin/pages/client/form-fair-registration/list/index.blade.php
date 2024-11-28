@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        .img-square{
            width: 200px;
            height: 100px;
            object-fit: cover;
        }
    </style>
@endpush

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ __('Danh sách tham gia hội chợ') }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">

                    @include('admin.pages.notification.success-error')

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('stt') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Tên doanh nghiệp') }}
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('Sản phẩm') }}
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('Số gian hàng') }}
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('Trạng thái') }}
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($registrations as $key => $registration)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $registration->businessMember->business_name }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $registration->products }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $registration->booth_count }}</p>
                                        </td>
                                        <td>
                                            <span id="status-badge-{{ $registration->id }}"
                                                class="badge badge-sm bg-{{ $registration->status == 'approved' ? 'success' : ($registration->status == 'rejected' ? 'danger' : 'warning') }}"  data-status="{{ $registration->status }}">
                                                {{ $registration->status == 'approved' ? 'Đã duyệt' : ($registration->status == 'rejected' ? 'Đã từ chối' : 'Đang chờ') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                           
                                            <div class="dropstart">
                                                <button class="btn btn-sm p-0 border-0 mb-0" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false"
                                                    title="Thay đổi trạng thái">
                                                    <i class="fas fa-retweet"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="updateStatus('BusinessFairRegistration', {{ $registration->id }}, 'approved')">
                                                            <i class="fas fa-check-circle text-success me-2"></i>Duyệt
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="updateStatus('BusinessFairRegistration', {{ $registration->id }}, 'rejected')">
                                                            <i class="fas fa-times-circle text-danger me-2"></i>Từ chối
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="updateStatus('BusinessFairRegistration', {{ $registration->id }}, 'pending')">
                                                            <i class="fa fa-hourglass-half text-warning me-2"></i>Đang chờ
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $registration->id,
                                                'route' => route('business-fair-registrations.destroyindexJoin', $registration->id),
                                                'message' => __('delete_message'),
                                            ])
                                            <a href="javascript:void(0)" class="mx-3 view-registration"
                                                data-id="{{ $registration->id }}" title="{{ __('Xem chi tiết') }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <x-pagination :paginator="$registrations" />
                    </div>
                </div>
            </div>
            <div class="modal fade" id="fairRegistrationDetailModal" tabindex="-1" aria-labelledby="fairRegistrationDetailModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="card shadow-lg">
                            <div class="card-header bg-gradient-primary p-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="text-white mb-0">
                                        <i class="fas fa-building me-2"></i>
                                        {{ __('Thông tin chi tiết đăng ký hội chợ') }}
                                    </h5>
                                    <button type="button" class="btn btn-link text-white" data-bs-dismiss="modal">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-4 text-center">
                                        <h6 id="modal-business-name" class="fw-bold text-primary"></h6>
                                        <span id="modal-status" class="badge badge-sm"></span>
                                    </div>
            
                                    <div class="col-md-8">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-user me-2"></i>{{ __('Người đại diện') }}
                                                    </label>
                                                    <p id="modal-representative-full-name" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-calendar me-2"></i>{{ __('Năm sinh') }}
                                                    </label>
                                                    <p id="modal-birth-year" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-venus-mars me-2"></i>{{ __('Giới tính') }}
                                                    </label>
                                                    <p id="modal-gender" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-phone me-2"></i>{{ __('Số điện thoại') }}
                                                    </label>
                                                    <p id="modal-phone-zalo" class="text-sm mb-2"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-cogs me-2"></i>{{ __('Sản phẩm') }}
                                                    </label>
                                                    <p id="modal-products" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-image me-2"></i>{{ __('Hình ảnh sản phẩm') }}
                                                    </label>
                                                    <p id="modal-product-images" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-store me-2"></i>{{ __('Số gian hàng') }}
                                                    </label>
                                                    <p id="modal-booth-count" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-percent me-2"></i>{{ __('Phần trăm giảm giá') }}
                                                    </label>
                                                    <p id="modal-discount-percentage" class="text-sm mb-2"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-hand-holding-usd me-2"></i>{{ __('Tham gia khuyến mãi') }}
                                                    </label>
                                                    <p id="modal-is-join-stage-promotion" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-heart me-2"></i>{{ __('Tham gia từ thiện') }}
                                                    </label>
                                                    <p id="modal-is-join-charity" class="text-sm mb-2"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-calendar-alt me-2"></i>{{ __('Ngày đăng ký') }}
                                                    </label>
                                                    <p id="modal-created-at" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-clock me-2"></i>{{ __('Ngày cập nhật') }}
                                                    </label>
                                                    <p id="modal-updated-at" class="text-sm mb-2"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                            <i class="fas fa-image me-2"></i>{{ __('Hình giấy phép kinh doanh') }}
                                        </label>
                                        <p id="modal-business-license" class="text-sm mb-2"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="viewImageModal" tabindex="-1" aria-labelledby="viewImageModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewImageModalLabel">Xem Hình Ảnh</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img id="modal-large-image" src="" alt="Large Image" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts-admin')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script>
    $(document).ready(function() {
        $('.view-registration').click(function() {
            var businessFairId = $(this).data('id');  
            $.ajax({
                url: '/admin/fair-registrations/join/' + businessFairId, 
                type: 'GET',
                success: function(response) {
                    var formattedDate = dayjs(response.created_at).format(
                        'DD/MM/YYYY HH:mm');
                        var formattedDate1 = dayjs(response.updated_at).format(
                        'DD/MM/YYYY HH:mm');
                    $('#modal-business-name').text(response.business_member_id || '-');
                    $('#modal-representative-full-name').text(response.representative_full_name || '-');
                    if (response.business_license) {
                        var licenseImagePath = '/' + response.business_license;  
                        var licenseImage = '<img src="' + licenseImagePath + '" alt="Business License" class="img-fluid product-thumbnail1" style="max-width: 100px; margin: 5px;">';
                        var img = new Image();
                        img.onload = function() {
                            $('#modal-business-license').html(licenseImage);
                        };
                        img.onerror = function() {
                            $('#modal-business-license').html('<p>Không thể tải hình ảnh giấy phép.</p>');
                        };
                        img.src = licenseImagePath; 
                    } else {
                        $('#modal-business-license').html('<p>Không có giấy phép kinh doanh.</p>');
                    }
                    $('#modal-birth-year').text(response.birth_year || '-');
                    $('#modal-gender').text(response.gender || '-');
                    $('#modal-phone-zalo').text(response.phone_zalo || '-');
                    $('#modal-products').text(response.products || '-');
                    var productImagesHtml = '';
                    if (response.product_images && response.product_images.length > 0) {
                        response.product_images.forEach(function(imagePath) {
                            productImagesHtml += '<img src="/' + imagePath + '" alt="Product Image" class="img-fluid product-thumbnail" style="max-width: 100px; margin: 5px;">';
                        });
                    } else {
                        productImagesHtml = '-';
                    }
                    $('#modal-product-images').html(productImagesHtml);
                    $('#modal-booth-count').text(response.booth_count || '-');
                    $('#modal-discount-percentage').text(response.discount_percentage || '0.00');
                    $('#modal-is-join-stage-promotion').text(response.is_join_stage_promotion ? 'Có' : 'Không');
                    $('#modal-is-join-charity').text(response.is_join_charity ? 'Có' : 'Không');
                    $('#modal-status').text(response.status || '-');
                    $('#modal-news-id').text(response.news_id || '-');
                    $('#modal-created-at').text(formattedDate || '-');
                    $('#modal-updated-at').text(formattedDate1 || '-');
                    const statusBadgeClass = {
                        'approved': 'bg-success',
                        'rejected': 'bg-danger',
                        'pending': 'bg-warning'
                    }[response.status] || 'bg-secondary';
    
                    const statusText = {
                        'approved': 'Đã duyệt',
                        'rejected': 'Đã từ chối',
                        'pending': 'Đang chờ'
                    }[response.status] || '-';
    
                    $('#modal-status')
                        .removeClass('bg-success bg-danger bg-warning bg-secondary')
                        .addClass(statusBadgeClass)
                        .text(statusText);
    
                    
                    $('#fairRegistrationDetailModal').modal('show');
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
    
@endpush
