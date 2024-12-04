@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        .avatar-business {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: scale-down
        }

        p {
            margin: 0;
        }
    </style>
@endpush
@section('content-auth')
    <section>
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row align-items-center align-items-md-end">
                    <div class="text-center d-flex flex-column align-items-center">
                        <img src="{{ isset($business_member->business) ? asset($business_member->business->avt_businesses) : asset('images/business/business_default.webp') }}"
                            alt="avatar" class="avatar-business border">
                        <div class="mt-2">

                            @if (isset($business_member->business))
                                @if ($business_member->business->status == 'pending')
                                    <span class="badge bg-warning">Đang chờ</span>
                                @elseif ($business_member->business->status == 'approved')
                                    <span class="badge bg-success">Đã duyệt</span>
                                @else
                                    <span class="badge bg-danger">Đã từ chối</span>
                                @endif
                            @else
                                <a href="{{ route('business.index') }}" class="badge bg-secondary">Kết nối giao thương</a>
                            @endif
                        </div>
                    </div>
                    <div class="ms-4 mt-3 text-center">
                        <p class="mb-0 fw-bold"> {{ $business_member->business_name }}</p>
                        <p><strong>Mã số thuế:</strong> {{ $business_member->business_code }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="row mt-3 gx-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Thông tin doanh nghiệp</h5>
                            <p class="card-text"><strong>Địa chỉ:</strong> {{ $business_member->address }}</p>
                            <p class="card-text"><strong>Số điện thoại:</strong> {{ $business_member->phone_zalo }}</p>
                            <p class="card-text"><strong>Email:</strong> {{ $business_member->email }}</p>
                            <p class="card-text"><strong>Website:</strong> <a class="text-primary"
                                    href="{{ $business_member->link }}">Truy cập</a></p>
                            <p class="card-text"><strong>Lĩnh vực kinh doanh:</strong>
                                @if ($businessFields->isNotEmpty())
                                    <ul>
                                        @foreach ($businessFields as $field)
                                            <li>{{ $field->name }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span>Không có lĩnh vực kinh doanh</span>
                                @endif
                            </p>
                            <p class="card-text"><strong>Ngày đăng ký:</strong> {{ $business_member->created_at }}</p>

                        </div>
                    </div>
                </div>

                <div class="col-md-6 mt-3 mt-md-0">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Thông tin người đại diện</h5>
                            <p class="card-text"><strong>Họ và tên:</strong> {{ $business_member->representative_full_name }}</p>
                            <p class="card-text"><strong>Số điện thoại:</strong> {{ $business_member->representative_phone }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tài khoản</h5>
                            <p class="card-text"><strong>tên tài khoản:</strong> {{auth()->user()->full_name }}</p>
                            <p class="card-text"><strong>Tên đăng nhập:</strong> {{ $business_member->business_code }}</p>
                            <p class="card-text"><strong>Mật khẩu:</strong> ********</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts-admin')
    <script></script>
@endpush
