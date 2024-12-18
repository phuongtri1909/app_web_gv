@extends('layouts.app')
@section('title', 'Đăng ký Hội chợ Doanh nghiệp')
@section('description', 'Đăng ký tham gia hội chợ doanh nghiệp')
@section('content')

@push('styles')
    <style>
        #form-business{
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
<section id="form-business" class="form-business mt-5rem">
    <div class="container my-4">
        <div class="row">
            <form action="{{ route('business-fair-registrations.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="news_id" id="news_id" value="{{ $news_id }}"> 
            
                <div class="row">
                    <div class="mb-3 col-12 col-md-6">
                        <label for="business_name" class="form-label">Tên DN/hộ kinh doanh</label>
                        <input type="text" id="business_name" class="form-control" value="{{ $businessName ?? 'Không tìm thấy doanh nghiệp' }}" disabled>
                    </div>
                    <div class="mb-3 col-12 col-md-6">
                        <label for="business_license_f" class="form-label">Hình giấy phép kinh doanh (Không bắt buộc)</label>
                        <input type="file" name="business_license_f" id="business_license_f" class="form-control">
                        <div id="business_license_preview_container" class="mt-3"></div>
                    </div>
                </div>
            
                <div class="row">
                    <div class="mb-3 col-12 col-md-6">
                        <label for="representative_full_name" class="form-label">Họ tên người đăng ký<span class="text-danger">*</span></label>
                        <input type="text" name="representative_full_name" id="representative_full_name"
                               class="form-control @error('representative_full_name') is-invalid @enderror"
                               value="{{ old('representative_full_name', $representativeName) }}">
                        @error('representative_full_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
            
                    <div class="mb-3 col-12 col-md-6">
                        <label for="birth_year" class="form-label">Năm sinh <span class="text-danger">*</span></label>
                        <input type="number" name="birth_year" id="birth_year" class="form-control @error('birth_year') is-invalid @enderror"
                               value="{{ old('birth_year') }}">
                        @error('birth_year')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            
                <div class="row">
                    <div class="mb-3 col-12 col-md-6">
                        <label class="form-label">Giới tính <span class="text-danger">*</span></label>
                        <div class="d-flex justify-content-around">
                            <div class="form-check me-1 ps-0">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ old('gender') == 'male' ? 'checked' : '' }}>
                                <label class="form-check-label" for="male">Nam</label>
                            </div>
                            <div class="form-check me-1">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
                                <label class="form-check-label" for="female">Nữ</label>
                            </div>
                            <div class="form-check me-1">
                                <input class="form-check-input" type="radio" name="gender" id="other" value="other" {{ old('gender') == 'other' ? 'checked' : '' }}>
                                <label class="form-check-label" for="other">Khác</label>
                            </div>
                        </div>
                        @error('gender')
                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                        @enderror
                    </div>
            
                    <div class="mb-3 col-12 col-md-6">
                        <label for="phone_zalo" class="form-label">Số điện thoại liên lạc<span class="text-danger">*</span></label>
                        <input type="text" name="phone_zalo" id="phone_zalo" class="form-control @error('phone_zalo') is-invalid @enderror"
                               value="{{ old('phone_zalo',$phoneZalo) }}">
                        @error('phone_zalo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            
                <div class="mb-4">
                    <label for="products" class="form-label">Hàng hóa, sản phẩm tham gia hội chợ<span class="text-danger">*</span></label>
                    <textarea name="products" id="products" rows="4" class="form-control @error('products') is-invalid @enderror">{{ old('products') }}</textarea>
                    @error('products')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="mb-4">
                    <label for="product_images" class="form-label">Hình ảnh sản phẩm</label>
                    <input type="file" name="product_images[]" id="product_images" class="form-control" multiple>
                    <div id="product_image_preview_container" class="mt-3"></div>
                </div>
            
                <div class="mb-4">
                    <label class="form-label">Số gian hàng đăng ký tham gia hội chợ <span class="text-danger">*</span></label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="booth_count" id="booth_count_1" value="1" {{ old('booth_count') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="booth_count_1">1</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="booth_count" id="booth_count_2" value="2" {{ old('booth_count') == '2' ? 'checked' : '' }}>
                        <label class="form-check-label" for="booth_count_2">2</label>
                    </div>
                    @error('booth_count')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="form-group mb-3">
                    <label for="discount_percentage">Đăng ký giảm giá(%)</label>
                    <input type="number" class="form-control" name="discount_percentage" value="{{ old('discount_percentage') }}">
                    @error('discount_percentage')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="form-group form-check mb-3">
                    <input type="checkbox" name="is_join_stage_promotion" id="is_join_stage_promotion" class="form-check-input @error('is_join_stage_promotion') is-invalid @enderror" {{ old('is_join_stage_promotion') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_join_stage_promotion"> Đăng ký tham gia chương trình quảng bá sàn phẩm trên sân khấu</label>
                    @error('is_join_stage_promotion')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="form-group form-check mb-3">
                    <input type="checkbox" name="is_join_charity" id="is_join_charity" class="form-check-input @error('is_join_charity') is-invalid @enderror" {{ old('is_join_charity') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_join_charity">Đăng ký tham gia tặng quà cho người có hoàn cảnh khó khăn </label>
                    @error('is_join_charity')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex flex-column align-items-center">
                    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                    @if ($errors->has('recaptcha'))
                        <div class="text-danger" role="alert">{{ $errors->first('recaptcha') }}</div>
                    @endif
                </div>

                <div class="text-center my-2">
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
        function previewFiles(input, previewContainerId, isVideo = false, maxFiles = 5) {
            const previewContainer = document.getElementById(previewContainerId);
            previewContainer.innerHTML = '';
            let files = Array.from(input.files);
            if (files.length > maxFiles) {
                alert(`Chỉ được tối đa ${maxFiles} ảnh. Các ảnh thừa đã bị loại bỏ.`);

                const dataTransfer = new DataTransfer();
                files.slice(0, maxFiles).forEach(file => dataTransfer.items.add(file));
                input.files = dataTransfer.files;
                files = Array.from(input.files);
            }

            files.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const mediaDiv = document.createElement('div');
                    mediaDiv.classList.add('media-preview', 'position-relative', 'd-inline-block', 'me-2',
                        'mb-2');

                    if (isVideo) {
                        const video = document.createElement('video');
                        video.src = e.target.result;
                        video.classList.add('img-fluid', 'rounded', 'border');
                        video.style.maxHeight = '100px';
                        video.controls = true;
                        mediaDiv.appendChild(video);
                    } else {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('img-fluid', 'rounded', 'border');
                        img.style.maxHeight = '100px';
                        mediaDiv.appendChild(img);
                    }

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'position-absolute', 'top-0',
                        'end-0', 'm-1');
                    removeBtn.innerHTML = '&times;';
                    removeBtn.addEventListener('click', function() {
                        mediaDiv.remove();
                        removeFileFromInput(input, index);
                        previewFiles(input, previewContainerId, isVideo, maxFiles);
                    });

                    mediaDiv.appendChild(removeBtn);
                    previewContainer.appendChild(mediaDiv);
                };
                reader.readAsDataURL(file);
            });
        }


        function removeFileFromInput(input, indexToRemove) {
            const dataTransfer = new DataTransfer();
            Array.from(input.files).forEach((file, index) => {
                if (index !== indexToRemove) dataTransfer.items.add(file);
            });
            input.files = dataTransfer.files;
        }
        document.getElementById('product_images').addEventListener('change', function(event) {
            validateImageInput(event);
            previewFiles(this, 'product_image_preview_container', false, 5);
        }); 
        document.getElementById('business_license_f').addEventListener('change', function(event) {
            validateImageInput(event);
            previewFiles(this, 'business_license_preview_container');
        });
    </script>
@endpush