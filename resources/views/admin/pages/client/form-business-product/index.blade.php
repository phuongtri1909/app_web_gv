
@extends('admin.layouts.app')

@push('styles-admin')
    <style>
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

        .img-product {
            height: 100px !important;
            object-fit: scale-down
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
                        <h5 class="mb-0">Kết nối cung cầu</h5>
                    </div>
                </div>
                <div class="mt-2">
                    <form method="GET" class="d-md-flex">
                        @if (request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">  
                        @endif
                        <select name="search-category" class="form-control-sm me-2">
                            <option value="">Tất cả danh mục</option>
                            @foreach ($category_products as $item)
                                <option value="{{ $item->id }}" {{ request('search-category') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        <select name="search-member-id" class="form-control-sm me-2">
                            <option value="">Tất cả doanh nghiệp</option>
                            @foreach ($business_members as $item)
                                <option value="{{ $item->id }}" {{ request('search-member-id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->business_name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm mb-0 mt-2 mt-md-0">Tìm kiếm</button>
                    </form>
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tên sản phẩm</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Giá</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Danh mục</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Doanh nghiệp</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Trạng thái</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($products->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ __('Không có kết quả nào.') }}</p>
                                    </td>
                                </tr>
                            @else
                                @foreach ($products as $key => $item)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <img src="{{ asset($item->product_avatar) }}" alt="" class="img-fluid img-product" width="100" height="100">
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 text-truncate-2">{{ $item->name_product ?? '-' }}</p>
                                        </td>

                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ number_format($item->price) ?? '-' }} VNĐ</p>
                                            <hr>
                                            <p class="text-xs font-weight-bold mb-0">Thành viên:{{ number_format($item->price_member) ?? '-' }} VNĐ</p>
                                        </td>

                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->categoryProduct->name ?? '-' }}</p>
                                        </td>
                                       
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->businessMember->business_name ?? '-' }}</p>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->businessMember->business_code ?? '-' }}</p>
                                        </td>
                
                                        <td>
                                            <span id="status-badge-{{ $item->id }}"
                                                class="badge badge-sm bg-{{ $item->status == 'approved' ? 'success' : ($item->status == 'rejected' ? 'danger' : 'warning') }}"  data-status="{{ $item->status }}">
                                                {{ $item->status == 'approved' ? 'Đã duyệt' : ($item->status == 'rejected' ? 'Đã từ chối' : 'Đang chờ') }}
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
                                                                onclick="updateStatus('ProductBusiness', {{ $item->id }}, 'approved')">
                                                                <i class="fas fa-check-circle text-success me-2"></i>Duyệt
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#"
                                                                onclick="updateStatus('ProductBusiness', {{ $item->id }}, 'rejected')">
                                                                <i class="fas fa-times-circle text-danger me-2"></i>Từ chối
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#"
                                                                onclick="updateStatus('ProductBusiness', {{ $item->id }}, 'pending')">
                                                                <i class="fa fa-hourglass-half text-warning me-2"></i>Đang chờ
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            @include('admin.pages.components.delete-form', [
                                                'id' => $item->id,
                                                'route' => route('business.products.destroy', $item->id),
                                                'message' => __('Bạn có chắc chắn muốn xóa sản phẩm này không?'),
                                            ])
                                            <a href="{{ route('business.products.show',$item->id) }}" class="mx-3 view-business" data-id="{{ $item->id }}" title="{{ __('Xem chi tiết') }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <x-pagination :paginator="$products" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts-admin')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  
@endpush
