@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Danh sách quảng cáo</h5>
                        </div>
                        {{-- <div>
                            <a href="{{ route('advertisements.create') }}" class="btn bg-gradient-primary">Thêm mới</a>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('STT') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Tiêu đề</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Loại</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Danh mục</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Đường</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Trạng thái</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('Thao tác') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ads as $key => $ad)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $ad->ad_title }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $ad->type->name ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $ad->category->name ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $ad->road->name ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <span id="status-badge-{{ $ad->id }}"
                                                class="badge badge-sm bg-{{ $ad->ad_status == 'active' ? 'success' : ($ad->ad_status == 'inactive' ? 'danger' : 'warning') }}"
                                                data-status="{{ $ad->ad_status }}">
                                                {{ $ad->ad_status == 'active' ? 'Hiển thị' : ($ad->ad_status == 'inactive' ? 'Không hiển thị' : 'Đang chờ duyệt') }}
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
                                                            onclick="updateStatus2('Advertisement', {{ $ad->id }}, 'active')">
                                                            <i class="fas fa-check-circle text-success me-2"></i>Hiển thị
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="updateStatus2('Advertisement', {{ $ad->id }}, 'inactive')">
                                                            <i class="fas fa-times-circle text-danger me-2"></i>Không hiển
                                                            thị
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="updateStatus2('Advertisement', {{ $ad->id }}, 'pending')">
                                                            <i class="fa fa-hourglass-half text-warning me-2"></i>Đang chờ
                                                            duyệt
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            {{-- <a href="{{ route('advertisements.edit', $ad->id) }}">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a> --}}
                                            <a href="javascript:void(0)" class="mx-3 view-adve"
                                                data-id="{{ $ad->id }}" title="{{ __('Xem chi tiết') }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $ad->id,
                                                'route' => route('advertisements.destroy', $ad->id),
                                                'message' => __('Bạn có chắc chắn muốn xóa?'),
                                            ])
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <x-pagination :paginator="$ads" />
                    </div>
                </div>
                <div class="modal fade" id="advertisementDetailModal" tabindex="-1"
                    aria-labelledby="advertisementDetailModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="card shadow-lg">
                                <div class="card-header bg-gradient-primary p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="text-white mb-0">
                                            <i class="fas fa-ad me-2"></i>
                                            {{ __('Thông tin chi tiết Quảng Cáo') }}
                                        </h5>
                                        <button type="button" class="btn btn-link text-white" data-bs-dismiss="modal">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <div class="row g-4">
                                        <div class="col-12 text-center">
                                            <h6 id="modal-ad-title" class="fw-bold text-primary"></h6>
                                            <span id="modal-ad-status" class="badge badge-sm"></span>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-user me-2"></i>{{ __('Người đăng') }}
                                                </label>
                                                <p id="modal-ad-full-name" class="text-sm mb-2"></p>
                                            </div>
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-phone me-2"></i>{{ __('Số điện thoại') }}
                                                </label>
                                                <p id="modal-ad-contact-phone" class="text-sm mb-2"></p>
                                            </div>
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-id-card me-2"></i>{{ __('CCCD') }}
                                                </label>
                                                <p id="modal-ad-cccd" class="text-sm mb-2"></p>
                                            </div>
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-money-bill-wave me-2"></i>{{ __('Giá') }}
                                                </label>
                                                <p id="modal-ad-price" class="text-sm mb-2"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-tags me-2"></i>{{ __('Danh mục') }}
                                                </label>
                                                <p id="modal-category-name" class="text-sm mb-2"></p>
                                            </div>
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-list-alt me-2"></i>{{ __('Loại hình') }}
                                                </label>
                                                <p id="modal-type-name" class="text-sm mb-2"></p>
                                            </div>
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-road me-2"></i>{{ __('Khu vực') }}
                                                </label>
                                                <p id="modal-road-name" class="text-sm mb-2"></p>
                                            </div>
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-clock me-2"></i>{{ __('Ngày đăng ký') }}
                                                </label>
                                                <p id="modal-created-at" class="text-sm mb-2"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">

                                        <div class="col-12">
                                            <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                <i class="fas fa-file-alt me-2"></i>{{ __('Mô tả') }}
                                            </label>
                                            <p id="modal-ad-description" class="text-sm mb-2"></p>
                                        </div>
                                        <div class="info-group">
                                            <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                <i class="fas fa-image me-2"></i>{{ __('Hình ảnh') }}
                                            </label>
                                            <p id="modal-images" class="text-sm mb-2"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="viewImageModal" tabindex="-1" aria-labelledby="viewImageModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewImageModalLabel">Xem Hình Ảnh</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img id="modal-large-image" src="" alt="Large Image" class="img-fluid">
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
            $('.view-adve').click(function() {
                var adsId = $(this).data('id');
                $.ajax({
                    url: '/admin/advertisements/' + adsId,
                    type: 'GET',
                    success: function(response) {
                        var formattedDate = dayjs(response.created_at).format(
                            'DD/MM/YYYY HH:mm');
                        $('#modal-ad-title').text(response.ad_title || '-');
                        $('#modal-ad-description').html(response.ad_description || '-');
                        $('#modal-ad-price').text(response.ad_price + 'đ' || '-');
                        $('#modal-ad-full-name').text(response.ad_full_name || '-');
                        $('#modal-ad-cccd').text(response.ad_cccd || '-');
                        $('#modal-ad-contact-phone').text(response.ad_contact_phone || '-');
                        $('#modal-category-name').text(response.category_name || '-');
                        var productImagesHtml = '';
                        if (response.files && response.files.length > 0) {
                            response.files.forEach(function(file) {
                                productImagesHtml += '<img src="/' + file.file_url +
                                    '" alt="Product Image" class="img-fluid product-thumbnail" style="max-width: 100px; margin: 5px;">';
                            });
                        } else {
                            productImagesHtml = '-';
                        }
                        $('#modal-images').html(productImagesHtml);

                        $('#modal-type-name').text(response.type_name || '-');
                        $('#modal-created-at').text(formattedDate || '-');
                        $('#modal-road-name').text(response.road_name || '-');
                        const statusBadgeClass = {
                            'active': 'bg-success',
                            'inactive': 'bg-danger',
                            'pending': 'bg-warning'
                        } [response.ad_status] || 'bg-secondary';
                        const statusText = {
                            'active': 'Hiển thị',
                            'inactive': 'Không hiển thị',
                            'pending': 'Đang chờ'
                        } [response.ad_status] || '-';

                        $('#modal-ad-status')
                            .removeClass('bg-success bg-danger bg-warning bg-secondary')
                            .addClass(statusBadgeClass)
                            .text(statusText);


                        $('#advertisementDetailModal').modal('show');
                    },
                    error: function(error) {
                        console.log(error);

                        showToast('Có lỗi xảy ra. Vui lòng thử lại sau.', 'error');
                    }
                });
            });
            $(document).on('click', '.product-thumbnail', function() {
                var imageUrl = $(this).attr('src');
                $('#modal-large-image').attr('src', imageUrl);
                $('#viewImageModal').modal('show');
            });
            $(document).on('click', '.product-thumbnail1', function() {
                var imageUrl = $(this).attr('src');
                $('#modal-large-image').attr('src', imageUrl);
                $('#viewImageModal').modal('show');
            });
        });
    </script>
@endpush
