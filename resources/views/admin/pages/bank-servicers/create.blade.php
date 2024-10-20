@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">{{ __('Thêm dịch vụ mới') }}</h5>
                </div>
                <div class="card-body">
                    @include('admin.pages.notification.success-error')
                    <form action="{{ route('bank-servicers.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group mb-3 col-md-12">
                                <label for="name">{{ __('Tên dịch vụ') }}</label>
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror" required
                                       value="{{ old('name') }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('create') }}</button>
                        <a href="{{ route('bank-servicers.index') }}" class="btn btn-secondary">{{ __('cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
