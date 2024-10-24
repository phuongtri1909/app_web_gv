@extends('pages.layouts.page')
@section('title', 'Đăng ký đặc quyền hội viên')

@push('child-styles')
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

        label {
            font-weight: bold;
        }

        .form-control,
        .form-select {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ced4da;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #80bdff;
            box-shadow: 0 0 5px rgba(128, 189, 255, 0.5);
        }

        .mb-3,
        .row {
            margin-bottom: 20px;
        }

        .text-end p {
            margin: 5px 0;
            font-weight: bold;
            font-size: 14px;
            text-align: right;
        }

        .text-end {
            margin-top: 40px;
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

            .row {
                flex-direction: column;
            }
        }

        .title-member-business {
            text-transform: uppercase;
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

            h5 {
                font-size: 18px;
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
    </style>
@endpush

@section('content-page')
    <section id="form-member-business">
        <div class="container my-4">
            <div class="row">
                @include('pages.notification.success-error')
                <form action="{{ route('form.member.business.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- <h3 class="text-center title-member-business">Đăng ký gia nhập hội doanh nghiệp quận gò vấp</h3> --}}
                    <div class="mb-3">
                        <label for="business_name" class="form-label">Tên doanh nghiệp:</label>
                        <input type="text" class="form-control form-control-sm" id="business_name" name="business_name" value="{{ old('business_name') }}" placeholder="Nhập tên doanh nghiệp">
                        @error('business_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="business_license_number" class="form-label">Giấy chứng nhận ĐKKD số:</label>
                        <input type="text" class="form-control form-control-sm" id="business_license_number" name="business_license_number" value="{{ old('business_license_number') }}" placeholder="Nhập số ĐKKD">
                        @error('business_license_number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="license_issue_date" class="form-label">Ngày cấp:</label>
                            <input type="date" class="form-control form-control-sm" id="license_issue_date" name="license_issue_date" value="{{ old('license_issue_date') }}">
                            @error('license_issue_date')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="license_issue_place" class="form-label">Nơi cấp:</label>
                            <input type="text" class="form-control form-control-sm" id="license_issue_place" name="license_issue_place" value="{{ old('license_issue_place') }}" placeholder="Nhập nơi cấp">
                            @error('license_issue_place')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="business_field" class="form-label">Lĩnh vực hoạt động:</label>
                        <input type="text" class="form-control form-control-sm" id="business_field" name="business_field" value="{{ old('business_field') }}" placeholder="Ngành nghề đang kinh doanh">
                        @error('business_field')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="head_office_address" class="form-label">Địa chỉ trụ sở chính:</label>
                        <input type="text" class="form-control form-control-sm" id="head_office_address" name="head_office_address" value="{{ old('head_office_address') }}" placeholder="Nhập địa chỉ trụ sở chính">
                        @error('head_office_address')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="phone" class="form-label">Điện thoại:</label>
                            <input type="text" class="form-control form-control-sm" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Nhập số điện thoại">
                            @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="fax" class="form-label">Fax:</label>
                            <input type="text" class="form-control form-control-sm" id="fax" name="fax" value="{{ old('fax') }}" placeholder="Nhập số fax">
                            @error('fax')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control form-control-sm" id="email" name="email" value="{{ old('email') }}" placeholder="Nhập email">
                            @error('email')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="branch_address" class="form-label">Địa chỉ chi nhánh (nếu có):</label>
                        <input type="text" class="form-control form-control-sm" id="branch_address" name="branch_address" value="{{ old('branch_address') }}" placeholder="Nhập địa chỉ chi nhánh">
                        @error('branch_address')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="mb-3">
                        <label for="organization_participation" class="form-label">Đã tham gia tổ chức:</label>
                        <input type="text" class="form-control form-control-sm" id="organization_participation" name="organization_participation" value="{{ old('organization_participation') }}" placeholder="Nhập thông tin tổ chức">
                        @error('organization_participation')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <h5>(*)Người đại diện gia nhập Hội:</h5>

                    <div class="mb-3">
                        <label for="representative_full_name" class="form-label">Họ và tên:</label>
                        <input type="text" class="form-control form-control-sm" id="representative_full_name" name="representative_full_name" value="{{ old('representative_full_name') }}" placeholder="Nhập họ và tên">
                        @error('representative_full_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="representative_position" class="form-label">Chức vụ:</label>
                            <input type="text" class="form-control form-control-sm" id="representative_position" name="representative_position" value="{{ old('representative_position') }}" placeholder="Nhập chức vụ">
                            @error('representative_position')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Giới tính:<span class="text-danger">*</span></label>
                            <div class="d-flex align-items-center">
                                <div class="form-check me-3">
                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="genderMale" value="male" {{ old('gender') == 'male' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="genderMale">Nam</label>
                                </div>
                                <div class="form-check me-3">
                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="genderFemale" value="female" {{ old('gender') == 'female' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="genderFemale">Nữ</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="genderOther" value="other" {{ old('gender') == 'other' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="genderOther">Khác</label>
                                </div>
                            </div>
                            @error('gender')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="identity_card" class="form-label">CCCD:</label>
                            <input type="text" class="form-control form-control-sm" id="identity_card" name="identity_card" value="{{ old('identity_card') }}" placeholder="Nhập số CCCD..">
                            @error('identity_card')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="identity_card_issue_date" class="form-label">Ngày cấp:</label>
                            <input type="date" class="form-control form-control-sm" id="identity_card_issue_date" name="identity_card_issue_date" value="{{ old('identity_card_issue_date') }}">
                            @error('identity_card_issue_date')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="home_address" class="form-label">Địa chỉ nhà riêng:</label>
                        <input type="text" class="form-control form-control-sm" id="home_address" name="home_address"
                            placeholder="Nhập địa chỉ nhà riêng" value="{{ old('home_address') }}">
                            @error('home_address')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                    </div>

                    <div class="mb-3">
                        <label for="contact_phone" class="form-label">Điện thoại (di động – cơ quan – nhà
                            riêng):</label>
                        <input type="text" class="form-control form-control-sm" id="contact_phone" name="contact_phone"
                            placeholder="Nhập số điện thoại liên hệ"  value="{{ old('contact_phone') }}" >
                            @error('contact_phone')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                    </div>

                    <div class="mb-3">
                        <label for="representative_email" class="form-label">Email:</label>
                        <input type="email" class="form-control form-control-sm" id="representative_email" name="representative_email"
                            placeholder="Nhập email người đại diện" value="{{ old('representative_email') }}">
                            @error('representative_email')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                    </div>
                    <p>(*) Đính kèm bản sao:</p>
                    <div class="mb-3">
                        <label for="business_license_file">Giấy CNĐKKD :<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="file" id="business_license_file" name="business_license_file" accept=".jpg,.jpeg,.png,application/pdf,.doc,.docx"
                                value="{{ old('business_license_file') }}" style="display: none;" />
                            <button type="button" class="btn btn-success @error('business_license_file') is-invalid @enderror" id="business_license_file-button">
                                <i class="bi bi-upload"></i> Upload tệp
                            </button>
                            @error('business_license_file')
                            <div class="invalid-feedback d-block" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div id="upload-list-business_license_file"></div>
                        <span id="error-message-business_license_file" class="text-danger"></span>
                    </div>
                    
                    <div class="mb-3">
                        <label for="identity_card_front_file">CCCD:(mặt trước)<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="file" id="identity_card_front_file" name="identity_card_front_file" accept="image/*" value="{{ old('identity_card_front_file') }}" style="display: none;" />
                            <button type="button" class="btn btn-success @error('identity_card_front_file') is-invalid @enderror" id="identity_card_front_file-button">
                                <i class="bi bi-upload"></i> CCCD mặt trước
                            </button>
                            @error('identity_card_front_file')
                            <div class="invalid-feedback d-block" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div id="upload-list-identity_card_front_file"></div>
                        <span id="error-message-identity_card_front_file" class="text-danger"></span>
                    </div>
                    
                    <div class="mb-3">
                        <label for="identity_card_back_file">CCCD:(mặt sau)<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="file" id="identity_card_back_file" name="identity_card_back_file" accept="image/*" value="{{ old('identity_card_back_file') }}" style="display: none;" />
                            <button type="button" class="btn btn-success @error('identity_card_back_file') is-invalid @enderror" id="identity_card_back_file-button">
                                <i class="bi bi-upload"></i> CCCD mặt sau
                            </button>
                            @error('identity_card_back_file')
                            <div class="invalid-feedback d-block" role="alert">{{ $message }}</div>
                            @enderror
                        </div>
                        <div id="upload-list-identity_card_back_file"></div>
                        <span id="error-message-identity_card_back_file" class="text-danger"></span>
                    </div>
                    

                    {{-- <div class="text-end">
                        <p>Gò Vấp, ngày ... tháng ... năm 20...</p>
                        <p>ĐẠI DIỆN DOANH NGHIỆP</p>
                        <p>(Ký, ghi rõ họ tên, đóng dấu)</p>
                    </div> --}}

                    {{-- <div class="mt-4">
                        <p>(*) Đính kèm bản sao:</p>
                        <ul>
                            <li>Giấy CNĐKKD</li>
                            <li>identity_card người đại diện</li>
                        </ul>
                    </div> --}}
                    <div class="text-end my-3">
                        <button type="submit" class="btn btn-success">Đăng ký</button>
                    </div>
                </form>

            </div>
        </div>
    </section>
@endsection

@push('child-scripts')
    <script>
        document.getElementById('business_license_file-button').addEventListener('click', function() {
            handleFileUpload('business_license_file', 'upload-list-business_license_file', 'error-message-business_license_file');
        });

        document.getElementById('identity_card_front_file-button').addEventListener('click', function() {
            handleFileUpload('identity_card_front_file', 'upload-list-identity_card_front_file', 'error-message-identity_card_front_file');
        });

        document.getElementById('identity_card_back_file-button').addEventListener('click', function() {
            handleFileUpload('identity_card_back_file', 'upload-list-identity_card_back_file', 'error-message-identity_card_back_file');
        });

        function handleFileUpload(fileInputId, uploadListId, errorMessageId) {
            const fileInput = document.getElementById(fileInputId);
            fileInput.click();

            fileInput.addEventListener('change', function() {
                const uploadList = document.getElementById(uploadListId);
                const errorMessage = document.getElementById(errorMessageId);
                uploadList.innerHTML = '';
                errorMessage.textContent = '';

                const files = fileInput.files;

                const uploadButton = document.getElementById(fileInputId + '-button');
                if (files.length > 0) {
                    uploadButton.disabled = true;

                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        const fileItem = document.createElement('div');
                        fileItem.classList.add('uploaded-file');

                        const removeIcon = document.createElement('i');
                        removeIcon.classList.add('fas', 'fa-trash');
                        removeIcon.style.cursor = 'pointer';
                        removeIcon.style.marginLeft = '10px';

                        removeIcon.addEventListener('click', function() {
                            uploadList.removeChild(fileItem);
                            errorMessage.textContent = '';
                            const newFiles = Array.from(fileInput.files).filter((_, index) => index !== i);
                            const dataTransfer = new DataTransfer();
                            newFiles.forEach(file => dataTransfer.items.add(file));
                            fileInput.files = dataTransfer.files;

                            if (newFiles.length === 0) {
                                uploadButton.disabled = false;
                            }
                        });

                        if (fileInputId === 'business_license_file') {
                            const validDocumentTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

                            if (validDocumentTypes.includes(file.type)) {
                                const fileIcon = document.createElement('i');
                                fileIcon.classList.add('bi', 'bi-file-earmark-pdf');
                                const fileName = document.createElement('span');
                                fileName.textContent = file.name;
                                fileItem.appendChild(fileIcon);
                                fileItem.appendChild(fileName);
                                fileItem.appendChild(removeIcon);
                                uploadList.appendChild(fileItem);
                            } else if (file.type.startsWith('image/')) {
                                addImageToUploadList(file, fileItem, removeIcon, uploadList);
                            } else {
                                errorMessage.textContent = file.name + ' không hợp lệ: Vui lòng chỉ tải lên tệp PDF, Word, hoặc hình ảnh.';
                            }
                        } else if (fileInputId === 'identity_card_front_file' || fileInputId === 'identity_card_back_file') {
                            if (file.type.startsWith('image/')) {
                                addImageToUploadList(file, fileItem, removeIcon, uploadList);
                            } else {
                                errorMessage.textContent = 'Vui lòng chỉ tải lên hình ảnh cho CCCD.';
                            }
                        }
                    }
                } else {
                    errorMessage.textContent = 'Vui lòng chọn tệp để tải lên.';
                }
            });
        }

        function addImageToUploadList(file, fileItem, removeIcon, uploadList) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.alt = file.name;
            img.style.maxWidth = '100px';
            img.style.marginRight = '10px';
            img.style.width = '75px';
            img.style.height = '65px';
            const fileIcon = document.createElement('span');
            fileIcon.textContent = file.name;
            fileItem.appendChild(img);
            fileItem.appendChild(fileIcon);
            fileItem.appendChild(removeIcon);
            uploadList.appendChild(fileItem);
        }

    </script>
@endpush
