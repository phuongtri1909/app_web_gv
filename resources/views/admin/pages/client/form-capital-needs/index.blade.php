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
                            <h5 class="mb-0">{{ __('Danh sách đăng ký nhu cầu vay vốn') }}</h5>
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
                                        {{ __('Mã số thuế') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Số vốn') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Chu kỳ vay') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Lãi suất') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Mục đích vay') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Ngân hàng') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Đề xuất chính sách') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('Ý kiến') }}</th>
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
                                                {{ $capitalNeed->businessMember->business_name ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $capitalNeed->businessMember->business_code ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ format_currency_vnd($capitalNeed->finance) }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $capitalNeed->loan_cycle }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ number_format($capitalNeed->interest_rate, 1, ',', '.') }}%
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $capitalNeed->purpose }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $capitalNeed->bank_connection }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $capitalNeed->support_policy }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $capitalNeed->feedback }}
                                            </p>
                                        </td>
                                        <td class="text-center">                                  
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $capitalNeed->id,
                                                'route' => route('capital-needs.destroy', $capitalNeed->id),
                                                'message' => __('delete_message'),
                                            ])
                                            <a href="javascript:void(0)" class="mx-3 view-capitalNeed"
                                                data-id="{{ $capitalNeed->id }}" title="{{ __('Xem chi tiết') }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="javascript:void(0)" 
                                                class="{{ $capitalNeed->email_status === 'sent' ? 'btn-light' : ' send-email' }}" 
                                                data-id="{{ $capitalNeed->id }}" 
                                                title="{{ $capitalNeed->email_status === 'sent' ? 'Đã gửi email' : 'Gửi email' }}" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top">
                                                    <i class="{{ $capitalNeed->email_status === 'sent' ? 'fas fa-check-circle text-success' : 'fas fa-paper-plane text-gray' }}"></i>
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
                                        Thông tin chi tiết nhu cầu vốn
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
                                    </div>

                                    <div class="col-md-8">
                                        <div class="row g-3">
                                            <div class="col-md-6">

                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder">
                                                        <i class="fas fa-money-bill me-2"></i>Số vốn đăng ký
                                                    </label>
                                                    <p id="modal-finance" class="text-sm mb-2"></p>
                                                </div>

                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder">
                                                        <i class="fas fa-rotate-right me-2"></i>Chu kỳ vay
                                                    </label>
                                                    <p id="model-loan-cycle" class="text-sm mb-2"></p>
                                                </div>

                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder">
                                                        <i class="fas fa-percentage me-2"></i>Đề xuất lãi xuất
                                                    </label>
                                                    <p id="modal-interest-rate" class="text-sm mb-2"></p>
                                                </div>

                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder">
                                                        <i class="fas fa-bullseye me-2"></i>{{ __('Mục đích vay') }}
                                                    </label>
                                                    <p id="modal-purpose" class="text-sm mb-2"></p>
                                                </div>

                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder">
                                                        <i class="fas fa-clock me-2"></i>{{ __('Ngày đăng ký') }}
                                                    </label>
                                                    <p id="modal-created-at" class="text-sm mb-2"></p>
                                                </div>


                                            </div>
                                            <div class="col-md-6">

                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder">
                                                        <i
                                                            class="fas fa-university me-2"></i>Đề xuất kết nối ngân hàng
                                                    </label>
                                                    <p id="modal-bank-connection" class="text-sm mb-2"></p>
                                                </div>

                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder">
                                                        <i
                                                            class="fas fa-handshake me-2"></i>Đề xuất chính sách hỗ trợ
                                                    </label>
                                                    <p id="modal-support-policy" class="text-sm mb-2"></p>
                                                </div>

                                                <div class="info-group">
                                                    <label class="text-uppercase text-xs font-weight-bolder">
                                                        <i class="fas fa-comments me-2"></i>ý kiến đối với ngân hàng
                                                    </label>
                                                    <p id="modal-feedback" class="text-sm mb-2"></p>
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
            <!-- Form Gửi Email -->
            <div class="modal fade" id="sendEmailModal" tabindex="-1" aria-labelledby="sendEmailModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="sendEmailModalLabel">Gửi Email</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="sendEmailForm" action="{{ route('capital-needs.send-email') }}" method="POST">
                            @csrf
                            <input type="hidden" name="capital_need_id" id="capitalNeedId">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Ngân Hàng</label>
                                    <select class="form-select" id="email" name="email" required>
                                        <option value="">Chọn Email</option>
                                        @foreach ($emails as $email)
                                            <option value="{{ $email->email }}">{{ $email->email }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="email_template" class="form-label">Chọn Mẫu Email</label>
                                    <select class="form-select" id="email_template" name="email_template" required>
                                        <option value="">Chọn Mẫu</option>
                                        @foreach ($emailTemplates as $template)
                                            <option value="{{ $template->id }}">{{ $template->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-primary">Gửi</button>
                            </div>
                        </form>
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

                        $('#modal-purpose').text(response.purpose || '-');
                        $('#modal-bank-connection').text(response.bank_connection || '-');
                        $('#modal-feedback').text(response.feedback || '-');
                        $('#modal-created-at').text(formattedDate);
                        $('#modal-avatar').attr('src', response.avt_businesses ? '/' + response.avt_businesses : '');
                        $('#model-loan-cycle').text(response.loan_cycle || '-');
                        $('#modal-support-policy').text(response.support_policy || '-');

                        $('#capitalNeedDetailModal').modal('show');
                    },
                    error: function(error) {
                        showToast(error.responseJSON.error, 'error');
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('[data-bs-toggle="tooltip"]').tooltip();

            $('.send-email').on('click', function () {
                var capitalNeedId = $(this).data('id');
                $('#capitalNeedId').val(capitalNeedId);

                var modal = new bootstrap.Modal($('#sendEmailModal'));
                modal.show();
            });

            $('#sendEmailForm').on('submit', function (e) {
                e.preventDefault();

                var submitButton = $(this).find('button[type=submit]');
                submitButton.attr('disabled', true).text('Đang gửi...');

                var form = $(this);
                var actionUrl = form.attr('action');
                var formData = form.serialize();

                $.ajax({
                    url: actionUrl,
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            showToast(response.message, 'success');
                            var row = $('.send-email[data-id="' + $('#capitalNeedId').val() + '"]').closest('tr');
                            
                            row.find('.badge')
                                .removeClass('bg-warning')
                                .addClass('bg-success')
                                .text('Đã gửi');

                            var sendButton = row.find('.send-email');
                            sendButton.removeClass('send-email')
                                .addClass('btn-light disabled')
                                .attr('title', 'Đã gửi email')
                                .tooltip('dispose') 
                                .tooltip(); 
                            sendButton.html('<i class="fas fa-check-circle text-success"></i>');    
                            var modal = bootstrap.Modal.getInstance($('#sendEmailModal'));
                            modal.hide();
                            form.trigger('reset');
                        } else {
                            showToast('Lỗi gửi email: ' + response.error, 'error');
                        }
                        submitButton.attr('disabled', false).text('Gửi');
                    },
                    error: function (error) {
                        showToast('Đã xảy ra lỗi khi gửi email: ' + error.statusText, 'error');
                        submitButton.attr('disabled', false).text('Gửi');
                    }
                });
            });
        });
    </script>
@endpush
