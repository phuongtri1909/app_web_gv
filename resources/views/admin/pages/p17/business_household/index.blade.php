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

        .badge-sm {
            padding: 5px 10px;
        }

        .text-truncate-2 {
            -webkit-line-clamp: 2;
            display: -webkit-box;
            overflow: hidden;
            -webkit-box-orient: vertical;
        }
    </style>
@endpush

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Danh sách Hộ Kinh Doanh</h5>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Chủ hộ kinh doanh</th>
                                    <th>Biển hiệu</th>
                                    <th>Ngày cấp</th>
                                    <th>Số điện thoại</th>
                                    <th>Địa chỉ</th>
                                    <th>Trạng thái</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($businessHouseholds as $key => $business)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $business->business_owner_full_name ?? '-' }}</td>
                                        <td>{{ $business->signboard ?? '-' }}</td>
                                        <td>{{ $business->date_issued ?? '-' }}</td>
                                        <td>{{ $business->phone ?? '-' }}</td>
                                        <td>{{ $business->address ?? '-' }}</td>
                                        <td>
                                            <span id="status-badge-{{ $business->id }}"
                                                class="badge badge-sm bg-{{ $business->status == 'active' ? 'success' : ($business->status == 'inactive' ? 'danger' : 'warning') }}"
                                                data-status="{{ $business->status }}">
                                                {{ $business->status == 'active' ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="dropstarto">
                                                <button class="btn btn-sm p-0 border-0 mb-0" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false"
                                                    title="Thay đổi trạng thái">
                                                    <i class="fas fa-retweet"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item change-status" href="#"
                                                            data-status="active" data-business-id="{{ $business->id }}">
                                                            <i class="fas fa-check-circle text-success me-2"></i>Active
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item change-status" href="#"
                                                            data-status="inactive" data-business-id="{{ $business->id }}">
                                                            <i class="fas fa-times-circle text-danger me-2"></i>Inactive
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <a href="#" class="mx-2 view-business" data-id="{{ $business->id }}"
                                                title="Xem chi tiết">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Không có kết quả nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <x-pagination :paginator="$businessHouseholds" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="businessDetailModal" tabindex="-1" aria-labelledby="businessDetailModalLabel"
        aria-hidden="true" style="z-index:10001">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card shadow-lg">
                    <div class="card-header bg-gradient-primary p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="text-white mb-0">
                                <i class="fas fa-building me-2"></i>
                                {{ __('Thông tin chi tiết hộ kinh doanh') }}
                            </h5>
                            <button type="button" class="btn btn-link text-white" data-bs-dismiss="modal">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-4 text-center">
                                <h6 id="modal-business-owner" class="fw-bold text-primary"></h6>
                                <p class="text-muted small">Số giấy phép: <span id="modal-license-number"></span></p>
                                <span id="modal-status" class="badge badge-sm"></span>
                            </div>

                            <div class="col-md-8">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <label class="text-uppercase text-xs font-weight-bolder opacity-7">SĐT</label>
                                        <p id="modal-phone" class="text-sm mb-2"></p>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-uppercase text-xs font-weight-bolder opacity-7">CCCD</label>
                                        <p id="modal-cccd" class="text-sm mb-2"></p>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-uppercase text-xs font-weight-bolder opacity-7">Ngày cấp</label>
                                        <p id="modal-date-issued" class="text-sm mb-2"></p>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-uppercase text-xs font-weight-bolder opacity-7">Ngày sinh</label>
                                        <p id="modal-business-dob" class="text-sm mb-2"></p>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-uppercase text-xs font-weight-bolder opacity-7">Địa chỉ</label>
                                        <p id="modal-address" class="text-sm mb-2"></p>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-uppercase text-xs font-weight-bolder opacity-7">Bản hiệu</label>
                                        <p id="modal-signboard" class="text-sm mb-2"></p>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-uppercase text-xs font-weight-bolder opacity-7">Số nhà</label>
                                        <p id="modal-house-number" class="text-sm mb-2"></p>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-uppercase text-xs font-weight-bolder opacity-7">Đường</label>
                                        <p id="modal-road-name" class="text-sm mb-2"></p>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-uppercase text-xs font-weight-bolder opacity-7">Lĩnh vực</label>
                                        <p id="modal-business-field" class="text-sm mb-2"></p>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-uppercase text-xs font-weight-bolder opacity-7">Loại hình</label>
                                        <p id="modal-category-market" class="text-sm mb-2"></p>
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
            $('.view-business').click(function() {
                var businessId = $(this).data('id');
                $.ajax({
                    url: '/admin/business-households/' + businessId,
                    type: 'GET',
                    success: function(response) {
                        $('#modal-business-owner').text(response.business_owner_full_name ||
                            '-');
                        $('#modal-license-number').text(response.license_number || '-');
                        $('#modal-date-issued').text(response.date_issued || '-');
                        $('#modal-business-dob').text(response.business_dob || '-');
                        $('#modal-address').text(response.address || '-');
                        $('#modal-road-name').text(response.road_name || '-');
                        $('#modal-business-field').text(response.business_field || '-');
                        $('#modal-category-market').text(response.category_market_name || '-');
                        $('#modal-phone').text(response.phone || '-');
                        $('#modal-cccd').text(response.cccd || '-');
                        $('#modal-house-number').text(response.house_number || '-');
                        $('#modal-signboard').text(response.signboard || '-');
                        const statusBadgeClass = response.status === 'active' ? 'bg-success' :
                            'bg-danger';
                        const statusText = response.status === 'active' ? 'Hoạt động' :
                            'Không hoạt động';

                        $('#modal-status')
                            .removeClass('bg-success bg-danger')
                            .addClass(statusBadgeClass)
                            .text(statusText);

                        $('#businessDetailModal').modal('show');
                    },
                    error: function(error) {
                        showToast('Có lỗi xảy ra. Vui lòng thử lại sau.', 'error');
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.change-status').on('click', function(e) {
                e.preventDefault();

                var businessId = $(this).data('business-id');
                var status = $(this).data('status');

                $.ajax({
                    url: '{{ route('business.households.changeStatus') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        business_id: businessId,
                        status: status
                    },
                    success: function(response) {
                        if (response.error) {
                            showToast(response.error, 'error');
                        } else {
                            showToast(response.success, 'success');

                            var badge = $('#status-badge-' + businessId);

                            if (status === 'active') {
                                badge.removeClass('bg-danger').addClass('bg-success').text(
                                    'Active');
                            } else {
                                badge.removeClass('bg-success').addClass('bg-danger').text(
                                    'Inactive');
                            }
                        }
                    }
                });
            });
        });
    </script>
@endpush