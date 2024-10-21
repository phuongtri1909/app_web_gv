@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">{{ __('Chỉnh sửa ngân hàng') }}</h5>
                </div>
                <div class="card-body">
                    @include('admin.pages.notification.success-error')
                    <form action="{{ route('banks.update', $banks->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="form-group mb-3 col-md-12">
                                <label for="name">{{ __('Tên ngân hàng') }}</label>
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $banks->name) }}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3 col-md-12">
                                <label for="avt_bank">{{ __('Ảnh ngân hàng') }}</label>
                                <input type="file" name="avt_bank" id="avt_bank"
                                       class="form-control @error('avt_bank') is-invalid @enderror"
                                       accept="image/*">
                                @error('avt_bank')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @if ($banks->avt_bank)
                                    <div class="mt-2">
                                        <img src="{{ asset($banks->avt_bank) }}" alt="Current Image" style="max-width: 100px; max-height: 100px;">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Cập nhật') }}</button>
                        <a href="{{ route('banks.index') }}" class="btn btn-secondary">{{ __('Hủy') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
