@extends('layouts.app')
@section('title', 'Đăng ký nhu cầu vốn')
@push('styles')
    <style>
        .upload-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .upload-label {
            cursor: pointer;
        }

        .upload-box {
            width: 200px;
            height: 200px;
            border: 2px dashed #ccc;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-radius: 4px;
            transition: border-color 0.3s;
            position: relative;
            overflow: hidden;
        }

        .image-preview {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-preview-container {
            position: absolute;
            flex-direction: row;
            gap: 5px;
        }

        .image-preview:hover .image-preview-container {
            display: flex;
        }

        .control-icon {
            font-size: 15px;
            cursor: pointer;
            padding: 5px;
            color: #fff
        }

        .preview-image {
            max-width: 100%;
            max-height: 100%;
            display: block;
        }

        .upload-box:hover {
            border-color: #999;
        }

        .upload-icon {
            font-size: 24px;
            color: #666;
        }

        .upload-text {
            color: #666;
            font-size: 14px;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .image-preview-container:hover .image-overlay {
            opacity: 1;
        }

        input[type="file"] {
            display: none;
        }

        .form-control:focus,
        .form-control:hover,
        .upload-label:focus,
        .upload-label:hover {
            border-color: #80bdff;
            box-shadow: 0 0 5px rgba(128, 189, 255, 0.5);
            outline: 0;
        }

        .ant-upload-list-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .ant-upload-list-item-thumbnail {
            margin-right: 10px;
        }

        .ant-upload-list-item-name {
            flex-grow: 1;
        }

        .ant-upload-list-item-actions {
            margin-left: 10px;

        }

        .ant-upload-list-item-action {
            border: none !important;
            background-color: unset !important;
        }

        .error-message,
        .error-message1 {
            color: red;
            margin-top: 10px;
        }

        .btn-success {
            background-color: #0056b3;
            transition: background-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #004494;
        }

        @media (max-width: 768px) {

            .btn-success {
                padding: 8px;
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {


            .btn-success {
                padding: 6px;
                font-size: 12px;
            }
        }

        .btn:disabled {
            background-color: #004494;
        }

        #registering-capital {
            position: relative;
            margin: 30px auto;
            /* padding: 20px 0px 20px 0px; */
            /* max-width: 800px; */
            background-color: #f8f9fa;
            border-radius: 8px;
            background: url('{{ asset('images/logo.png') }}') no-repeat;
            background-size: 30%;
            background-attachment: fixed;
            background-position: center center;
            z-index: 1;
        }

        form {
            position: relative;
            z-index: 1;
            background-color: rgba(255, 255, 255, 0.9);
            /* padding: 20px; */
            border-radius: 8px;
        }
    </style>
@endpush


@section('content')
    <section id="registering-capital">
        <div class="container my-4">
            <div class="row">
                
                <form action="{{ route('show.form.capital.need.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($slug))
                        <input type="hidden" id="slug" name="slug" value="{{ $slug }}">
                    @endif
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label for="business_name" class="form-label">Tên doanh nghiệp <span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control form-control-sm @error('business_name') is-invalid @enderror"
                                id="business_name" name="business_name" placeholder="Nhập tên doanh nghiệp"
                                value="{{ old('business_name') }}" required>
                            @error('business_name')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="business_code" class="form-label">Mã số doanh nghiệp/Mã số thuế <span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control form-control-sm @error('business_code') is-invalid @enderror"
                                id="business_code" name="business_code" placeholder="Nhập mã số doanh nghiệp/mã số thuế"
                                value="{{ old('business_code') }}" required>
                            @error('business_code')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="category_business_id" class="form-label">Loại hình doanh nghiệp <span
                                    class="text-danger">*</span></label>
                            <select class="form-select form-control form-select-sm" id="category_business_id"
                                name="category_business_id">
                                @foreach ($category_business as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_business_id')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label for="business_address" class="form-label">Địa chỉ trụ sở chính <span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control form-control-sm @error('business_address') is-invalid @enderror" id="business_address"
                                name="business_address" placeholder="Nhập địa chỉ trụ sở chính" value="{{ old('business_address') }}" required>
                            @error('business_address')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="phone_number" class="form-label">Điện thoại <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control form-control-sm @error('phone_number') is-invalid @enderror"
                                id="phone_number" name="phone_number" placeholder="Nhập số điện thoại" value="{{ old('phone_number') }}" required>
                            @error('phone_number')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="fax" class="form-label">Fax</label>
                            <input type="text" class="form-control form-control-sm @error('fax') is-invalid @enderror"
                                id="fax" name="fax" placeholder="Nhập số fax" value="{{ old('fax') }}">
                            @error('fax')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror"
                                id="email" name="email" placeholder="Nhập email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="representative_name" class="form-label">Người đại diện pháp luật <span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control form-control-sm @error('representative_name') is-invalid @enderror"
                                id="representative_name" name="representative_name" placeholder="Nhập tên người đại diện"
                                value="{{ old('representative_name') }}" required>
                            @error('representative_name')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label">Giới tính:<span class="text-danger">*</span></label>
                            <div class="d-flex align-items-center">
                                <div class="form-check me-3">
                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio"
                                        name="gender" id="genderMale" value="male"
                                        {{ old('gender') == 'male' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="genderMale">
                                        Nam
                                    </label>
                                </div>
                                <div class="form-check me-3">
                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio"
                                        name="gender" id="genderFemale" value="female"
                                        {{ old('gender') == 'female' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="genderFemale">
                                        Nữ
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio"
                                        name="gender" id="genderOther" value="other"
                                        {{ old('gender') == 'other' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="genderOther">
                                        Khác
                                    </label>
                                </div>
                            </div>
                            @error('gender')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <label for="">Nhu cầu hỗ trợ vốn:</label>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="interest_rate">Lãi suất:<span class="text-danger">*</span></label>
                            <input type="number" 
                                class="form-control form-control-sm @error('interest_rate') is-invalid @enderror" 
                                id="interest_rate"
                                name="interest_rate" 
                                placeholder="Nhập lãi suất mong muốn" 
                                value="{{old('interest_rate')}}" min="0" required>
                            @error('interest_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="finance">Tài chính:<span class="text-danger">*</span></label>
                            <input type="number" 
                                class="form-control form-control-sm @error('finance') is-invalid @enderror" 
                                id="finance" 
                                name="finance"
                                placeholder="Nhập số tiền tài chính (đồng)" 
                                value="{{old('finance')}}" min="0" required>
                            @error('finance')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="mortgage_policy">Chính sách vay thế chấp:<span class="text-danger">*</span></label>
                            <input type="text" 
                                class="form-control form-control-sm @error('mortgage_policy') is-invalid @enderror" 
                                id="mortgage_policy"
                                name="mortgage_policy" 
                                placeholder="Nhập chính sách vay thế chấp" 
                                value="{{old('mortgage_policy')}}" required>
                            @error('mortgage_policy')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="unsecured_policy">Tín chấp:<span class="text-danger">*</span></label>
                            <input type="text" 
                                class="form-control form-control-sm @error('unsecured_policy') is-invalid @enderror" 
                                id="unsecured_policy"
                                name="unsecured_policy" 
                                placeholder="Nhập thông tin tín chấp" 
                                value="{{old('unsecured_policy')}}" required>
                            @error('unsecured_policy')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="purpose">Mục đích:<span class="text-danger">*</span></label>
                            <input type="text" 
                                class="form-control form-control-sm @error('purpose') is-invalid @enderror" 
                                id="purpose" 
                                name="purpose"
                                placeholder="Nhập mục đích vay" 
                                value="{{old('purpose')}}" required>
                            @error('purpose')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="bank_connection">Kết nối ngân hàng:<span class="text-danger">*</span></label>
                            <input type="text" 
                                class="form-control form-control-sm @error('bank_connection') is-invalid @enderror" 
                                id="bank_connection"
                                name="bank_connection" 
                                placeholder="Nhập tên ngân hàng kết nối" 
                                value="{{old('bank_connection')}}" required>
                            @error('bank_connection')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="feedback">Phản ánh về việc giải quyết của ngân hàng:</label>
                            <textarea class="form-control form-control-sm @error('feedback') is-invalid @enderror" id="feedback"
                                name="feedback" rows="3" placeholder="{{ __('Nhập phản hồi của bạn') }}">{{ old('feedback') }}</textarea>
                            @error('feedback')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="text-end my-3">
                        <button type="submit" class="btn btn-success">Đăng ký</button>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="border border-custom rounded mb-3">
                            <div class="bg-business rounded-top py-2 px-3 mb-3">
                                <h5 class="mb-0 fw-bold text-dark">NCB Cộng Hòa</h5>
                            </div>
                            <div class="px-3">
                                <div class="d-flex">
                                    <p class="fw-semibold me-2 mb-0">Địa chỉ:</p>
                                    <p class="mb-0">18H Cộng Hòa, Phường 4, Quận Tân Bình, Thành phố Hồ Chí Minh</p>
                                </div>
                                <div class="d-flex">
                                    <p class="fw-semibold me-2 mb-0">Số Fax:</p>
                                    <p class="mb-0">(08)38125351</p>
                                </div>
                                <div class="d-flex">
                                    <p class="fw-semibold me-2 mb-0">GĐ chi nhánh:</p>
                                    <p class="mb-0">Trịnh Minh Châu</p>
                                </div>
                                <div class="d-flex">
                                    <p class="fw-semibold me-2 mb-0">Số điện thoại:</p>
                                    <p class="mb-0">0987.338339 - 0786.338339</p>
                                </div>
                                <hr>
                                <div class="d-flex">
                                    <p class="fw-semibold me-2 mb-0">Họ và tên:</p>
                                    <p class="mb-0">Dương Văn Thịnh</p>
                                </div>
                                <div class="d-flex">
                                    <p class="fw-semibold me-2 mb-0">Số điện thoại:</p>
                                    <p class="mb-0">0901967068</p>
                                </div>
                                <div class="d-flex">
                                    <p class="fw-semibold me-2 mb-0">Email:</p>
                                    <p class="mb-0">thinhdv1@ncb-bank.vn</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush
