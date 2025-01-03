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

        .import-container {
            border-radius: 5px;
            max-width: 400px;
            text-align: center;
        }

        .file-upload input[type="file"] {
            display: none;
        }

        .file-upload {
            margin-right: 10px;
        }

        .file-upload label {
            display: inline-block;
            padding: 6px 15px;
            border: 1px solid #007bff;
            color: #007bff;
            cursor: pointer;
            border-radius: 5px;
        }

        .file-upload label:hover {
            background-color: #007bff;
            color: white;
        }

        .file-name-icon {
            display: inline-flex;
            align-items: center;
            margin-left: 10px;
            padding: 5px 10px;
            border: 1px solid #007bff;
            background-color: #f0f8ff;
            color: #007bff;
            border-radius: 5px;
            font-size: 0.9rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }

        .file-name-icon i {
            margin-right: 5px;
            font-size: 1rem;
            color: #007bff;
        }
    </style>
@endpush

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div>
                                    <h5 class="mb-0">{{ __('Danh sách đăng ký thành viên app') }}</h5>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="import-container d-flex">
                                    <form id="importForm" action="{{ route('import.business') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="d-flex">
                                            <div class="file-upload">
                                                <input type="file" name="file" id="fileInput" accept=".csv,.xls,.xlsx"
                                                    required>
                                                <label for="fileInput">Chọn file Excel</label>
                                            </div>
                                            <div class="button-submit">
                                                <button type="submit" class="btn btn-primary btn-sm mb-0">Tải lên</button>
                                            </div>
                                        </div>
                                        <span id="fileName" class="file-name-icon" style="display: none;">
                                            <i class="fa fa-file" aria-hidden="true"></i>
                                            <span id="fileNameText"></span>
                                        </span>
                                    </form>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div>
                                    <form method="GET" class="d-flex">
                                        @if (request('search'))
                                            <input type="hidden" name="search" value="{{ request('search') }}">
                                        @endif
                                        <select name="search-status" class="form-control-sm me-2">
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
                                        <button type="submit"
                                            class="btn btn-primary btn-sm mb-0">{{ __('Tìm kiếm') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="progress-container" style="display: none;">
                            <h5>Đang xử lý...</h5>
                            <div class="progress">
                                <div id="progress-bar" class="progress-bar" style="width: 0%;"></div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @include('admin.pages.notification.success-error')

                    <div class="mx-4 mt-2 mt-md-0">
                        <form id="reportForm" method="GET" class="form-inline">

                            <div class="d-flex">
                                <div class="me-2">
                                    <label for="date_range" class="sr-only">Khoảng thời gian</label>
                                    <input type="text" name="date_range" id="date_range"
                                        class="form-control form-control-sm" placeholder="Từ ngày - Đến ngày"
                                        value="{{ request('date_range') }}">
                                </div>

                                <div>
                                    <button type="button" class="btn btn-primary btn-sm mb-0 px-1"
                                        onclick="submitForm('{{ route('reports.business.member') }}')">Báo cáo</button>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('STT') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Tên doanh nghiệp') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Mã doanh nghiệp') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('SĐT zalo') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Người đại diện') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('SĐT') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Trạng thái') }}</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('Thao tác') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($members->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center">
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
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ $member->business_name ?? '-' }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ $member->business_code ?? '-' }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $member->phone_zalo ?? '-' }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ $member->representative_full_name ?? '-' }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ $member->representative_phone ?? '-' }}</p>
                                            </td>

                                            <td>
                                                <span id="status-badge-{{ $member->id }}"
                                                    class="badge badge-sm bg-{{ $member->status == 'approved' ? 'success' : ($member->status == 'rejected' ? 'danger' : 'warning') }}"
                                                    data-status="{{ $member->status }}">
                                                    {{ $member->status == 'approved' ? 'Đã duyệt' : ($member->status == 'rejected' ? 'Đã từ chối' : 'Đang chờ') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="menu">
                                                    <div class="dropstart d-block">
                                                        <button class="btn btn-sm p-0 border-0 mb-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false"
                                                            title="Thay đổi trạng thái">
                                                            <i class="fas fa-retweet"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item" href="#"
                                                                    onclick="updateStatus('BusinessMember', {{ $member->id }}, 'approved')">
                                                                    <i
                                                                        class="fas fa-check-circle text-success me-2"></i>Duyệt
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#"
                                                                    onclick="updateStatus('BusinessMember', {{ $member->id }}, 'rejected')">
                                                                    <i class="fas fa-times-circle text-danger me-2"></i>Từ
                                                                    chối
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#"
                                                                    onclick="updateStatus('BusinessMember', {{ $member->id }}, 'pending')">
                                                                    <i
                                                                        class="fa fa-hourglass-half text-warning me-2"></i>Đang
                                                                    chờ
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
                                                <a href="javascript:void(0)" class="mx-3 view-member"
                                                    data-id="{{ $member->id }}" title="{{ __('Xem chi tiết') }}">
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
                <div class="modal fade" id="memberDetailModal" tabindex="-1" aria-labelledby="memberDetailModalLabel"
                    aria-hidden="true">
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
                                                            <i
                                                                class="fas fa-building me-2"></i>{{ __('Tên doanh nghiệp') }}
                                                        </label>
                                                        <p id="modal-business-name" class="text-sm mb-2"></p>
                                                    </div>
                                                    <div class="info-group">
                                                        <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                            <i class="fas fa-industry me-2"></i> Mã doanh nghiệp
                                                        </label>
                                                        <p id="modal-business-code" class="text-sm mb-2"></p>
                                                    </div>

                                                    <div class="info-group">
                                                        <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                            <i class="fa-regular fa-building"></i> Ngành nghề kinh doanh
                                                        </label>
                                                        <p id="modal-business-field" class="text-sm mb-2"></p>
                                                    </div>

                                                    <div class="info-group">
                                                        <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                            <i
                                                                class="fas fa-map-marker-alt me-2"></i>{{ __('Địa chỉ kinh doanh') }}
                                                        </label>
                                                        <p id="modal-address" class="text-sm mb-2"></p>
                                                    </div>
                                                    <div class="info-group">
                                                        <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                            <i class="fas fa-envelope me-2"></i>{{ __('Email') }}
                                                        </label>
                                                        <p id="modal-email" class="text-sm mb-2"></p>
                                                    </div>
                                                    <div class="info-group">
                                                        <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                            <i
                                                                class="fas fa-phone me-2"></i>{{ __('Số điện thoại zalo') }}
                                                        </label>
                                                        <p id="modal-phone-zalo" class="text-sm mb-2"></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="info-group">
                                                        <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                            <i class="fas fa-user me-2"></i>{{ __('Người đại diện') }}
                                                        </label>
                                                        <p id="modal-representative-full-name" class="text-sm mb-2"></p>
                                                    </div>
                                                    <div class="info-group">
                                                        <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                            <i
                                                                class="fas fa-phone me-2"></i>{{ __('Số điện thoại liên hệ') }}
                                                        </label>
                                                        <p id="modal-representative-phone" class="text-sm mb-2"></p>
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
    <script type="text/javascript">
        $(function() {
            $('input[name="date_range"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Clear'
                }
            });

            $('input[name="date_range"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format(
                    'YYYY-MM-DD'));
            });

            $('input[name="date_range"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });

        function submitForm(action) {
            var form = document.getElementById('reportForm');
            form.action = action;
            form.submit();
        }
    </script>

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

                        $('#modal-business-name').text(response.business_name || '-');
                        $('#modal-business-code').text(response.business_code || '-');
                        $('#modal-address').text(response.address || '-');
                        $('#modal-email').text(response.email || '-');
                        $('#modal-phone-zalo').text(response.phone_zalo || '-');
                        $('#modal-business-field').text(response.business_field || '-');
                        $('#modal-representative-full-name').text(response
                            .representative_full_name || '-');
                        $('#modal-representative-phone').text(response.representative_phone ||
                            '-');
                        $('#modal-created-at').text(formattedDate || '-');

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

                        $('#memberDetailModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.log('Error: ' + error + '\n' + xhr.responseText);
                    },
                });
            });
        });
    </script>
    <script>
        $("#fileInput").change(function() {
            const fileNameDisplay = $("#fileName");
            const fileNameText = $("#fileNameText");
            const fileInput = $(this).prop("files")[0];

            if (fileInput) {
                fileNameDisplay.show();
                fileNameText.text(fileInput.name);
            } else {
                fileNameDisplay.hide();
                fileNameText.text("");
            }
        });

        $("#importForm").submit(function(e) {
            const fileInput = $("#fileInput").prop("files")[0];
            if (!fileInput) {
                e.preventDefault();
                alert("Vui lòng chọn một file trước khi tải lên.");
                return;
            }

            $("#progress-container").show();
            const progressBar = $("#progress-bar");
            let width = 0;
            const interval = setInterval(() => {
                if (width >= 100) {
                    clearInterval(interval);
                } else {
                    width += 10;
                    progressBar.css("width", width + "%");
                }
            }, 500);
        });
    </script>
@endpush
