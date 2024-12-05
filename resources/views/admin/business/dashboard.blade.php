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
                        <img src="{{ isset($business_member->business) && $business_member->business->status == 'approved' ? asset($business_member->business->avt_businesses) : asset('images/business/business_default.webp') }}"
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
                    <div class="d-flex flex-column flex-md-row align-items-center align-items-md-end">
                        <div class="ms-0 ms-md-4 mt-3 text-center">
                            <p class="mb-0 fw-bold"> {{ $business_member->business_name }}</p>
                            <p><strong>Mã số thuế:</strong> {{ $business_member->business_code }}</p>
                        </div>
                        @if ($business_member->business && $business_member->business->status == 'approved')
                            <div class="ms-0 ms-md-4">
                                <Strong>Giới thiệu:</Strong>
                                <p>{{ $business_member->business->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-2">
                    <button type="button" class="btn btn-primary mb-0 btn-sm p-2" data-bs-toggle="modal"
                        data-bs-target="#editModal">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade @if (session('modal') == 'editModal') show @endif" id="editModal" tabindex="-1"
            aria-labelledby="editModalLabel" aria-hidden="true"
            @if (session('modal') == 'editModal') style="display: block;" @endif>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Chỉnh sửa thông tin doanh nghiệp</h5>
                        <button type="button" class="btn-close text-primary" data-bs-dismiss="modal" aria-label="Close"><i
                                class="fa-regular fa-circle-xmark"></i></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('update.business') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @if ($business_member->business && $business_member->business->status == 'approved')
                                <div class="mb-3">
                                    <label for="avt_businesses" class="form-label">Ảnh đại diện</label>
                                    <input type="file" class="form-control @error('avt_businesses') is-invalid @enderror"
                                        id="avt_businesses" name="avt_businesses">
                                    @error('avt_businesses')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div id="preview" class="mb-3">
                                    <img src="{{ isset($business_member->business) && $business_member->business->status == 'approved' ? asset($business_member->business->avt_businesses) : asset('images/business/business_default.webp') }}"
                                        alt="avt_businesses" class="avatar-business border">
                                </div>
                            @endif
                            <div class="mb-3">
                                <label for="business_name" class="form-label">Tên doanh nghiệp</label>
                                <input required type="text"
                                    class="form-control @error('business_name') is-invalid @enderror" id="business_name"
                                    name="business_name"
                                    value="{{ old('business_name', $business_member->business_name) }}">
                                @error('business_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @if ($business_member->business && $business_member->business->status == 'approved')
                                <div class="mb-3">
                                    <label for="description" class="form-label">Giới thiệu</label>
                                    <textarea required class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        rows="3">{{ old('description', $business_member->business->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if (session('modal') == 'editModal')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var myModal = new bootstrap.Modal(document.getElementById('editModal'), {
                        backdrop: 'static',
                        keyboard: false
                    });
                    myModal.show();
                });
            </script>
        @endif

        <div>
            <div class="row mt-3 gx-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <h5 class="card-title">Thông tin doanh nghiệp</h5>
                                <p class="card-text"><strong>Địa chỉ:</strong> {{ $business_member->address }}</p>
                                <p class="card-text"><strong>Số điện thoại:</strong> {{ $business_member->phone_zalo }}</p>
                                <p class="card-text"><strong>Email:</strong> {{ $business_member->email }}</p>

                                <p class="card-text"><strong>Website:</strong>
                                    @if ($business_member->link)
                                        <a class="text-primary" href="{{ $business_member->link }}">Truy cập</a>
                                    @endif
                                </p>

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
                            <div class="d-flex justify-content-end mt-2">
                                <button type="button" class="btn btn-primary mb-0 btn-sm p-2" data-bs-toggle="modal"
                                    data-bs-target="#editBusinessInfoModal">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mt-3 mt-md-0">
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <h5 class="card-title">Thông tin người đại diện</h5>
                                <p class="card-text"><strong>Họ và tên:</strong>
                                    {{ $business_member->representative_full_name }}</p>
                                <p class="card-text"><strong>Số điện thoại:</strong>
                                    {{ $business_member->representative_phone }}</p>
                            </div>
                            <div class="d-flex justify-content-end mt-2">
                                <button type="button" class="btn btn-primary mb-0 btn-sm p-2" data-bs-toggle="modal"
                                    data-bs-target="#editRepresentativeInfoModal">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <h5 class="card-title">Tài khoản</h5>
                                <p class="card-text"><strong>Tên tài khoản:</strong> {{ auth()->user()->full_name }}</p>
                                <p class="card-text"><strong>Tên đăng nhập:</strong> {{ $business_member->business_code }}
                                </p>
                                <p class="card-text"><strong>Mật khẩu:</strong> ********</p>
                            </div>
                            <div class="d-flex justify-content-end mt-2">
                                <button type="button" class="btn btn-primary mb-0 btn-sm p-2" data-bs-toggle="modal"
                                    data-bs-target="#editAccountInfoModal">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Edit Business Info Modal -->
        <div class="modal fade @if (session('modal') == 'editBusinessInfoModal') show @endif" id="editBusinessInfoModal" tabindex="-1"
            aria-labelledby="editBusinessInfoModalLabel" aria-hidden="true"
            @if (session('modal') == 'editBusinessInfoModal') style="display: block;" @endif>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editBusinessInfoModalLabel">Chỉnh sửa thông tin doanh nghiệp</h5>
                        <button type="button" class="btn-close text-primary" data-bs-dismiss="modal"
                            aria-label="Close"><i class="fa-regular fa-circle-xmark"></i></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('update.business.member') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <input required type="text" class="form-control @error('address') is-invalid @enderror"
                                    id="address" name="address"
                                    value="{{ old('address', $business_member->address) }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phone_zalo" class="form-label">Số điện thoại</label>
                                <input required type="text"
                                    class="form-control @error('phone_zalo') is-invalid @enderror" id="phone_zalo"
                                    name="phone_zalo" value="{{ old('phone_zalo', $business_member->phone_zalo) }}">
                                @error('phone_zalo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $business_member->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="link" class="form-label">Website</label>
                                <input type="text" class="form-control @error('link') is-invalid @enderror"
                                    id="link" name="link" value="{{ old('link', $business_member->link) }}">
                                @error('link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="business_field_id" class="form-label">Ngành nghề kinh doanh <span
                                        class="text-danger">*</span></label>
                                <select required id="business_field_id" name="business_field_id[]"
                                    class="form-select form-select-sm @error('business_field_id') is-invalid @enderror"
                                    multiple>
                                    @foreach ($business_fields as $field)
                                        <option value="{{ $field->id }}"
                                            {{ in_array($field->id, old('business_field_id', json_decode($business_member->business_field_id ?? '[]', true))) ? 'selected' : '' }}>
                                            {{ $field->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('business_field_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if (session('modal') == 'editBusinessInfoModal')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var myModal = new bootstrap.Modal(document.getElementById('editBusinessInfoModal'), {
                        backdrop: 'static',
                        keyboard: false
                    });
                    myModal.show();
                });
            </script>
        @endif

        <!-- Edit Representative Info Modal -->
        <div class="modal fade @if (session('modal') == 'editRepresentativeInfoModal') show @endif" id="editRepresentativeInfoModal"
            tabindex="-1" aria-labelledby="editRepresentativeInfoModalLabel" aria-hidden="true"
            @if (session('modal') == 'editRepresentativeInfoModal') style="display: block;" @endif>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editRepresentativeInfoModalLabel">Chỉnh sửa thông tin người đại diện
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('update.representative.info') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="representative_full_name" class="form-label">Họ và tên</label>
                                <input required type="text"
                                    class="form-control @error('representative_full_name') is-invalid @enderror"
                                    id="representative_full_name" name="representative_full_name"
                                    value="{{ old('representative_full_name', $business_member->representative_full_name) }}">
                                @error('representative_full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="representative_phone" class="form-label">Số điện thoại</label>
                                <input required type="phone"
                                    class="form-control @error('representative_phone') is-invalid @enderror"
                                    id="representative_phone" name="representative_phone"
                                    value="{{ old('representative_phone', $business_member->representative_phone) }}">
                                @error('representative_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if (session('modal') == 'editRepresentativeInfoModal')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var myModal = new bootstrap.Modal(document.getElementById('editRepresentativeInfoModal'), {
                        backdrop: 'static',
                        keyboard: false
                    });
                    myModal.show();
                });
            </script>
        @endif

        <!-- Edit Account Info Modal -->
        <div class="modal fade @if (session('modal') == 'editAccountInfoModal') show @endif" id="editAccountInfoModal" tabindex="-1"
            aria-labelledby="editAccountInfoModalLabel" aria-hidden="true"
            @if (session('modal') == 'editAccountInfoModal') style="display: block;" @endif>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAccountInfoModalLabel">Chỉnh sửa thông tin tài khoản</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('update.account.info') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Tên tài khoản</label>
                                <input required type="text" class="form-control @error('full_name') is-invalid @enderror"
                                    id="full_name" name="full_name"
                                    value="{{ old('full_name', auth()->user()->full_name) }}">
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label">Mật khẩu cũ</label>
                                <input type="password" class="form-control @error('old_password') is-invalid @enderror"
                                    id="old_password" name="old_password">
                                @error('old_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu mới</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Nhập lại mật khẩu</label>
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="password_confirmation" name="password_confirmation">
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if (session('modal') == 'editAccountInfoModal')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var myModal = new bootstrap.Modal(document.getElementById('editAccountInfoModal'), {
                        backdrop: 'static',
                        keyboard: false
                    });
                    myModal.show();
                });
            </script>
        @endif
    </section>
@endsection
@push('scripts-admin')
    <script>
        $(document).ready(function() {
            $('#avt_businesses').change(function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#preview').html(
                        `<img src="${e.target.result}" alt="avatar" class="avatar-business border">`
                    );
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
@endpush
