@extends('pages.layouts.page')
@section('title', 'Đăng ký gia nhập hội')

@push('child-styles')
    <style>
        #form-member-business {
            position: relative;
            margin: 30px auto;
            /* padding: 20px 0px 20px 0px; */
            max-width: 800px;
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
                <form>
                    {{-- <h3 class="text-center title-member-business">Đăng ký gia nhập hội doanh nghiệp quận gò vấp</h3> --}}
                    <div class="mb-3">
                        <label for="tenDoanhNghiep" class="form-label">Tên doanh nghiệp:</label>
                        <input type="text" class="form-control  form-control-sm" id="tenDoanhNghiep"
                            placeholder="Nhập tên doanh nghiệp">
                    </div>

                    <div class="mb-3">
                        <label for="giayDKKD" class="form-label">Giấy chứng nhận ĐKKD số:</label>
                        <input type="text" class="form-control  form-control-sm" id="giayDKKD"
                            placeholder="Nhập số ĐKKD">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="ngayCap" class="form-label">Ngày cấp:</label>
                            <input type="date" class="form-control  form-control-sm" id="ngayCap">
                        </div>
                        <div class="col-md-6">
                            <label for="noiCap" class="form-label">Nơi cấp:</label>
                            <input type="text" class="form-control  form-control-sm" id="noiCap"
                                placeholder="Nhập nơi cấp">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="linhVucHoatDong" class="form-label">Lĩnh vực hoạt động:</label>
                        <input type="text" class="form-control  form-control-sm" id="linhVucHoatDong"
                            placeholder="Ngành nghề đang kinh doanh">
                    </div>

                    <div class="mb-3">
                        <label for="diaChiTruSo" class="form-label">Địa chỉ trụ sở chính:</label>
                        <input type="text" class="form-control  form-control-sm" id="diaChiTruSo"
                            placeholder="Nhập địa chỉ trụ sở chính">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="dienThoai" class="form-label">Điện thoại:</label>
                            <input type="text" class="form-control  form-control-sm" id="dienThoai"
                                placeholder="Nhập số điện thoại">
                        </div>
                        <div class="col-md-4">
                            <label for="fax" class="form-label">Fax:</label>
                            <input type="text" class="form-control  form-control-sm" id="fax"
                                placeholder="Nhập số fax">
                        </div>
                        <div class="col-md-4">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control  form-control-sm" id="email"
                                placeholder="Nhập email">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="diaChiChiNhanh" class="form-label">Địa chỉ chi nhánh (nếu có):</label>
                        <input type="text" class="form-control  form-control-sm" id="diaChiChiNhanh"
                            placeholder="Nhập địa chỉ chi nhánh">
                    </div>

                    <div class="mb-3">
                        <label for="thamGiaToChuc" class="form-label">Đã tham gia tổ chức:</label>
                        <input type="text" class="form-control  form-control-sm" id="thamGiaToChuc"
                            placeholder="Nhập thông tin tổ chức">
                    </div>

                    <h5>(*)Người đại diện gia nhập Hội:</h5>

                    <div class="mb-3">
                        <label for="hoVaTen" class="form-label">Họ và tên:</label>
                        <input type="text" class="form-control  form-control-sm" id="hoVaTen"
                            placeholder="Nhập họ và tên">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="chucVu" class="form-label">Chức vụ:</label>
                            <input type="text" class="form-control  form-control-sm" id="chucVu"
                                placeholder="Nhập chức vụ">
                        </div>
                        <div class="col-md-6">
                            <label for="gioiTinh" class="form-label">Giới tính:</label>
                            <select class="form-select form-select-sm" id="gioiTinh">
                                <option value="Nam">Nam</option>
                                <option value="Nữ">Nữ</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="cmnd" class="form-label">CMND:</label>
                            <input type="text" class="form-control  form-control-sm" id="cmnd"
                                placeholder="Nhập số CMND">
                        </div>
                        <div class="col-md-6">
                            <label for="ngayCapCmnd" class="form-label">Ngày cấp:</label>
                            <input type="date" class="form-control  form-control-sm" id="ngayCapCmnd">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="diaChiRieng" class="form-label">Địa chỉ nhà riêng:</label>
                        <input type="text" class="form-control  form-control-sm" id="diaChiRieng"
                            placeholder="Nhập địa chỉ nhà riêng">
                    </div>

                    <div class="mb-3">
                        <label for="dienThoaiLienHe" class="form-label">Điện thoại (di động – cơ quan – nhà
                            riêng):</label>
                        <input type="text" class="form-control  form-control-sm" id="dienThoaiLienHe"
                            placeholder="Nhập số điện thoại liên hệ">
                    </div>

                    <div class="mb-3">
                        <label for="emailDaiDien" class="form-label">Email:</label>
                        <input type="email" class="form-control  form-control-sm" id="emailDaiDien"
                            placeholder="Nhập email người đại diện">
                    </div>
                    <div class="mb-3">
                        <label for="cndkkd">Giấy CNĐKKD :<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="file" id="cndkkd" name="cndkkd" accept=".jpg,.jpeg,.png,.pdf"
                                value="{{ old('cndkkd') }}" style="display: none;" />
                            <button type="button" class="btn btn-success  @error('cndkkd') is-invalid @enderror"
                                id="cndkkd-button">
                                <i class="bi bi-upload"></i> Upload tệp
                            </button>
                        </div>
                        <div id="upload-list-cndkkd"></div>
                        <span id="error-message-cndkkd" class="text-danger"></span>
                    </div>

                    <div class="mb-3">
                        <label for="cccd1">CCCD:(mặt trước)<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="file" id="cccd1" name="cccd1" accept=".jpg,.jpeg,.png,.pdf"
                                value="{{ old('cccd1') }}" style="display: none;" />
                            <button type="button" class="btn btn-success  @error('cccd1') is-invalid @enderror"
                                id="cccd1-button">
                                <i class="bi bi-upload"></i> CCCD mặt trước
                            </button>
                        </div>
                        <div id="upload-list-cccd1"></div>
                        <span id="error-message-cccd1" class="text-danger"></span>
                    </div>

                    <div class="mb-3">
                        <label for="cccd2">CCCD:(mặt sau)<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="file" id="cccd2" name="cccd2" accept=".jpg,.jpeg,.png,.pdf"
                                value="{{ old('cccd2') }}" style="display: none;" />
                            <button type="button" class="btn btn-success  @error('cccd2') is-invalid @enderror"
                                id="cccd2-button">
                                <i class="bi bi-upload"></i> CCCD mặt sau
                            </button>
                        </div>
                        <div id="upload-list-cccd2"></div>
                        <span id="error-message-cccd2" class="text-danger"></span>
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
                            <li>CMND người đại diện</li>
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
        document.getElementById('cndkkd-button').addEventListener('click', function() {
            handleFileUpload('cndkkd', 'upload-list-cndkkd', 'error-message-cndkkd');
        });

        document.getElementById('cccd1-button').addEventListener('click', function() {
            handleFileUpload('cccd1', 'upload-list-cccd1', 'error-message-cccd1');
        });

        document.getElementById('cccd2-button').addEventListener('click', function() {
            handleFileUpload('cccd2', 'upload-list-cccd2', 'error-message-cccd2');
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
                        removeIcon.classList.add('fas', 'fa-trash'); // Cập nhật class
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

                        if (file.type === 'application/pdf') {
                            const fileIcon = document.createElement('i');
                            fileIcon.classList.add('bi', 'bi-file-earmark-pdf');
                            const fileName = document.createElement('span');
                            fileName.textContent = file.name;
                            fileItem.appendChild(fileIcon);
                            fileItem.appendChild(fileName);
                            fileItem.appendChild(removeIcon);
                            uploadList.appendChild(fileItem);
                        } else if (file.type.startsWith('image/')) {
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
                        } else {
                            errorMessage.textContent = file.name +
                                ' không hợp lệ: Vui lòng chỉ tải lên tệp PDF hoặc hình ảnh.';
                            uploadList.appendChild(fileItem);
                        }
                    }
                } else {
                    errorMessage.textContent = 'Vui lòng chọn tệp để tải lên.';
                }
            });
        }
    </script>
@endpush
