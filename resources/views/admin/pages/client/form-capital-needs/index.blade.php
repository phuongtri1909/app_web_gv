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
                            <h5 class="mb-0">{{ __('Danh sách đăng ký nhu cầu vay vốn') }}</h5>
                        </div>
                        {{-- <a href="{{ route('capital-needs.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2"
                            type="button">
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
                                        {{ __('STT') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Tên doanh nghiệp') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Mã số thuế') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Số tiền') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Lãi suất') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Trạng thái') }}</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('Thao tác') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($capitalNeeds as $key => $capitalNeed)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $capitalNeed->business->business_name ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $capitalNeed->business->business_code ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ format_currency_vnd($capitalNeed->finance) }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ number_format($capitalNeed->interest_rate, 1, ',', '.') }}%
                                            </p>
                                        </td>
                                        <td>
                                            <span id="status-badge-{{ $capitalNeed->id }}"
                                                class="badge badge-sm bg-{{ $capitalNeed->status == 'approved' ? 'success' : ($capitalNeed->status == 'rejected' ? 'danger' : 'warning') }}"  data-status="{{ $capitalNeed->status }}">
                                                {{ $capitalNeed->status == 'approved' ? 'Đã duyệt' : ($capitalNeed->status == 'rejected' ? 'Đã từ chối' : 'Đang chờ') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            {{-- <a href="{{ route('capital-needs.edit', $capitalNeed->id) }}" class="mx-3"
                                                title="{{ __('edit') }}">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a> --}}
                                            <div class="dropdown">
                                                <button class="btn btn-sm p-0 border-0 mb-0" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false"
                                                    title="Thay đổi trạng thái">
                                                    <i class="fas fa-retweet"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="updateStatus('BusinessCapitalNeed', {{ $capitalNeed->id }}, 'approved')">
                                                            <i class="fas fa-check-circle text-success me-2"></i>Duyệt
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="updateStatus('BusinessCapitalNeed', {{ $capitalNeed->id }}, 'rejected')">
                                                            <i class="fas fa-times-circle text-danger me-2"></i>Từ chối
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="updateStatus('BusinessCapitalNeed', {{ $capitalNeed->id }}, 'pending')">
                                                            <i class="fa fa-hourglass-half text-warning me-2"></i>Đang chờ
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $capitalNeed->id,
                                                'route' => route('capital-needs.destroy', $capitalNeed->id),
                                                'message' => __('delete_message'),
                                            ])
                                            <a href="javascript:void(0)" class="mx-3 view-capitalNeed"
                                                data-id="{{ $capitalNeed->id }}" title="{{ __('Xem chi tiết') }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <x-pagination :paginator="$capitalNeeds" />
                    </div>

                </div>
            </div>
            <div class="modal fade" id="capitalNeedDetailModal" tabindex="-1" aria-labelledby="capitalNeedDetailModalLabel"
                aria-hidden="true">
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
                                    <div class="col-md-4 text-center">
                                        <div class="avatar-preview mb-3">
                                            <img id="modal-avatar" src="" class="rounded-circle img-fluid shadow"
                                                style="width: 150px; height: 150px; object-fit: cover;"
                                                alt="Business Avatar">
                                        </div>
                                        <h6 id="modal-business-name" class="fw-bold text-primary"></h6>
                                        <p class="text-muted small">MST: <span id="modal-business-code"></span></p>
                                        <span id="modal-status" class="badge badge-sm"></span>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-user me-2"></i>{{ __('Người đại diện') }}
                                                    </label>
                                                    <p id="modal-representative-name" class="text-sm mb-2"></p>
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
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-fax me-2"></i>{{ __('Số Fax') }}
                                                    </label>
                                                    <p id="modal-fax" class="text-sm mb-2"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-envelope me-2"></i>{{ __('Email') }}
                                                    </label>
                                                    <p id="modal-email" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-share-alt me-2"></i>{{ __('Kênh social') }}
                                                    </label>
                                                    <p id="modal-social" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i
                                                            class="fas fa-building me-2"></i>{{ __('Loại hình doanh nghiệp') }}
                                                    </label>
                                                    <p id="modal-category-business" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i
                                                            class="fas fa-briefcase me-2"></i>{{ __('Lĩnh vực kinh doanh') }}
                                                    </label>
                                                    <p id="modal-business-field" class="text-sm mb-2"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-map-marker-alt me-2"></i>{{ __('Địa chỉ') }}
                                                    </label>
                                                    <p id="modal-address" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-building me-2"></i>{{ __('Địa chỉ kinh doanh') }}
                                                    </label>
                                                    <p id="modal-business-address" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-map me-2"></i>{{ __('Phường') }}
                                                    </label>
                                                    <p id="modal-ward" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-bullseye me-2"></i>{{ __('Mục đích vay') }}
                                                    </label>
                                                    <p id="modal-purpose" class="text-sm mb-2"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-money-bill me-2"></i>{{ __('Số tiền vay') }}
                                                    </label>
                                                    <p id="modal-finance" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-percentage me-2"></i>{{ __('Lãi suất') }}
                                                    </label>
                                                    <p id="modal-interest-rate" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i
                                                            class="fas fa-shield-alt me-2"></i>{{ __('Chính sách thế chấp') }}
                                                    </label>
                                                    <p id="modal-mortgage-policy" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i
                                                            class="fas fa-handshake me-2"></i>{{ __('Chính sách tín chấp') }}
                                                    </label>
                                                    <p id="modal-unsecured-policy" class="text-sm mb-2"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i
                                                            class="fas fa-university me-2"></i>{{ __('Kết nối ngân hàng') }}
                                                    </label>
                                                    <p id="modal-bank-connection" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-comments me-2"></i>{{ __('Phản hồi') }}
                                                    </label>
                                                    <p id="modal-feedback" class="text-sm mb-2"></p>
                                                </div>
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
                                                <i class="fas fa-align-left me-2"></i>{{ __('Mô tả') }}
                                            </label>
                                            <p id="modal-description" class="text-sm mb-2"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12">
                                        <a id="modal-license" href="" target="_blank" class="btn btn-primary">
                                            <i class="fas fa-file-pdf me-2"></i>{{ __('Xem giấy phép kinh doanh') }}
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
@endsection
@push('scripts-admin')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            $('.view-capitalNeed').click(function() {
                var capitalNeedId = $(this).data('id');
                $.ajax({
                    url: '/admin/capital-needs/' + capitalNeedId,
                    type: 'GET',
                    success: function(response) {
                        var formattedDate = dayjs(response.created_at).format(
                            'DD/MM/YYYY HH:mm');
                        $('#modal-business-name').text(response.business_name || '-');
                        $('#modal-business-code').text(response.business_code || '-');
                        $('#modal-representative-name').text(response.representative_name ||
                            '-');
                        $('#modal-birth-year').text(response.birth_year || '-');
                        const genderText = {
                            'male': 'Nam',
                            'female': 'Nữ',
                            'other': 'Không xác định'
                        } [response.gender] || '-';

                        $('#modal-gender').text(genderText);

                        $('#modal-email').text(response.email || '-');
                        $('#modal-phone').text(response.phone_number || '-');
                        $('#modal-fax').text(response.fax_number || '-');
                        $('#modal-address').text(response.address || '-');
                        $('#modal-business-address').text(response.business_address || '-');
                        $('#modal-ward').text(response.ward?.name || '-');
                        $('#modal-social').text(response.social_channel || '-');
                        $('#modal-category-business').text(response.category_business?.name ||
                            '-');
                        $('#modal-business-field').text(response.business_field?.name || '-');
                        $('#modal-description').text(response.description || '-');
                        $('#modal-finance').text(new Intl.NumberFormat('vi-VN', {
                            style: 'currency',
                            currency: 'VND'
                        }).format(response.finance));
                        $('#modal-interest-rate').text(
                            new Intl.NumberFormat('vi-VN', {
                                style: 'percent',
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 1
                            }).format(response.interest_rate / 100)
                        );
                        $('#modal-mortgage-policy').text(response.mortgage_policy || '-');
                        $('#modal-unsecured-policy').text(response.unsecured_policy || '-');
                        $('#modal-purpose').text(response.purpose || '-');
                        $('#modal-bank-connection').text(response.bank_connection || '-');
                        $('#modal-feedback').text(response.feedback || '-');
                        $('#modal-created-at').text(formattedDate);
                        $('#modal-avatar').attr('src', response.avt_businesses ? '/' + response
                            .avt_businesses : '');
                        $('#modal-license').attr('href', response.business_license ? '/' +
                            response.business_license : '#');

                        const statusBadgeClass = {
                            'approved': 'bg-success',
                            'rejected': 'bg-danger',
                            'pending': 'bg-warning'
                        } [response.status] || 'bg-secondary';

                        const statusText = {
                            'approved': 'Đã duyệt',
                            'rejected': 'Đã từ chối',
                            'pending': 'Đang chờ'
                        } [response.status] || '-';

                        $('#modal-status')
                            .removeClass('bg-success bg-danger bg-warning bg-secondary')
                            .addClass(statusBadgeClass)
                            .text(statusText);

                        $('#capitalNeedDetailModal').modal('show');
                        // console.log(response);

                    }
                });
            });
        });
    </script>
@endpush
