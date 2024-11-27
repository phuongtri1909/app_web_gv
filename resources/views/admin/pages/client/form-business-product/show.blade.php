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
                        <h5 class="mb-0">Chi tiết sản phẩm: {{ $product->name_product }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body px-4 pb-2">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Tên sản phẩm:</strong> {{ $product->name_product }}</p>
                        <p><strong>Giá:</strong> {{ number_format($product->price, 0, ',', '.') }} ₫</p>
                        <p><strong>Giá thành viên:</strong> {{ number_format($product->price_member, 0, ',', '.') }} ₫</p>
                        <p><strong>Danh mục:</strong> {{ $product->categoryProduct->name }}</p>
                        <p><strong>Doanh nghiệp:</strong> {{ $product->businessMember->business_name }}</p>
                        <p><strong>Mã số thuế</strong> {{ $product->businessMember->business_code }}</p>
                        <p><strong>Đại diện:</strong> {{ $product->businessMember->representative_full_name }}</p>
                        <p><strong>Mô tả:</strong> {{ $product->description }}</p>

                        <p><strong>Trạng thái </strong>
                            @if ($product->status == 'pending')
                                <span class="badge bg-warning">Đang chờ</span>
                            @elseif ($product->status == 'approved')
                                <span class="badge bg-success">Đã duyệt</span>
                            @else
                                <span class="badge bg-danger">Đã từ chối</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6>Ảnh đại diện</h6>

                        <img src="{{ asset($product->product_avatar) }}" class="img-fluid img-product mb-2" alt="Product Avatar">


                        <h6>Hình ảnh sản phẩm</h6>
                        <img src="{{ asset($product->product_avatar) }}" class="img-fluid img-product mb-2" alt="Product Avatar">
                        @foreach ($product->productImages as $image)
                            <img src="{{ asset($image->image) }}" class="img-fluid img-product mb-2" alt="Product Image">
                        @endforeach
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <h6>Các giấy tờ xác nhận liên quan</h6>
                        @php
                            $relatedDocuments = json_decode($product->related_confirmation_document, true);
                        @endphp
                        @if (!empty($relatedDocuments))
                            @foreach ($relatedDocuments as $document)
                                <a href="{{ asset($document) }}" target="_blank" class="btn btn-sm btn-outline-primary me-2">Xem văn bản liên quan</a>
                            @endforeach
                        @else
                            <p>Không có giấy tờ xác nhận liên quan.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts-admin')
@endpush