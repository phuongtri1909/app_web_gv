
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
        .form-control:focus {
            box-shadow: none;
        }

        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
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
                        <h5 class="mb-0">Kết nối giao thương</h5>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                @include('admin.pages.notification.success-error')

                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('STT') }}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ảnh đại diện</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Thông tin giới thiệu</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Doanh nghiệp</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mã số thuế</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($businesses->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ __('Không có kết quả nào.') }}</p>
                                    </td>
                                </tr>
                            @else
                                @foreach ($businesses as $key => $business)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <img src="{{ asset($business->avt_businesses) }}" alt="" class="img-fluid" width="100" height="100">
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 text-truncate-2">{{ $business->description ?? '-' }}</p>
                                        </td>
                                       
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $business->businessMember->business_name ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $business->businessMember->business_code ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <span id="status-badge-{{ $business->id }}"
                                                class="badge badge-sm bg-{{ $business->status == 'approved' ? 'success' : ($business->status == 'rejected' ? 'danger' : 'warning') }}"  data-status="{{ $business->status }}">
                                                {{ $business->status == 'approved' ? 'Đã duyệt' : ($business->status == 'rejected' ? 'Đã từ chối' : 'Đang chờ') }}
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
                                                                onclick="updateStatus('Business', {{ $business->id }}, 'approved')">
                                                                <i class="fas fa-check-circle text-success me-2"></i>Duyệt
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#"
                                                                onclick="updateStatus('Business', {{ $business->id }}, 'rejected')">
                                                                <i class="fas fa-times-circle text-danger me-2"></i>Từ chối
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#"
                                                                onclick="updateStatus('Business', {{ $business->id }}, 'pending')">
                                                                <i class="fa fa-hourglass-half text-warning me-2"></i>Đang chờ
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            @include('admin.pages.components.delete-form', [
                                                'id' => $business->id,
                                                'route' => route('businesses.destroy', $business->id),
                                                'message' => __('delete_message'),
                                            ])
                                            <a href="javascript:void(0)" class="mx-3 view-business" data-id="{{ $business->id }}" title="{{ __('Xem chi tiết') }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <x-pagination :paginator="$businesses" />
                </div>
            </div>
        </div>
        <div class="modal fade" id="businessDetailModal" tabindex="-1" aria-labelledby="businessDetailModalLabel" aria-hidden="true" style="z-index:10001">
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
                                        <img id="modal-avatar" src="" class="rounded-circle img-fluid shadow" style="width: 150px; height: 150px; object-fit: cover;" alt="Business Avatar">
                                    </div>
                                    <h6 id="modal-business-name" class="fw-bold text-primary"></h6>
                                    <p class="text-muted small">MST: <span id="modal-business-code"></span></p>
                                    <span id="modal-status" class="badge badge-sm"></span>
                                </div>

                                <div class="col-md-8">
                                    <div class="row g-3">
                                        <div class="info-group">
                                            <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                <i class="fas fa-align-left me-2"></i>{{ __('Mô tả') }}
                                            </label>
                                            <p id="modal-description" class="text-sm mb-2"></p>
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
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('.view-business').click(function() {
            var businessId = $(this).data('id');
            $.ajax({
                url: '/admin/businesses/' + businessId,
                type: 'GET',
                success: function(response) {
                    $('#modal-business-name').text(response.business_name || '-');
                    $('#modal-business-code').text(response.business_code || '-');
                    $('#modal-representative-name').text(response.representative_name || '-');
                    $('#modal-description').text(response.description || '-');
                    $('#modal-avatar').attr('src', response.avt_businesses ? '/' + response.avt_businesses : 'image.jpg');

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

                    $('#businessDetailModal').modal('show');
                },
                error: function(error) {
                    showToast('Có lỗi xảy ra. Vui lòng thử lại sau.','error');  
                }
            });
        });
    });
    </script>

@endpush
