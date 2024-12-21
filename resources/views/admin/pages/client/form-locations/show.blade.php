@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        .img-product {
            height: 100px !important;
            object-fit: scale-down;
        }

        p {
            margin-bottom: 0.5rem;
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
                        <h5 class="mb-0">Chi tiết địa điểm: {{ $location->name }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body px-4 pb-2">
                <div class="row">
                    <div class="col-md-6">
                        <img class="rounded-circle" width="200" height="200" src="{{ isset($location->businessMember->business) ? asset($location->businessMember->business->avt_businesses) : asset('images/business/business_default.webp') }}" alt="avatar">
                        @if (isset($location->district->name))
                            <p><strong>Khu phố:</strong> {{ $location->district->name }}</p>
                        @endif
                        @if (isset($location->businessMember->business_name))
                            <p><strong>Doanh nghiệp:</strong> {{ $location->businessMember->business_name }}</p>
                        @endif
                        @if (isset($location->businessMember->business_code))
                            <p><strong>Mã số thuế:</strong> {{ $location->businessMember->business_code ?? '-' }}</p>
                        @endif
                        <p><strong>Tên địa điểm:</strong> {{ $location->name }}</p>
                        <p><strong>Địa chỉ:</strong> {{ $location->address_address }}</p>
                        <p><strong>Vĩ độ:</strong> {{ $location->address_latitude }}</p>
                        <p><strong>Kinh độ:</strong> {{ $location->address_longitude }}</p>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $location->address_latitude }},{{ $location->address_longitude }}" target="_blank" class="btn btn-primary mb-3">Xem trên Google Maps</a>
                        <p><strong>Ngành nghề:</strong> {{ $location->businessField->name }}</p>
                        @if (isset($location->businessMember->representative_full_name))
                            <p><strong>Đại diện:</strong> {{ $location->businessMember->representative_full_name ?? '-' }}</p>
                        @endif
                        <p><strong>Mô tả:</strong> {!! $location->description !!}</p>
                        <p><strong>Trạng thái:</strong>
                            @if ($location->status == 'pending')
                                <span class="badge bg-warning">Đang chờ</span>
                            @elseif ($location->status == 'approved')
                                <span class="badge bg-success">Đã duyệt</span>
                            @else
                                <span class="badge bg-danger">Đã từ chối</span>
                            @endif
                        </p>
                        @if ($location->link_video)
                            <p><strong>Video:</strong> <a href="{{ $location->link_video }}" class="text-primary" target="_blank">Xem video</a></p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6>Hình ảnh địa điểm</h6>
                        @foreach ($location->locationProducts as $product)
                            <img src="{{ asset($product->file_path) }}" class="img-fluid img-product mb-2" alt="Location Image">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts-admin')
@endpush
