@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ __('Danh sách đăng ký tuyển dụng') }}</h5>
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
                                        {{ __('STT') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Người đại diện') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Tên doanh nghiệp') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Mã doanh nghiệp') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Số điện thoại') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Email') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Trạng thái') }}</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('Thao tác') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($businessRecruitments as $key => $recruitment)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $recruitment->representative_name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $recruitment->business_name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $recruitment->business_code }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $recruitment->phone }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $recruitment->email ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <span id="status-badge-{{ $recruitment->id }}" data-status="{{ $recruitment->status }}"
                                                class="badge badge-sm bg-{{ $recruitment->status == 'approved' ? 'success' : ($recruitment->status == 'rejected' ? 'danger' : 'warning') }}">
                                                {{ $recruitment->status == 'approved' ? 'Đã duyệt' : ($recruitment->status == 'rejected' ? 'Đã từ chối' : 'Đang chờ') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-sm p-0 border-0 mb-0" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false"
                                                    title="Thay đổi trạng thái">
                                                    <i class="fas fa-retweet"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="updateStatus('BusinessRecruitment', {{ $recruitment->id }}, 'approved')">
                                                            <i class="fas fa-check-circle text-success me-2"></i>Duyệt
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="updateStatus('BusinessRecruitment', {{ $recruitment->id }}, 'rejected')">
                                                            <i class="fas fa-times-circle text-danger me-2"></i>Từ chối
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="updateStatus('BusinessRecruitment', {{ $recruitment->id }}, 'pending')">
                                                            <i class="fa fa-hourglass-half text-warning me-2"></i>Đang chờ
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <a href="javascript:void(0)" class="mx-3 view-recruitment"
                                                data-id="{{ $recruitment->id }}" title="{{ __('Xem chi tiết') }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $recruitment->id,
                                                'route' => route('recruitment.destroy', $recruitment->id),
                                                'message' => __('Bạn có chắc chắn muốn xóa?'),
                                            ])
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal fade" id="recruitmentDetailModal" tabindex="-1" aria-labelledby="recruitmentDetailModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="card shadow-lg">
                                <div class="card-header bg-gradient-primary p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="text-white mb-0">
                                            <i class="fas fa-building me-2"></i>
                                            {{ __('Thông tin chi tiết doanh nghiệp') }}
                                        </h5>
                                        <button type="button" class="btn btn-link text-white" data-bs-dismiss="modal">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-building me-2"></i>{{ __('Tên doanh nghiệp') }}
                                                </label>
                                                <p id="modal-business-name" class="text-sm mb-2"></p>
                                            </div>
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-id-card me-2"></i>{{ __('MST') }}
                                                </label>
                                                <p id="modal-business-code" class="text-sm mb-2"></p>
                                            </div>
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-th-list me-2"></i>{{ __('Loại doanh nghiệp') }}
                                                </label>
                                                <p id="modal-category-business" class="text-sm mb-2"></p>
                                            </div>
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-map-marker-alt me-2"></i>{{ __('Địa chỉ') }}
                                                </label>
                                                <p id="modal-address" class="text-sm mb-2"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-phone me-2"></i>{{ __('Số điện thoại') }}
                                                </label>
                                                <p id="modal-phone" class="text-sm mb-2"></p>
                                            </div>
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-fax me-2"></i>{{ __('Số Fax') }}
                                                </label>
                                                <p id="modal-fax" class="text-sm mb-2"></p>
                                            </div>
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-envelope me-2"></i>{{ __('Email') }}
                                                </label>
                                                <p id="modal-email" class="text-sm mb-2"></p>
                                            </div>
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-user me-2"></i>{{ __('Người đại diện') }}
                                                </label>
                                                <p id="modal-representative" class="text-sm mb-2"></p>
                                            </div>
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-venus-mars me-2"></i>{{ __('Giới tính') }}
                                                </label>
                                                <p id="modal-gender" class="text-sm mb-2"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-info-circle me-2"></i>{{ __('Thông tin tuyển dụng') }}
                                                </label>
                                                <p id="modal-recruitment-info" class="text-sm mb-2"></p>
                                            </div>
                                            <span id="modal-status" class="badge badge-sm"></span>
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
        $('.view-recruitment').click(function() {
            var recruitmentId = $(this).data('id');
            $.ajax({
                url: '/admin/recruitment/' + recruitmentId,
                type: 'GET',
                success: function(response) {
                    $('#modal-business-name').text(response.business_name || '-');
                    $('#modal-business-code').text(response.business_code || '-');
                    $('#modal-category-business').text(response.category_business?.name || '-');
                    $('#modal-address').text(response.head_office_address || '-');
                    $('#modal-phone').text(response.phone || '-');
                    $('#modal-fax').text(response.fax || '-');
                    $('#modal-email').text(response.email || '-');
                    $('#modal-representative').text(response.representative_name || '-');
                    $('#modal-recruitment-info').text(response.recruitment_info || '-');

                    const genderText = {
                        'male': 'Nam',
                        'female': 'Nữ',
                        'other': 'Khác'
                    }[response.gender] || '-';
                    $('#modal-gender').text(genderText);

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

                    $('#recruitmentDetailModal').modal('show');
                }
            });
        });
    });
</script>
@endpush