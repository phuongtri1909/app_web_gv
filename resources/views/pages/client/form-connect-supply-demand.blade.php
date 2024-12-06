@extends('layouts.app')
@section('title', 'Đăng ký kết nối cung cầu')
@push('styles')
    <style>
        .form-control:focus,
        .form-control:hover,
        .upload-label:focus,
        .upload-label:hover {
            border-color: #00d274;
            box-shadow: 0 0 0 2px rgba(5, 255, 95, 0.1);
            outline: 0;
        }

        .error-message,
        .error-message1 {
            color: red;
            margin-top: 10px;
        }

        #form-business {
            position: relative;
            /* margin: 30px auto; */
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('content')
    <section id="form-business" class="form-business mt-5rem">
        <div class="container">
            <div class="row">

                <form action="{{ route('connect.supply.demand.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row ">

                        <div class="mb-3 col-md-6">
                            <label for="name_product" class="form-label">Tên sản phẩm<span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="name_product" name="name_product"
                                value="{{ old('name_product') }}" placeholder="Nhập tên sản phẩm" required>
                            @error('name_product')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="category_product_id" class="form-label">Danh mục sản phẩm<span
                                    class="text-danger">*</span></label>
                            <select id="category_product_id" name="category_product_id"
                                class="form-select form-select-sm @error('category_product_id') is-invalid @enderror"
                                required>
                                <option value="" disabled selected>Chọn danh mục sản phẩm</option>
                                @foreach ($categoryProductBusinesses as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('category_product_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_product_id')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-4">
                            <label for="description" class="form-label">Thông tin về sản phẩm <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm @error('description') is-invalid @enderror" id="description"
                                placeholder="Nhập thông tin về sản phẩm" name="description" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="related_confirmation_document" class="form-label">Các giấy tờ xác nhận liên quan đến
                                sản phẩm</label>
                            <input type="file"
                                class="form-control form-control-sm @error('related_confirmation_document') is-invalid @enderror"
                                id="related_confirmation_document" name="related_confirmation_document[]" multiple>
                            @error('related_confirmation_document')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="price" class="form-label">Giá bán<span class="text-danger">*</span></label>
                            <input required type="number"
                                class="form-control form-control-sm @error('price') is-invalid @enderror" id="price"
                                placeholder="Nhập giá bán sản phẩm" name="price" value="{{ old('price') }}">
                            @error('price')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="price_member" class="form-label">Giá cho thành viên<span
                                    class="text-danger">*</span></label>
                            <input required type="number"
                                class="form-control form-control-sm @error('price_member') is-invalid @enderror"
                                id="price_member" placeholder="Nhập giá bán cho thành viên" name="price_member"
                                value="{{ old('price_member') }}">
                            @error('price_member')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6 mb-4">
                            <label for="product_avatar" class="form-label">Hình đại diện sản phẩm (500x500px)<span
                                    class="text-danger">*</span></label>
                            <input type="file"
                                class="form-control form-control-sm @error('product_avatar') is-invalid @enderror"
                                id="product_avatar" name="product_avatar">
                            @error('product_avatar')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                            <img id="avatar_preview" src="#" alt="Avatar Preview" class="img-fluid mt-3"
                                style="display: none; max-height: 200px;">
                        </div>

                        <div class="col-12 col-md-6 mb-4">
                            <label for="product_images" class="form-label">Hình ảnh sản phẩm (Tối đa 4 ảnh) <span
                                    class="text-danger">*</span></label>
                            <input type="file"
                                class="form-control form-control-sm @error('product_images') is-invalid @enderror"
                                id="product_images" name="product_images[]" multiple>
                            @error('product_images')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                            <div id="image_preview_container" class="mt-3"></div>
                        </div>

                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                        @if ($errors->has('error'))
                            <div class="invalid-feedback" role="alert">{{ $errors->first('error') }}</div>
                        @endif
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#start_date", {
            dateFormat: "Y-m-d",
        });
        flatpickr("#end_date", {
            dateFormat: "Y-m-d",
        });

        document.getElementById('product_avatar').addEventListener('change', function(event) {
            validateImageInput(event);
            const [file] = event.target.files;
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('avatar_preview');
                    img.src = e.target.result;
                    img.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('product_images').addEventListener('change', function(event) {
            validateImageInput(event);
            const files = event.target.files;
            if (files.length > 4) {
                showToast('Chỉ được chọn tối đa 4 ảnh sản phẩm', 'error');
                event.target.value = ''; // Clear the input
            } else {
                // Optionally, you can add code here to preview the selected images
                const previewContainer = document.getElementById('image_preview_container');
                previewContainer.innerHTML = ''; // Clear previous previews
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('img-thumbnail', 'me-2', 'mb-2');
                        img.style.maxWidth = '100px';
                        img.style.maxHeight = '100px';
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            }
        });

        document.getElementById('related_confirmation_document').addEventListener('change', validateDocumentInput);
    </script>
@endpush
