
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
    </style>
@endpush

@section('content-auth')
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">{{ __('Danh sách doanh nghiệp') }}</h5>
                    </div>
                    <a href="{{ route('businesses.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button">
                        <i class="fa-solid fa-plus"></i> {{ __('Thêm mới') }}
                    </a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                @include('admin.pages.notification.success-error')

                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('STT') }}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    {{ __('Tên doanh nghiệp') }}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    {{ __('Ảnh đại diện') }}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    {{ __('Mã số thuế') }}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    {{ __('Email') }}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    {{ __('Số điện thoại') }}
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('Thao tác') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($businesses as $key => $business)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $business->business_name }}</p>
                                    </td>
                                    <td>
                                        @if (!empty($business->avt_businesses))
                                            <div>
                                                <img src="{{ asset($business->avt_businesses) }}" class="img-fluid img-square" alt="Business Image">
                                            </div>
                                        @else
                                            <p class="text-xs font-weight-bold mb-0">{{ __('no_image') }}</p>
                                        @endif
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $business->business_code }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $business->email }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $business->phone_number }}</p>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('businesses.edit', $business->id) }}" class="mx-3" title="{{ __('edit') }}">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="businessDetailModal" tabindex="-1" aria-labelledby="businessDetailModalLabel" aria-hidden="true">
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
                                </div>
                                
                                <div class="col-md-8">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-user me-2"></i>{{ __('Người đại diện') }}
                                                </label>
                                                <p id="modal-representative-name" class="text-sm mb-2"></p>
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
                                                    <i class="fas fa-envelope me-2"></i>{{ __('Email') }}
                                                </label>
                                                <p id="modal-email" class="text-sm mb-2"></p>
                                            </div>
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-phone me-2"></i>{{ __('Số điện thoại') }}
                                                </label>
                                                <p id="modal-phone" class="text-sm mb-2"></p>
                                            </div>
                                            <div class="info-group">
                                                <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                    <i class="fas fa-share-alt me-2"></i>{{ __('Kênh social') }}
                                                </label>
                                                <p id="modal-social" class="text-sm mb-2"></p>
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="mt-4">
                                        <div class="info-group">
                                            <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                <i class="fas fa-map-marker-alt me-2"></i>{{ __('Địa chỉ') }}
                                            </label>
                                            <p id="modal-address" class="text-sm mb-2"></p>
                                        </div>
                                        <div class="info-group">
                                            <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                <i class="fas fa-building me-2"></i>{{ __('Địa chỉ kinh doanh') }}
                                            </label>
                                            <p id="modal-business-address" class="text-sm mb-2"></p>
                                        </div>
                                        <div class="info-group">
                                            <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                                <i class="fas fa-map me-2"></i>{{ __('Phường') }}
                                            </label>
                                            <p id="modal-ward" class="text-sm mb-2"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="info-group">
                                        <label class="text-uppercase text-xs font-weight-bolder opacity-7">
                                            <i class="fas fa-align-left me-2"></i>{{ __('Mô tả') }}
                                        </label>
                                        <p id="modal-description" class="text-sm mb-2"></p>
                                    </div>
                                </div>
                            </div>
        
                            <div class="row mt-4">
                                <div class="col-12">
                                    <a id="modal-license" href="" target="_blank" class="btn btn-primary">
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
@endsection
@push('scripts-admin')
<script>
    $(document).ready(function() {
        $('.view-business').click(function() {
            var businessId = $(this).data('id');
            $.ajax({
                url: '/admin/businesses/' + businessId,
                type: 'GET',
                success: function(response) {
                    $('#modal-business-name').text(response.business_name);
                    $('#modal-business-code').text(response.business_code);
                    $('#modal-representative-name').text(response.representative_name);
                    $('#modal-birth-year').text(response.birth_year);
                    $('#modal-gender').text(response.gender);
                    $('#modal-email').text(response.email);
                    $('#modal-phone').text(response.phone_number);
                    $('#modal-address').text(response.address);
                    $('#modal-business-address').text(response.business_address);
                    $('#modal-ward').text(response.ward.name);
                    $('#modal-social').text(response.social_channel || 'N/A');
                    $('#modal-description').text(response.description || 'N/A');
                    $('#modal-avatar').attr('src', response.avt_businesses ? '/' + response.avt_businesses : '');
                    $('#modal-license').attr('href', response.business_license ? '/' + response.business_license : '#');
                    
                    $('#businessDetailModal').modal('show');
                }
            });
        });
    });
    </script>
@endpush
