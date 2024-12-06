@extends('admin.layouts.app')

@push('styles-admin')
@endpush

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <h5 class="mb-0">{{ __('Tạo email mới') }}</h5>
                </div>
                <div class="card-body pt-4 p-3">

                    @include('admin.pages.notification.success-error')

                    <form action="{{ route('emails.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Loại email -->
                            <div class="form-group mb-3 col-md-6">
                                <label for="type">{{ __('Loại email') }}:</label>
                                <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                    <option value="">{{ __('Chọn loại email') }}</option>
                                    <option value="ncb" {{ old('type') == 'ncb' ? 'selected' : '' }}>{{ __('NCB') }}</option>
                                    <option value="bank" {{ old('type') == 'bank' ? 'selected' : '' }}>{{ __('Ngân hàng') }}</option>
                                </select>
                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                    
                            <!-- Tên khóa email -->
                            <div class="form-group mb-3 col-md-6">
                                <label for="key_name">{{ __('Tên khóa (VD: ncb, vcb, ...)') }}:</label>
                                <input type="text" name="key_name" id="key_name" class="form-control @error('key_name') is-invalid @enderror" value="{{ old('key_name') }}" required>
                                @error('key_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                    
                            <!-- Tên ngân hàng -->
                            <div class="form-group mb-3 col-md-6">
                                <label for="bank_name">{{ __('Tên ngân hàng (nếu type = bank)') }}:</label>
                                <input type="text" name="bank_name" id="bank_name" class="form-control @error('bank_name') is-invalid @enderror" value="{{ old('bank_name') }}">
                                @error('bank_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                    
                            <!-- Địa chỉ email -->
                            <div class="form-group mb-3 col-md-6">
                                <label for="email">{{ __('Địa chỉ email') }}:</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                    
                            <!-- Chọn mẫu email -->
                            <div class="form-group mb-3 col-md-12">
                                <label for="template_id">{{ __('Chọn mẫu email') }}:</label>
                                <select name="template_id" id="template_id" class="form-control @error('template_id') is-invalid @enderror">
                                    <option value="">{{ __('Chọn mẫu email') }}</option>
                                    @foreach($templates as $template)
                                        <option value="{{ $template->id }}" {{ old('template_id') == $template->id ? 'selected' : '' }}>
                                            {{ $template->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('template_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    
                        <div class="text-center">
                            <button type="submit" class="btn bg-gradient-primary">{{ __('Tạo email') }}</button>
                            <a href="{{ route('emails.index') }}" class="btn btn-secondary">{{ __('Hủy') }}</a>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    <script>
       
    </script>
@endpush