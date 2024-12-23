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
                    <div class="mt-2">
                        <form method="GET" class="d-md-flex">
                            @if (request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">  
                            @endif
                            
                            <select name="search-member-id" class="form-select form-select-sm me-2 w-100 w-md-auto">
                                <option value="">Tất cả doanh nghiệp</option>
                                @foreach ($business_members as $item)
                                    <option value="{{ $item->id }}" {{ request('search-member-id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->business_name }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="search-status" class="form-select form-select-sm me-2 mt-2 mt-md-0">
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
                    @include('admin.pages.notification.success-error')
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('STT') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Tiêu đề</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Thông tin</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Doanh nghiệp</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Mã số thuế</th>
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
                                            <p class="text-xs font-weight-bold mb-0">{{ $recruitment->recruitment_title ?? '-'}}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {!! Str::limit(strip_tags($recruitment->recruitment_content), 200) !!}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $recruitment->businessMember->business_name ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $recruitment->businessMember->business_code ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <span id="status-badge-{{ $recruitment->id }}" data-status="{{ $recruitment->status }}"
                                                class="badge badge-sm bg-{{ $recruitment->status == 'approved' ? 'success' : ($recruitment->status == 'rejected' ? 'danger' : 'warning') }}">
                                                {{ $recruitment->status == 'approved' ? 'Đã duyệt' : ($recruitment->status == 'rejected' ? 'Đã từ chối' : 'Đang chờ') }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $images = json_decode($recruitment->recruitment_images, true);
                                            @endphp
                                            @if ($images)
                                                @foreach ($images as $image)
                                                    <a href="{{ asset($image) }}" data-fancybox="gallery-{{ $recruitment->id }}">
                                                        <img src="{{ asset($image) }}" alt="Recruitment Image" style="width: 50px; height: 50px; object-fit: cover;">
                                                    </a>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="text-center">

                                            <button class="btn btn-sm p-0 border-0 mb-0 view-recruitment"
                                                data-id="{{ $recruitment->id }}" title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <div class="dropstart">
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
                        <x-pagination :paginator="$businessRecruitments" />
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
                                            {{ __('Thông tin chi tiết tuyển dụng') }}
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
                                                    style="width: 150px; height: 150px; object-fit: scale-down;"
                                                    alt="Business Avatar">
                                            </div>
                                            <h6 id="modal-business-name" class="fw-bold text-primary"></h6>
                                            <p class="text-muted small">MST: <span id="modal-business-code"></span></p>
                                            
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-group">
                                                <h6 id="modal-recruitment-title" class="fw-bold text-primary"></h6>
                                                <p id="modal-recruitment-content" class="text-sm mb-2"></p>
                                            </div>
                                            <div id="modal-recruitment-images">
                                                <a href="" data-fancybox="gallery">
                                                    <img src="" alt="Recruitment Image" style="width: 50px; height: 50px; object-fit: cover;">
                                                </a>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script>
    $(document).ready(function() {
        $('.view-recruitment').click(function() {
            var recruitmentId = $(this).data('id');
            $.ajax({
                url: '/recruitment/' + recruitmentId,
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    
                    $('#modal-avatar').attr('src', response.avt_businesses || '');
                    $('#modal-business-name').text(response.business_name || '-');
                    $('#modal-business-code').text(response.business_code || '-');
                    
                    $('#modal-recruitment-title').text(response.recruitment_title|| '-');
                    $('#modal-recruitment-content').html(response.recruitment_content || '-');

                    if (response.recruitment_images) {
                        $('#modal-recruitment-images').empty();
                        response.recruitment_images.forEach(function(image) {
                            $('#modal-recruitment-images').append(
                                '<a href="' + image + '" data-fancybox="gallery"><img src="' + image + '" alt="Recruitment Image" style="width: 50px; height: 50px; object-fit: cover;"></a>'
                            );
                        });
                    }
                  
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
                },
                error: function(error) {
                   
                    showToast(error.responseJSON.message, 'error');
                }
            });
        });
    });
</script>
@endpush
