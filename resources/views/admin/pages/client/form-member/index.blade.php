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
        .form-control:focus {
            box-shadow: none;
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
                        <h5 class="mb-0">{{ __('Danh sách đăng ký hội viên') }}</h5>
                    </div>
                    {{-- <a href="{{ route('business-members.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button">
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('STT') }}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('Tên doanh nghiệp') }}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('Mã giấy phép') }}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('Người đại diện') }}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('Số điện thoại') }}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('Email') }}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('Trạng thái') }}</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('Thao tác') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($members->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ __('Không có kết quả nào.') }}</p>
                                    </td>
                                </tr>
                            @else
                                @foreach ($members as $key => $member)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $member->business_name ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $member->business_license_number ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $member->representative_full_name ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $member->phone ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $member->email ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <span id="status-badge-{{ $member->id }}"
                                                class="badge badge-sm bg-{{ $member->status == 'approved' ? 'success' : ($member->status == 'rejected' ? 'danger' : 'warning') }}"  data-status="{{ $member->status }}">
                                                {{ $member->status == 'approved' ? 'Đã duyệt' : ($member->status == 'rejected' ? 'Đã từ chối' : 'Đang chờ') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="menu">
                                                <div class="dropstart d-block">
                                                    <button class="btn btn-sm p-0 border-0 mb-0" type="button"
                                                        data-bs-toggle="dropdown"  aria-expanded="false"
                                                        title="Thay đổi trạng thái">
                                                        <i class="fas fa-retweet"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="#"
                                                                onclick="updateStatus('BusinessMember', {{ $member->id }}, 'approved')">
                                                                <i class="fas fa-check-circle text-success me-2"></i>Duyệt
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#"
                                                                onclick="updateStatus('BusinessMember', {{ $member->id }}, 'rejected')">
                                                                <i class="fas fa-times-circle text-danger me-2"></i>Từ chối
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#"
                                                                onclick="updateStatus('BusinessMember', {{ $member->id }}, 'pending')">
                                                                <i class="fa fa-hourglass-half text-warning me-2"></i>Đang chờ
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $member->id,
                                                'route' => route('members.destroy', $member->id),
                                                'message' => __('delete_message'),
                                            ])
                                            <a href="javascript:void(0)" class="mx-3 view-member" data-id="{{ $member->id }}" title="{{ __('Xem chi tiết') }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <x-pagination :paginator="$members" />
                </div>
            </div>
            <div class="modal fade" id="memberDetailModal" tabindex="-1" aria-labelledby="memberDetailModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="card shadow-lg">
                            <div class="card-header bg-gradient-primary p-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="text-white mb-0">
                                        <i class="fas fa-building me-2"></i>
                                        {{ __('Thông tin chi tiết hội viên') }}
                                    </h5>
                                    <button type="button" class="btn btn-link text-white" data-bs-dismiss="modal">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-12">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-building me-2"></i>{{ __('Tên doanh nghiệp') }}
                                                    </label>
                                                    <p id="modal-business-name" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-briefcase me-2"></i>{{ __('Ngành nghề kinh doanh') }}
                                                    </label>
                                                    <p id="modal-business-field" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-map-marker-alt me-2"></i>{{ __('Địa chỉ trụ sở') }}
                                                    </label>
                                                    <p id="modal-head-office" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-code-branch me-2"></i>{{ __('Địa chỉ chi nhánh') }}
                                                    </label>
                                                    <p id="modal-branch-address" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-handshake me-2"></i>{{ __('Tham gia tổ chức') }}
                                                    </label>
                                                    <p id="modal-organization" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-fax me-2"></i>{{ __('Fax') }}
                                                    </label>
                                                    <p id="modal-fax" class="text-sm mb-2"></p>
                                                </div>  
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-id-badge me-2"></i>{{ __('Số giấy phép kinh doanh') }}
                                                    </label>
                                                    <p id="modal-business-license-number" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-calendar me-2"></i>{{ __('Ngày cấp giấy phép') }}
                                                    </label>
                                                    <p id="modal-license-issue-date" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-map-marker-alt me-2"></i>{{ __('Nơi cấp giấy phép') }}
                                                    </label>
                                                    <p id="modal-license-issue-place" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-phone me-2"></i>{{ __('Điện thoại liên hệ') }}
                                                    </label>
                                                    <p id="modal-contact-phone" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-envelope me-2"></i>{{ __('Email doanh nghiệp') }}
                                                    </label>
                                                    <p id="modal-email" class="text-sm mb-2"></p>
                                                </div>
                                                
                                            </div>
                                            <label>Người đại diện tham gia hội(*)</label>
                                            <div class="col-md-6">
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-id-card me-2"></i>{{ __('CCCD/CMND') }}
                                                    </label>
                                                    <p id="modal-identity-card" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-calendar me-2"></i>{{ __('Ngày cấp CCCD') }}
                                                    </label>
                                                    <p id="modal-identity-date" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-home me-2"></i>{{ __('Địa chỉ nhà') }}
                                                    </label>
                                                    <p id="modal-home-address" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-phone me-2"></i>{{ __('Điện thoại') }}
                                                    </label>
                                                    <p id="modal-phone" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-envelope me-2"></i>{{ __('Email người đại diện') }}
                                                    </label>
                                                    <p id="modal-representative-email" class="text-sm mb-2"></p>
                                                </div>                                                                            
                                            </div>
                                            <div class="col-md-6">                               
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-user me-2"></i>{{ __('Tên đầy đủ người đại diện') }}
                                                    </label>
                                                    <p id="modal-representative-name" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-user-tag me-2"></i>{{ __('Chức vụ người đại diện') }}
                                                    </label>
                                                    <p id="modal-representative-position" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-venus-mars me-2"></i>{{ __('Giới tính') }}
                                                    </label>
                                                    <p id="modal-gender" class="text-sm mb-2"></p>
                                                </div>  
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-clock me-2"></i>{{ __('Ngày đăng ký') }}
                                                    </label>
                                                    <p id="modal-created-at" class="text-sm mb-2"></p>
                                                </div>     
                                                <span id="modal-status" class="badge badge-sm"></span>
                                            </div>
                                        </div>
            
                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-file-alt me-2"></i>{{ __('Tài liệu đính kèm') }}
                                                    </label>
                                                    <div class="d-flex gap-3">
                                                        <a id="modal-business-license" href="" target="_blank" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-file-pdf me-2"></i>{{ __('Giấy phép kinh doanh') }}
                                                        </a>
                                                        <a id="modal-identity-front" href="" target="_blank" class="btn btn-sm btn-info">
                                                            <i class="fas fa-id-card me-2"></i>{{ __('CCCD mặt trước') }}
                                                        </a>
                                                        <a id="modal-identity-back" href="" target="_blank" class="btn btn-sm btn-info">
                                                            <i class="fas fa-id-card me-2"></i>{{ __('CCCD mặt sau') }}
                                                        </a>
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
            $('.view-member').click(function() {
                var memberId = $(this).data('id');
                $.ajax({
                    url: '/admin/members/' + memberId,
                    type: 'GET',
                    success: function(response) {
                        var formattedDate = dayjs(response.created_at).format(
                            'DD/MM/YYYY HH:mm');
                        var formattedLicenseIssueDate = dayjs(response.license_issue_date).format(
                            'DD/MM/YYYY');
                        var formattedIdentityCardIssueDate = dayjs(response.identity_card_issue_date).format(
                            'DD/MM/YYYY');  

                        $('#modal-business-name').text(response.business_name || '-');
                        $('#modal-business-field').text(response.business_field || '-');
                        $('#modal-head-office').text(response.head_office_address || '-');
                        $('#modal-branch-address').text(response.branch_address || '-');
                        $('#modal-organization').text(response.organization_participation || '-');
                        $('#modal-identity-card').text(response.identity_card || '-');
                        $('#modal-identity-date').text(formattedIdentityCardIssueDate || '-');
                        $('#modal-home-address').text(response.home_address || '-');
                        $('#modal-contact-phone').text(response.contact_phone || '-');
                        $('#modal-representative-email').text(response.representative_email || '-');
                        $('#modal-license-issue-date').text(formattedLicenseIssueDate|| '-');
                        $('#modal-license-issue-place').text(response.license_issue_place || '-');
                        $('#modal-phone').text(response.phone || '-');
                        $('#modal-fax').text(response.fax || '-');
                        $('#modal-email').text(response.email || '-');
                        $('#modal-representative-name').text(response.representative_full_name || '-');
                        $('#modal-representative-position').text(response.representative_position || '-');
                        const genderText = {
                                'male': 'Nam',
                                'female': 'Nữ',
                                'other': 'Không xác định'
                            } [response.gender] || '-';

                        $('#modal-gender').text(genderText);

                        $('#modal-business-license').attr('href', response.business_license_file ? '/' + response.business_license_file : '#');
                        $('#modal-identity-front').attr('href', response.identity_card_front_file ? '/' + response.identity_card_front_file : '#');
                        $('#modal-identity-back').attr('href', response.identity_card_back_file ? '/' + response.identity_card_back_file : '#');
                        $('#modal-business-license-number').text(response.business_license_number || '-');
                        $('#modal-created-at').text(formattedDate || '-');
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

                        $('#memberDetailModal').modal('show');
                    }
                });
            });
        });
    </script>
@endpush

