@extends('admin.layouts.app')
@push('styles-admin')
@endpush

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ __('Danh sách góp ý doanh nghiệp') }}</h5>
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
                                        {{ __('Tên doanh nghiệp') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Họ tên chủ doanh nghiệp') }}</th>
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
                                @foreach ($businessFeedbacks as $key => $feedback)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $feedback->business_name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $feedback->owner_full_name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $feedback->phone }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $feedback->email ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <span  id="status-badge-{{ $feedback->id }}" data-status="{{ $feedback->status }}"
                                                class="badge badge-sm bg-{{ $feedback->status == 'approved' ? 'success' : ($feedback->status == 'rejected' ? 'danger' : 'warning') }}">
                                                {{ $feedback->status == 'approved' ? 'Đã duyệt' : ($feedback->status == 'rejected' ? 'Đã từ chối' : 'Đang chờ') }}
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
                                                            onclick="updateStatus('BusinessFeedback', {{ $feedback->id }}, 'approved')">
                                                            <i class="fas fa-check-circle text-success me-2"></i>Duyệt
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="updateStatus('BusinessFeedback', {{ $feedback->id }}, 'rejected')">
                                                            <i class="fas fa-times-circle text-danger me-2"></i>Từ chối
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="updateStatus('BusinessFeedback', {{ $feedback->id }}, 'pending')">
                                                            <i class="fa fa-hourglass-half text-warning me-2"></i>Đang chờ
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <a href="javascript:void(0)" class="mx-3 view-feedback"
                                                data-id="{{ $feedback->id }}" title="{{ __('Xem chi tiết') }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $feedback->id,
                                                'route' => route('feedback.destroy', $feedback->id),
                                                'message' => __('Bạn có chắc chắn muốn xóa?'),
                                            ])
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <x-pagination :paginator="$businessFeedbacks" />
                    </div>
                </div>
                <div class="modal fade" id="feedbackDetailModal" tabindex="-1" aria-labelledby="feedbackDetailModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="card shadow-lg">
                                <div class="card-header bg-gradient-primary p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="text-white mb-0">
                                            <i class="fas fa-building me-2"></i>
                                            {{ __('Thông tin chi tiết góp ý doanh nghiệp') }}
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
                                                    <i class="fas fa-user me-2"></i>{{ __('Họ tên chủ doanh nghiệp') }}
                                                </label>
                                                <p id="modal-owner-name" class="text-sm mb-2"></p>
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
                                                    <i class="fas fa-envelope me-2"></i>{{ __('Email') }}
                                                </label>
                                                <p id="modal-email" class="text-sm mb-2"></p>
                                            </div>
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-map-marker-alt me-2"></i>{{ __('Địa chỉ cư trú') }}
                                                </label>
                                                <p id="modal-residential-address" class="text-sm mb-2"></p>
                                            </div>
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-building me-2"></i>{{ __('Địa chỉ kinh doanh') }}
                                                </label>
                                                <p id="modal-business-address" class="text-sm mb-2"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-comment me-2"></i>{{ __('Ý kiến') }}
                                                </label>
                                                <p id="modal-opinion" class="text-sm mb-2"></p>
                                            </div>
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-lightbulb me-2"></i>{{ __('Đề xuất') }}
                                                </label>
                                                <p id="modal-suggestions" class="text-sm mb-2"></p>
                                            </div>
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fab fa-facebook me-2"></i>{{ __('Fanpage') }}
                                                </label>
                                                <p id="modal-fanpage" class="text-sm mb-2"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-clock me-2"></i>{{ __('Ngày gửi') }}
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
                                                    <i class="fas fa-images me-2"></i>{{ __('Hình ảnh đính kèm') }}
                                                </label>
                                                <div id="modal-images" class="d-flex flex-wrap gap-2 mt-2"></div>
                                            </div>
                                            <div class="modal fade" id="imagePreviewModal" tabindex="-1"
                                                aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <button type="button"
                                                            class="btn-close btn-close-white d-flex align-items-center justify-content-between p-3 bg-dark"
                                                            data-bs-dismiss="modal"></button>
                                                        <div class="modal-body">
                                                            <div class="position-relative">
                                                                <div class="text-center p-4" style="height: 500px;">
                                                                    <img id="previewImage" src=""
                                                                        class="img-fluid rounded h-100 w-100"
                                                                        style="object-fit: contain;" alt="Preview">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <a id="modal-license" href="" target="_blank"
                                                class="btn btn-primary">
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
    </div>
@endsection
@push('scripts-admin')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            $('.view-feedback').click(function() {
                var feedbackId = $(this).data('id');
                $.ajax({
                    url: '/admin/feedback/' + feedbackId,
                    type: 'GET',
                    success: function(response) {
                        var formattedDate = dayjs(response.created_at).format(
                            'DD/MM/YYYY HH:mm');
                        $('#modal-business-name').text(response.business_name || '-');
                        $('#modal-owner-name').text(response.owner_full_name || '-');
                        $('#modal-birth-year').text(response.birth_year || '-');
                        $('#modal-gender').text({
                            'male': 'Nam',
                            'female': 'Nữ',
                            'other': 'Khác'
                        } [response.gender] || '-');
                        $('#modal-phone').text(response.phone || '-');
                        $('#modal-email').text(response.email || '-');
                        $('#modal-residential-address').text(response.residential_address ||
                            '-');
                        $('#modal-business-address').text(response.business_address || '-');
                        $('#modal-opinion').text(response.opinion || '-');
                        $('#modal-suggestions').text(response.suggestions || '-');
                        $('#modal-fanpage').text(response.fanpage || '-');
                        $('#modal-license').attr('href', response.business_license ? '/' +
                            response.business_license : '#');
                        $('#modal-created-at').text(formattedDate);
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
                        const imagesContainer = $('#modal-images');
                        imagesContainer.empty();
                        if (response.attached_images) {
                            const images = JSON.parse(response.attached_images);
                            images.forEach(image => {
                                const img = $('<img>')
                                    .attr('src', '/' + image)
                                    .addClass('img-fluid rounded')
                                    .css({
                                        'width': '100px',
                                        'height': '100px',
                                        'object-fit': 'cover'
                                    });
                                imagesContainer.append(img);
                            });
                        }

                        $('#feedbackDetailModal').modal('show');
                    }
                });
            });
            $('#modal-images').on('click', 'img', function() {
                $('#previewImage').attr('src', $(this).attr('src'));
                $('#imagePreviewModal').modal('show');
            });
        });
    </script>
@endpush
