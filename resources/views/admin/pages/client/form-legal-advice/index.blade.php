@extends('admin.layouts.app')
@push('styles-admin')
    <style>
        .text-ellipsis {
            white-space: nowrap;
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
                            <h5 class="mb-0">{{ __('Danh sách tư vấn pháp luật') }}</h5>
                        </div>
                    </div>

                    <div class="mt-2">
                        <form method="GET" class="d-md-flex">
                            @if (request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">  
                            @endif
                            
                            <select name="search-status" class="form-select form-select-sm me-2 mt-2 mt-md-0 w-auto">
                                <option value="">{{ __('Tất cả') }}</option>
                                <option value="approved"
                                    {{ request('search-status') == 'approved' ? 'selected' : '' }}>
                                    {{ __('Đã duyệt') }}</option>
                                <option value="pending"
                                    {{ request('search-status') == 'pending' ? 'selected' : '' }}>
                                    {{ __('Đang chờ') }}</option>
                                <option value="rejected"
                                    {{ request('search-status') == 'rejected' ? 'selected' : '' }}>
                                    {{ __('Đã từ chối') }}</option>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm mb-0 mt-2 mt-md-0 py-0">Tìm kiếm</button>
                        </form>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        @include('admin.pages.notification.success-error')
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('STT') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Tên') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Số điện thoại') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Email') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Địa chỉ') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Tên công ty') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Nội dung tư vấn') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Trạng thái') }}</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($legalAdvices as $key => $advice)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $advice->name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $advice->phone }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $advice->email }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $advice->address }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $advice->company_name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 text-ellipsis" style="max-width: 300px">{{ $advice->advice_content }}</p>
                                        </td>
                                        <td>
                                            <span id="status-badge-{{ $advice->id }}" data-status="{{ $advice->status }}"
                                                class="badge badge-sm {{ $advice->status == 'completed' ? 'bg-success' : ($advice->status == 'in_progress' ? 'bg-info' : 'bg-warning') }}">
                                                {{ $advice->status == 'completed' ? 'Đã hoàn thành' : ($advice->status == 'in_progress' ? 'Đang xử lý' : 'Đang chờ') }}
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
                                                        onclick="updateStatus1('LegalAdvice', {{ $advice->id }}, 'completed')">
                                                        <i class="fas fa-check-circle text-success me-2"></i>Đã hoàn thành
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#"
                                                        onclick="updateStatus1('LegalAdvice', {{ $advice->id }}, 'in_progress')">
                                                        <i class="fas fa-spinner text-info me-2"></i>Đang xử lý
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#"
                                                        onclick="updateStatus1('LegalAdvice', {{ $advice->id }}, 'pending ')">
                                                        <i class="fa fa-hourglass-half text-warning me-2"></i>Đang chờ 
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <a href="javascript:void(0)" class="mx-3 view-advice"
                                            data-id="{{ $advice->id }}" title="{{ __('Xem chi tiết') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @include('admin.pages.components.delete-form', [
                                            'id' => $advice->id,
                                            'route' => route('form-legal-advice.destroy', $advice->id),
                                            'message' => __('Bạn có chắc chắn muốn xóa?'),
                                        ])
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="modal fade" id="legalAdviceModal" tabindex="-1" aria-labelledby="legalAdviceModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="card shadow-lg">
                                    <div class="card-header bg-gradient-primary p-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h5 class="text-white mb-0">
                                                <i class="fas fa-gavel me-2"></i>
                                                {{ __('Thông tin chi tiết tư vấn pháp luật') }}
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
                                                        <i class="fas fa-user me-2"></i>{{ __('Tên') }}
                                                    </label>
                                                    <p id="modal-name" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-phone me-2"></i>{{ __('Số điện thoại') }}
                                                    </label>
                                                    <p id="modal-phone" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-envelope me-2"></i>{{ __('Email') }}
                                                    </label>
                                                    <p id="modal-email" class="text-sm mb-2"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-building me-2"></i>{{ __('Tên công ty') }}
                                                    </label>
                                                    <p id="modal-company" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                        <i class="fas fa-map-marker-alt me-2"></i>{{ __('Địa chỉ') }}
                                                    </label>
                                                    <p id="modal-address" class="text-sm mb-2"></p>
                                                </div>
                                                <div class="info-group">
                                                    <div class="row mt-4">
                                                        <div class="col-12">
                                                            <span id="modal-status" class="badge badge-sm"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="info-group mt-3">
                                            <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                <i class="fas fa-file-alt me-2"></i>{{ __('Nội dung tư vấn') }}
                                            </label>
                                            <p id="modal-content" class="text-sm mb-2"></p>
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
        $(document).ready(function () {
            $('.view-advice').click(function () {
                var adviceId = $(this).data('id');
                $.ajax({
                    url: '/admin/form-legal-advice/' + adviceId,
                    type: 'GET',
                    success: function (response) {
                        $('#modal-name').text(response.name || '-');
                        $('#modal-phone').text(response.phone || '-');
                        $('#modal-email').text(response.email || '-');
                        $('#modal-company').text(response.company_name || '-');
                        $('#modal-address').text(response.address || '-');
                        
                        const statusBadgeClass = {
                            'pending': 'bg-warning',
                            'in_progress': 'bg-info',
                            'completed': 'bg-success'
                        }[response.status] || 'bg-secondary';

                        const statusText = {
                            'pending': 'Đang chờ',
                            'in_progress': 'Đang xử lý',
                            'completed': 'Đã hoàn thành'
                        }[response.status] || '-';

                        $('#modal-status')  
                            .removeClass('bg-success bg-info bg-warning bg-secondary')
                            .addClass(statusBadgeClass)
                            .text(statusText);
                        
                        $('#modal-content').text(response.advice_content || '-');
                        $('#legalAdviceModal').modal('show');
                    },
                    error: function (xhr, status, error) {
                        console.log('Error: ' + error + '\n' + xhr.responseText);
                    },
                });
            });
        });
    </script>
@endpush
