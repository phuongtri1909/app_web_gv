@extends('pages.client.p17.layouts.app')
@section('title', 'Đăng ký Quảng cáo - Rao vặt')
@section('description', 'Đăng ký Quảng cáo - Rao vặt')
@section('keyword', 'Đăng ký Quảng cáo - Rao vặt')

@push('styles')
    <style>
        .form-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 32px;
            background-color: #ffffff;
            border-radius: 16px;
        }

        .form-title {
            font-size: 32px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 32px;
            color: #1a1a1a;
            position: relative;
        }

        .form-title:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: #007bff;
            border-radius: 2px;
        }

        .form-section {
            padding: 24px;
            border-radius: 12px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #2d3748;
            font-size: 15px;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 12px 16px;
            font-size: 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            background-color: #fff;
            transition: all 0.3s ease;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
            outline: none;
        }

        .form-textarea {
            min-height: 150px;
        }

        .required {
            color: #e53e3e;
            margin-left: 4px;
        }

        .btn-submit {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-submit:hover {
            background-color: #0056b3;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.2);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .preview-image {
            max-height: 200px;
            object-fit: cover;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .images-preview-container button {
            position: absolute;
            right: 10px;
        }

        .preview-image.selected {
            border: 2px solid #007bff !important;
        }

        .form-file-input {
            width: 100%;
            padding: 12px;
            background: #fff;
            border: 2px dashed #cbd5e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-file-input:hover {
            border-color: #007bff;
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #718096;
        }

        .price-wrapper {
            position: relative;
        }

        .price-wrapper:after {
            content: 'đ';
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #718096;
        }

        @media (max-width: 768px) {
            .form-container {
                margin: 20px;
                padding: 20px;
            }

            .form-title {
                font-size: 24px;
            }

            .form-section {
                padding: 16px;
            }
        }

        .not-allowed {
            background: #142d7f;
            width: max-content;
            padding: 0px 10px;
            color: #fff;
            border-radius: 5px;
            margin-top: 5px;
        }

        #example-text {
            background: #edf2f7;
            padding: 5px 10px;
            margin-top: 10px;
            border-radius: 5px;
            visibility: hidden;
            position: absolute;
            transition: visibility 0s ease, opacity 0.7s ease-in-out;
            opacity: 0;
        }
    </style>
@endpush


@push('scripts')
    <script>
        document.getElementById('image').addEventListener('change', function(event) {

            const previewsContainer = document.querySelector('.images-preview-container');

            previewsContainer.innerHTML = '';

            const files = event.target.files;
            if (files.length === 0) {
                previewsContainer.innerHTML = '<p class="text-muted m-0">Chưa có hình ảnh được chọn</p>';
                return;
            }
            Array.from(files).forEach((file, index) => {
                const preview = document.createElement('img');
                preview.classList.add(
                    'preview-image',
                    'img-fluid',
                    'rounded',
                    'border',
                    'me-2',
                    'mb-2'
                );
                const wrapper = document.createElement('div');
                wrapper.classList.add('position-relative');
                const removeBtn = document.createElement('button');
                removeBtn.innerHTML = '×';
                removeBtn.classList.add(
                    'position-absolute',
                    'top-0',
                    'btn',
                    'btn-danger',
                    'btn-sm',
                    'rounded-circle'
                );
                removeBtn.onclick = function(e) {
                    e.preventDefault();
                    wrapper.remove();
                    if (previewsContainer.children.length === 0) {
                        previewsContainer.innerHTML =
                            '<p class="text-muted m-0">Chưa có hình ảnh được chọn</p>';
                    }
                };

                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
                wrapper.appendChild(preview);
                wrapper.appendChild(removeBtn);
                previewsContainer.appendChild(wrapper);
            });
        });
        document.querySelector('.ad-form').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('error');
                } else {
                    field.classList.remove('error');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Vui lòng điền đầy đủ thông tin bắt buộc');
            }
        });
        const priceInput = document.getElementById('price');
        priceInput.addEventListener('input', function(e) {
            let value = this.value;
            if (value) {
                value = value.replace(/\D/g, '');
                value = parseInt(value || 0).toLocaleString('vi-VN');
                this.value = value;
            }
        });
    </script>
    <script>
        CKEDITOR.replace('description', {
            height: 200,
            on: {
                instanceReady: function() {
                    const editor = this;
                    const placeholderText =
                        "Hãy mô tả chi tiết về sản phẩm hoặc dịch vụ của bạn, bao gồm các thông tin như đặc điểm nổi bật, tình trạng, tính năng, hoặc lợi ích mang lại.";
                    if (!editor.getData().trim()) {
                        editor.setData(`<p style="color: #999;">${placeholderText}</p>`);
                    }
                    editor.on('focus', function() {
                        if (editor.getData()) {
                            editor.setData('');
                        }
                    });
                    editor.on('blur', function() {
                        if (!editor.getData().trim()) {
                            editor.setData(`<p style="color: #999;">${placeholderText}</p>`);
                        }
                    });
                    const exampleText = document.getElementById("example-text");
                    editor.on('focus', function() {
                        exampleText.style.visibility = 'visible';
                        exampleText.style.opacity = 1;
                        exampleText.style.position = 'relative';
                    });
                    editor.on('blur', function() {
                        exampleText.style.opacity = 0;
                        exampleText.style.visibility = 'hidden';
                        exampleText.style.position = 'absolute';
                    });
                }
            }
        });
    </script>
