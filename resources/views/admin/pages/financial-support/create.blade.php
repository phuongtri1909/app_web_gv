@extends('admin.layouts.app')

@push('styles-admin')
@endpush

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <h5 class="mb-0">{{ __('Tạo dịch vụ tài trợ mới') }}</h5>
                </div>
                <div class="card-body pt-4 p-3">

                    @include('admin.pages.notification.success-error')

                    <form action="{{ route('financial-support.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            @foreach ($languages as $language)
                                <div class="form-group mb-3 col-md-6">
                                    <label for="{{ 'name_' . $language->locale }}">{{ __('name') }}:
                                        {{ $language->name }}</label>
                                    <input type="text" name="{{ 'name_' . $language->locale }}"
                                        id="{{ 'name_' . $language->locale }}"
                                        class="form-control @error('name_' . $language->locale) is-invalid @enderror"
                                        value="{{ old('name_' . $language->locale) }}" required onkeyup="generateUrl()">
                                    @error('name_' . $language->locale)
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @endforeach

                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="avt_financial_support" class="form-label">{{ __('Ảnh') }}</label>
                                    <input value="{{ old('avt_financial_support') }}" type="file"
                                        class="form-control @error('avt_financial_support') is-invalid @enderror"
                                        id="avt_financial_support" name="avt_financial_support">
                                    @error('avt_financial_support')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <img id="image-preview" src="#" alt="Image Preview"
                                    style="display: none; max-width: 200px; max-height: 200px; margin-top: 10px;">
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="url" class="form-label">{{ __('URL') }}</label>
                                    <input type="text" id="url" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3 col-md-12">
                            <label for="bank_id">{{ __('Chọn ngân hàng') }}</label>
                            <select name="bank_id" id="bank_id" class="form-control @error('bank_id') is-invalid @enderror" required>
                                <option value="">{{ __('Chọn ngân hàng') }}</option>
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                @endforeach
                            </select>
                            @error('bank_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn bg-gradient-primary">{{ __('create') }}</button>
                            <a href="{{ route('financial-support.index') }}"
                                class="btn btn-secondary">{{ __('cancel') }}</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    <script src="https://cdn.tiny.cloud/1/zjp51ea7s0xnyrx2gv55bqdfz99zaqaugg0w5fbt5uxu5q2q/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>

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
            let nameField = document.querySelector('input[name="name_' + "{{ config('app.locale') }}" + '"]');
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
