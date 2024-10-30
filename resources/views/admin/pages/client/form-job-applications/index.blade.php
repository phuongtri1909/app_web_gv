@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ __('Danh sách đăng ký tìm việc') }}</h5>
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
                                        {{ __('Họ và tên') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Năm sinh') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Giới tính') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Số điện thoại') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Email') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('CV') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Trạng thái') }}</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('Thao tác') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jobApplications as $key => $application)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $application->full_name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $application->birth_year }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                @if ($application->gender == 'male')
                                                    Nam
                                                @elseif($application->gender == 'female')
                                                    Nữ
                                                @else
                                                    Khác
                                                @endif
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $application->phone }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $application->email ?? '-' }}</p>
                                        </td>
                                        <td>
                                            @if ($application->cv)
                                                <a href="{{ asset($application->cv) }}" target="_blank"
                                                    class="btn btn-link text-primary px-3 mb-0">
                                                    <i class="fas fa-file-pdf me-2"></i>Xem CV
                                                </a>
                                            @else
                                                <span class="text-xs font-weight-bold mb-0">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span id="status-badge-{{ $application->id }}" data-status="{{ $application->status }}"
                                                class="badge badge-sm bg-{{ $application->status == 'approved' ? 'success' : ($application->status == 'rejected' ? 'danger' : 'warning') }}">
                                                {{ $application->status == 'approved' ? 'Đã duyệt' : ($application->status == 'rejected' ? 'Đã từ chối' : 'Đang chờ') }}
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
                                                            onclick="updateStatus('JobApplication', {{ $application->id }}, 'approved')">
                                                            <i class="fas fa-check-circle text-success me-2"></i>Duyệt
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="updateStatus('JobApplication', {{ $application->id }}, 'rejected')">
                                                            <i class="fas fa-times-circle text-danger me-2"></i>Từ chối
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="updateStatus('JobApplication', {{ $application->id }}, 'pending')">
                                                            <i class="fa fa-hourglass-half text-warning me-2"></i>Đang chờ
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <a href="javascript:void(0)" class="mx-3 view-application"
                                                data-id="{{ $application->id }}" title="{{ __('Xem chi tiết') }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $application->id,
                                                'route' => route('job-applications.destroy', $application->id),
                                                'message' => __('Bạn có chắc chắn muốn xóa?'),
                                            ])
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="modal fade" id="applicationDetailModal" tabindex="-1"
                            aria-labelledby="applicationDetailModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="card shadow-lg">
                                        <div class="card-header bg-gradient-primary p-3">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h5 class="text-white mb-0">
                                                    <i class="fas fa-user me-2"></i>
                                                    {{ __('Thông tin chi tiết ứng viên') }}
                                                </h5>
                                                <button type="button" class="btn btn-link text-white"
                                                    data-bs-dismiss="modal">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="row g-4">
                                                <div class="col-md-6">
                                                    <div class="info-group">
                                                        <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                            <i class="fas fa-user me-2"></i>{{ __('Họ và tên') }}
                                                        </label>
                                                        <p id="modal-full-name" class="text-sm mb-2"></p>
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
                                                            <i class="fas fa-clock me-2"></i>{{ __('Ngày gửi cv') }}
                                                        </label>
                                                        <p id="modal-created-at" class="text-sm mb-2"></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-12">
                                                    <div class="info-group">
                                                        <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                            <i
                                                                class="fas fa-align-left me-2"></i>{{ __('Giới thiệu bản thân') }}
                                                        </label>
                                                        <p id="modal-introduction" class="text-sm mb-2"></p>
                                                    </div>
                                                    <div class="info-group">
                                                        <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                            <i
                                                                class="fas fa-briefcase me-2"></i>{{ __('Đăng ký tìm việc') }}
                                                        </label>
                                                        <p id="modal-job-registration" class="text-sm mb-2"></p>
                                                    </div>
                                                    <span id="modal-status" class="badge badge-sm"></span>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-12">
                                                    <a id="modal-cv" href="" target="_blank"
                                                        class="btn btn-primary">
                                                        <i class="fas fa-file-pdf me-2"></i>{{ __('Xem CV') }}
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
@endsection
@push('scripts-admin')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            $('.view-application').click(function() {
                var applicationId = $(this).data('id');
                $.ajax({
                    url: '/admin/job-applications/' + applicationId,
                    type: 'GET',
                    success: function(response) {
                        var formattedDate = dayjs(response.created_at).format(
                            'DD/MM/YYYY HH:mm');
                        $('#modal-full-name').text(response.full_name || '-');
                        $('#modal-birth-year').text(response.birth_year || '-');
                        const genderText = {
                            'male': 'Nam',
                            'female': 'Nữ',
                            'other': 'Khác'
                        } [response.gender] || '-';
                        $('#modal-gender').text(genderText);
                        $('#modal-phone').text(response.phone || '-');
                        $('#modal-fax').text(response.fax || '-');
                        $('#modal-email').text(response.email || '-');
                        $('#modal-introduction').text(response.introduction || '-');
                        $('#modal-job-registration').text(response.job_registration || '-');
                        $('#modal-cv').attr('href', response.cv ? '/' + response.cv : '#');
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
                        $('#applicationDetailModal').modal('show');
                    }
                });
            });
        });
    </script>
@endpush
