@extends('layouts.app')
@section('title', 'Đăng ký doanh nghiệp/hộ kinh doanh')

@push('styles')
    <style>
        #form-member-business {
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



        h5 {
            margin-top: 20px;
            color: #ec1e28;
            margin-left: 10px;
            font-weight: 500;
        }

        .text-end p {
            margin: 5px 0;
            font-weight: bold;
            font-size: 14px;
            text-align: right;
        }
        .text-end p:nth-child(1) {
            font-style: italic;
            text-align: right;
        }

        .mt-4 ul {
            list-style-type: none;
            padding-left: 0;
            font-weight: bold;
        }

        .mt-4 ul li {
            margin-bottom: 5px;
            padding-left: 15px;
            position: relative;
        }

        .mt-4 ul li::before {
            content: "\2022";
            color: #0056b3;
            font-weight: bold;
            display: inline-block;
            width: 15px;
            margin-left: -15px;
        }

        @media (max-width: 768px) {
            #form-member-business {
                padding: 10px;
            }

            .text-end p {
                text-align: center;
            }
        }

        .title-member-business {
            text-transform: uppercase;
        }

        @media (max-width: 768px) {
            h5 {
                font-size: 18px;
            }
        }
        .choices__input--cloned--placeholder--hidden {
            min-width: 19ch !important;
            &::-webkit-input-placeholder {
                /* WebKit browsers */
               color: #6b7280;
                opacity: 0;
            }
            &:-moz-placeholder {
                /* Mozilla Firefox 4 to 18 */
               color: #6b7280;
                opacity: 0;
            }
            &::-moz-placeholder {
                /* Mozilla Firefox 19+ */
               color: #6b7280;
                opacity: 0;
            }
            &:-ms-input-placeholder {
                /* Internet Explorer 10+ */
               color: #6b7280;
                opacity: 0;
            }
        }

    </style>
@endpush

@section('content')
    <section id="form-member-business">
        <div class="container my-4">
            <div class="row">

                <form id="business-member" action="{{ route('form.member.business.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="business_name" class="form-label">Tên doanh nghiệp/hộ kinh doanh:<span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="business_name"
                                name="business_name" value="{{ old('business_name') }}" placeholder="Nhập tên doanh nghiệp"
                                required>
                            @error('business_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="business_code" class="form-label">Mã số doanh nghiệp:<span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="business_code" name="business_code" value="{{ old('business_code') }}" placeholder="Nhập mã doanh nghiệp" required>
                            @error('business_code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-4 ">
                            <label for="address" class="form-label">Địa chỉ kinh doanh:<span
                                class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="address" name="address"
                                value="{{ old('address') }}" placeholder="Nhập địa chỉ chi nhánh" required>
                            @error('address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control form-control-sm" id="email" name="email"
                                value="{{ old('email') }}" placeholder="Nhập email">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="phone_zalo" class="form-label">Số điện thoại zalo:<span
                                    class="text-danger">*</span></label>
                            <input type="tel" class="form-control form-control-sm" id="phone_zalo" name="phone_zalo"
                                value="{{ old('phone_zalo') }}" placeholder="Nhập số điện thoại" required>
                            @error('phone_zalo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="business_field_id" class="form-label">Ngành nghề kinh doanh <span
                                    class="text-danger">*</span></label>
                            <select id="business_field_id" name="business_field_id[]"
                                class="form-select form-select-sm @error('business_field_id') is-invalid @enderror" multiple>
                                @foreach ($business_fields as $field)
                                    <option value="{{ $field->id }}"
                                        {{ in_array($field->id, old('business_field_id', json_decode($registration->business_field_id ?? '[]', true))) ? 'selected' : '' }}>
                                        {{ $field->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('business_field_id')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="link" class="form-label">Liên kết:</label>
                            <input type="tel" class="form-control form-control-sm" id="link" name="link"
                                value="{{ old('link') }}" placeholder="website hoặc fanpage ...">
                            @error('link')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <h5>(*)Người đại diện Pháp luật:</h5>


                        <div class="mb-3 col-12 col-md-6">
                            <label for="representative_full_name" class="form-label">Họ và tên:<span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="representative_full_name"
                                name="representative_full_name" value="{{ old('representative_full_name') }}"
                                placeholder="Nhập họ và tên" required>
                            @error('representative_full_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="representative_phone" class="form-label">Điện thoại:<span
                                    class="text-danger">*</span></label>
                            <input type="tel" class="form-control form-control-sm" id="representative_phone"
                                name="representative_phone" placeholder="Nhập số điện thoại liên hệ"
                                value="{{ old('representative_phone') }}" required>
                            @error('representative_phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="d-flex flex-column align-items-center">
                            <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                            @if ($errors->has('recaptcha'))
                                <div class="text-danger" role="alert">{{ $errors->first('recaptcha') }}</div>
                            @endif
                        </div>

                    </div>

                    <div class="text-center my-3">
                        <button type="submit" class="btn bg-app-gv rounded-pill text-white">Đăng ký</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const element = document.querySelector('#business_field_id');
        const businessFieldSelect = new Choices(element, {
            removeItemButton: true,
            placeholder: true,
            placeholderValue: 'Chọn ngành nghề kinh doanh',
            searchPlaceholderValue: 'Tìm kiếm...',
            noResultsText: 'Không tìm thấy ngành nghề phù hợp',
            noChoicesText: 'Không có ngành nghề nào',
            itemSelectText: 'Nhấn để chọn',
        });

        const inputElement = document.querySelector(".choices__input.choices__input--cloned");
        element.addEventListener("addItem", function () {
            if (inputElement) {
            inputElement.classList.add("choices__input--cloned--placeholder--hidden");
            }
        });
        element.addEventListener("removeItem", function () {
            if (businessFieldSelect.getValue(true).length < 1) {
            if (inputElement) {
                inputElement.classList.remove("choices__input--cloned--placeholder--hidden");
            }
            }
        });
        if (businessFieldSelect.getValue(true).length > 0) {
            inputElement.classList.add("choices__input--cloned--placeholder--hidden");
        }
        });
    </script>
@endpush
