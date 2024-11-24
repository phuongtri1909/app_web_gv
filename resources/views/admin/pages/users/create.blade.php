@extends('admin.layouts.app')

@push('styles-admin')
@endpush

@section('content-auth')
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 px-3">
                <h5 class="mb-0">Thêm tài khoản</h5>
            </div>
            <div class="card-body pt-4 p-3">

                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="form-group mb-3 col-md-6">
                            <label for="business_member_id">{{ __('Business Member') }}</label>
                            <select name="business_member_id" id="business_member_id" class="form-control @error('business_member_id') is-invalid @enderror">
                                <option value="">{{ __('Tạo tài khoản cho người dùng') }}</option>
                                @foreach($businessMembers as $businessMember)
                                    <option value="{{ $businessMember->id }}" data-business-code="{{ $businessMember->business_code }}" {{ old('business_member_id') == $businessMember->id ? 'selected' : '' }}>
                                        {{ $businessMember->business_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('business_member_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3 col-md-6" id="username-group">
                            <label for="username">Tài khoản <span class="text-danger">*</span></label>
                            <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}">
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="full_name">Tên DN/Hộ KD <span class="text-danger">*</span></label>
                            <input type="text" name="full_name" id="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}" required>
                            @error('full_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="password">Mật khẩu <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="toggle-password"><i class="fas fa-eye"></i></span>
                                </div>
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3 col-md-6">
                            <label for="status">Trạng thái <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                            </select>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label for="avatar" class="form-label">Avatar (225x225px)</label>
                                <input value="{{ old('avatar') }}" type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar">
                                @error('avatar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <img id="avatar-preview" src="#" alt="avatar Preview" style="display: none; max-width: 200px; max-height: 200px; margin-top: 10px;">
                        </div>

                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-primary">Lưu</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Trở về</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts-admin')
<script>
    $(document).ready(function() {
        function toggleUsernameField() {
            var selectedOption = $('#business_member_id').find('option:selected');
            var businessCode = selectedOption.data('business-code');

            if (businessCode) {
                $('#username-group').hide();
                $('#username').val(businessCode);
            } else {
                $('#username-group').show();
                $('#username').val({{ old('username') }});
            }
        }

        $('#business_member_id').change(function() {
            toggleUsernameField();
        });

        $('#avatar').change(function() {
            var input = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#avatar-preview').attr('src', e.target.result).show();
                }

                reader.readAsDataURL(input.files[0]);
            }
        });

        $('#toggle-password').click(function() {
            var passwordInput = $('#password');
            var icon = $(this).find('i');
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordInput.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        // Trigger change event on page load to handle old input
        toggleUsernameField();
    });
</script>
@endpush