@endpush


@section('content')
    <section id="advertising-form" class="py-8">
        <div class="form-container">
            <h2 class="form-title">Đăng ký quảng cáo/rao vặt</h2>
            <form action="" method="POST" enctype="multipart/form-data" class="ad-form">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Tiêu đề quảng cáo <span class="required">*</span></label>
                            <div class="input-group">
                                <input type="text" id="title" name="title" class="form-input"
                                    placeholder="Nhập tiêu đề ngắn gọn, hấp dẫn" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="subcategory">Danh mục <span class="required">*</span></label>
                            <select id="subcategory" name="subcategory" class="form-select" required>
                                <option value="">-- Chọn danh mục --</option>
                                <option value="dich-vu">Dịch vụ</option>
                                <option value="nha-cho-thue">Nhà cho thuê</option>
                                <option value="others">Khác</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category">Loại tin <span class="required">*</span></label>
                            <select id="category" name="category" class="form-select" required>
                                <option value="">-- Chọn loại tin --</option>
                                <option value="quang-cao">Quảng cáo</option>
                                <option value="rao-vat">Rao vặt</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">Giá <span class="required">*</span></label>
                            <div class="price-wrapper">
                                <input type="text" id="price" name="price" class="form-input"
                                    placeholder="Nhập giá" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="location">Tuyến đường <span class="required">*</span></label>
                            <select id="location" name="location" class="form-select" required>
                                <option value="">-- Chọn tuyến đường --</option>
                                <option value="le-duc-tho">Lê Đức Thọ</option>
                                <option value="nguyen-van-luong">Nguyễn Văn Lượng</option>
                                <option value="nguyen-oanh">Nguyễn Oanh</option>
                                <option value="quang-ham">Quảng Hàm</option>
                                <option value="others">Khác</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Mô tả chi tiết</label>
                            <textarea id="description" name="description" class="form-textarea" placeholder="Nhập mô tả chi tiết"></textarea>
                            <div id="example-text">
                                <div class="not-allowed">
                                    <p>Không cho phép:</p>
                                </div>
                                <p style="position: relative; top: -8px; ">
                                    - Sản phẩm cấm,hạn chế hoặc giả nhái. <br>
                                    - Thông tin trùng lặp với tin đăng cũ.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-section">
                    <div class="form-group">
                        <label for="image">Hình ảnh minh họa</label>
                        <input type="file" id="image" name="image[]" class="form-file-input" accept="image/*"
                            multiple>
                        <div class="images-preview-container d-flex flex-wrap mt-2">

                        </div>
                    </div>
                </div>


                <button type="submit" class="btn-submit">
                    Đăng tin
                </button>
            </form>
        </div>
    </section>
@endsection
