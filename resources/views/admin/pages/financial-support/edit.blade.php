@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <h5 class="mb-0">{{ __('Cập nhật dịch vụ tài trợ') }}</h5>
                </div>
                <div class="card-body pt-4 p-3">

                    @include('admin.pages.notification.success-error')

                    <form action="{{ route('financial-support.update', $financialSupport->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="form-group mb-3 col-md-6">
                                <label for="name">{{ __('name') }}:</label>
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $financialSupport->name) }}" onkeyup="generateUrl()" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3 col-12 col-md-6">
                            <label for="url">{{ __('URL') }}</label>
                            <input type="url" name="url" id="url"
                                   class="form-control @error('url') is-invalid @enderror"
                                   value="{{ old('url', $financialSupport->url_financial_support) }}" readonly>
                            @error('url')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-12 col-md-12">
                            <div class="mb-3">
                                <label for="avt_financial_support" class="form-label">{{ __('Ảnh') }}</label>
                                <input value="{{ old('avt_financial_support', $financialSupport->avt_financial_support) }}" type="file"
                                       class="form-control @error('avt_financial_support') is-invalid @enderror"
                                       id="avt_financial_support" name="avt_financial_support">
                                @error('avt_financial_support')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @if($financialSupport->avt_financial_support)
                                <img id="image-preview" src="{{ asset($financialSupport->avt_financial_support) }}" alt="Image Preview"
                                     style="display: block; max-width: 200px; max-height: 200px; margin-top: 10px;">
                            @else
                                <img id="image-preview" src="#" alt="Image Preview"
                                     style="display: none; max-width: 200px; max-height: 200px; margin-top: 10px;">
                            @endif
                        </div>
                        <div class="form-group mb-3 col-md-12">
                            <label for="bank_id">{{ __('Chọn ngân hàng') }}</label>
                            <select name="bank_id" id="bank_id" class="form-control @error('bank_id') is-invalid @enderror" required>
                                <option value="">{{ __('Chọn ngân hàng') }}</option>
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->id }}" {{ $financialSupport->bank_id == $bank->id ? 'selected' : '' }}>
                                        {{ $bank->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bank_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn bg-gradient-primary">{{ __('Cập nhật') }}</button>
                            <a href="{{ route('financial-support.index') }}" class="btn btn-secondary">{{ __('Hủy') }}</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    <script src="https://cdn.tiny.cloud/1/zjp51ea7s0xnyrx2gv55bqdfz99zaqaugg0w5fbt5uxu5q2q/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        $(document).ready(function() {
            $('#avt_financial_support').change(function() {
                var input = this;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#image-preview').attr('src', e.target.result).show();
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            });
        });

        function generateUrl() {
            let nameField = document.querySelector('input[name="name"]');
            let urlField = document.getElementById('url');
            if (nameField.value) {
                let nameValue = nameField.value.trim();
                let slug = nameValue
                    .toLowerCase()
                    .normalize("NFD")
                    .replace(/[\u0300-\u036f]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/[^\w\-]+/g, '')
                    .replace(/\-\-+/g, '-')
                    .replace(/^-+|-+$/g, '');
                urlField.value = '{{ env('APP_URL') }}/client/post-detail/' + slug;
            } else {
                urlField.value = '';
            }
        }
    </script>
@endpush
