@extends('layouts.app')
@section('title', 'Ý kiên doanh nghiệp')
@section('description', 'Ý kiên doanh nghiệp')
@push('styles')
    <style>
        .form-control:focus,
        .form-control:hover,
        .upload-label:focus,
        .upload-label:hover {
            border-color: #80bdff;
            box-shadow: 0 0 5px rgba(128, 189, 255, 0.5);
            outline: 0;
        }
        .btn-success{
            background-color: #0056b3;
            transition: background-color 0.3s ease;
        }
        .btn-success:hover{
            background-color: #004494;
        }

        .error-message,
        .error-message1 {
            color: red;
            margin-top: 10px;
            font-size:12px;
        }
        #form-business-opinion {
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
{{-- {{dd($isKhaoSat)}} --}}
    @switch($isKhaoSat)
        @case(true)
            @include('pages.components.button-register', [
                'buttonTitle' => 'Khảo sát',
                'buttonLink' => route('business.survey')
            ])
            @break
        @default
    @endswitch
    <section id="form-business-opinion" class="form-business-opinion mt-5rem">
        <div class="container">
            <div class="row">

                <form id="business-opinion"action="{{route('business.opinion.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="business_member_id" value="{{ $business_member_id }}">
                        <div class="col-md-12 mb-4">
                            <label for="opinion" class="form-label">Ý kiến <span class="text-danger">*</span></label>
                            <textarea class="form-control form-control-sm @error('opinion') is-invalid @enderror" id="opinion" name="opinion" placeholder="Nhập ý kiến" >{{ old('opinion') }}</textarea>
                            <span class="error-message"></span>
                            @error('opinion')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-4">
                            <label for="attached_images" class="form-label">Hình ảnh đính kèm <span class="text-danger">*</span></label>
                            <input type="file" class="form-control form-control-sm @error('attached_images') is-invalid @enderror" id="attached_images" name="attached_images[]" multiple accept="image/*"  >
                            <span class="error-message"></span>
                            @error('attached_images')
                                <div class="invalid-feedback" role="alert">{{ $message }}</div>
                            @enderror
                            <div id="image_preview_container" class="mt-3"></div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                    </div>
                    @if ($errors->has('error'))
                        <div class="invalid-feedback d-block text-center" role="alert">{{ $errors->first('error') }}</div>
                    @endif
                    <div id="recaptcha-error" class="text-danger text-center mt-2"></div>
                    <div class="text-end my-3">
                        <button type="submit" class=" bg-app-gv btn text-white">Gửi ý kiến</button>
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
        document.getElementById('attached_images').addEventListener('change', function(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('image_preview_container');
            previewContainer.innerHTML = ''; // Clear previous previews

            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgDiv = document.createElement('div');
                    imgDiv.classList.add('image-preview', 'position-relative', 'd-inline-block', 'me-2', 'mb-2');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-fluid', 'rounded', 'border');
                    img.style.maxHeight = '100px';

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'position-absolute', 'top-0', 'end-0', 'm-1');
                    removeBtn.innerHTML = '&times;';
                    removeBtn.addEventListener('click', function() {
                        imgDiv.remove();
                    });

                    imgDiv.appendChild(img);
                    imgDiv.appendChild(removeBtn);
                    previewContainer.appendChild(imgDiv);
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endpush
