@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        .img-square {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }
        .info-group label {
        color: #8392AB;
        margin-bottom: 4px;
        }
        .info-group p {
            color: #344767;
            font-weight: 500;
        }
        .avatar-preview {
            border: 3px solid #5e72e4;
            padding: 3px;
            border-radius: 50%;
            display: inline-block;
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
                            <h5 class="mb-0">
                                {{ __('Danh sách đăng ký nhu cầu khởi nghiệp') }}</h5>
                        </div>
                        {{-- <a href="{{ route('start-promotion-investment.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button">
                        <i class="fa-solid fa-plus"></i> {{ __('Thêm mới') }}
                    </a> --}}
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @include('admin.pages.notification.success-error')

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('STT') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Họ và tên') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Năm sinh') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Giới tính') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Số điện thoại') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Trạng thái') }}
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('Thao tác') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($promotions as $key => $promotion)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $promotion->name ?? '-' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $promotion->birth_year ?? '-' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ ucfirst($promotion->gender) ?? '-' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $promotion->phone ?? '-' }}
                                            </p>
                                        </td>
                                        <td>
                                            <span id="status-badge-{{ $promotion->id }}"
                                                class="badge badge-sm bg-{{ $promotion->status == 'approved' ? 'success' : ($promotion->status == 'rejected' ? 'danger' : 'warning') }}"
                                                data-status="{{ $promotion->status }}">
                                                {{ $promotion->status == 'approved' ? 'Đã duyệt' : ($promotion->status == 'rejected' ? 'Đã từ chối' : 'Đang chờ') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="dropstart">
                                                <button class="btn btn-sm p-0 border-0 mb-0" type="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false" title="Thay đổi trạng thái">
                                                    <i class="fas fa-retweet"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="updateStatus('BusinessStartPromotionInvestment', {{ $promotion->id }}, 'approved')">
                                                            <i class="fas fa-check-circle text-success me-2"></i>Duyệt
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="updateStatus('BusinessStartPromotionInvestment', {{ $promotion->id }}, 'rejected')">
                                                            <i class="fas fa-times-circle text-danger me-2"></i>Từ chối
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="updateStatus('BusinessStartPromotionInvestment', {{ $promotion->id }}, 'pending')">
                                                            <i class="fa fa-hourglass-half text-warning me-2"></i>Đang chờ
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                    
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $promotion->id,
                                                'route' => route('start-promotion-investment.destroy', $promotion->id),
                                                'message' => __('delete_message'),
                                            ])
                                            <a href="javascript:void(0)" class="mx-3 view-promotion" data-id="{{ $promotion->id }}"
                                                title="{{ __('Xem chi tiết') }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <x-pagination :paginator="$promotions" />
                    </div>                    

                </div>
            </div>
            <div class="modal fade" id="promotionDetailModal" tabindex="-1" aria-labelledby="promotionDetailModal" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="card shadow-lg">
                            <div class="card-header bg-gradient-primary p-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="text-white mb-0">
                                        <i class="fas fa-building me-2"></i>
                                        {{ __('Thông tin chi tiết') }}
                                    </h5>
                                    <button type="button" class="btn btn-link text-white" data-bs-dismiss="modal">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-4 text-center">
                                        <span id="modal-status" class="badge badge-sm"></span>
                                    </div>
            
                                    <div class="col-md-8">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-user me-2"></i>{{ __('Họ và tên') }}
                                                    </label>
                                                    <p id="modal-business-name" class="text-sm mb-2"></p>
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
                                                    <p id="modal-phone" class="text-sm mb-2"></p>
                                                </div>
                                            </div>
            
                                            <div class="col-md-6">
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-map-marker-alt me-2"></i>{{ __('Địa chỉ khởi nghiệp') }}
                                                    </label>
                                                    <p id="modal-startup-address" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-briefcase me-2"></i>{{ __('Ngành nghề kinh doanh') }}
                                                    </label>
                                                    <p id="modal-business-field" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-hands-helping me-2"></i>{{ __('Nhu cầu hỗ trợ') }}
                                                    </label>
                                                    <p id="modal-support-needs" class="text-sm mb-2"></p>
                                                </div>
                                            </div>
                                        </div>
            
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-clock me-2"></i>{{ __('Ngày đăng ký') }}
                                                    </label>
                                                    <p id="modal-created-at" class="text-sm mb-2"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="info-group">
                                            <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                <i class="fas fa-align-left me-2"></i>{{ __('Thông tin hoạt động khởi nghiệp') }}
                                            </label>
                                            <p id="modal-startup-activity-info" class="text-sm mb-2"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
        $('.view-promotion').click(function() {
            var promotionId = $(this).data('id'); 
            $.ajax({
                url: '/admin/start-promotion-investment/' + promotionId,
                type: 'GET',
                success: function(response) {
                    var formattedDate = dayjs(response.created_at).format('DD/MM/YYYY HH:mm');
                    $('#modal-business-name').text(response.name || '-');
                    $('#modal-birth-year').text(response.birth_year || '-');

                    const genderText = {
                        'male': 'Nam',
                        'female': 'Nữ',
                        'other': 'Không xác định'
                    }[response.gender] || '-';

                    $('#modal-gender').text(genderText);
                    $('#modal-phone').text(response.phone || '-');
                    $('#modal-startup-address').text(response.startup_address || '-');
                    $('#modal-business-field').text(response.business_field|| '-');
                    $('#modal-startup-activity-info').text(response.startup_activity_info || '-');

                    const supportNeedsText = response.business_support_needs ? response.business_support_needs.join(', ') : '-';
                    $('#modal-support-needs').text(supportNeedsText);

                    $('#modal-created-at').text(formattedDate);
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
                    $('#promotionDetailModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching promotion data:', error);
                }
            });
        });
    });
</script>

@endpush
