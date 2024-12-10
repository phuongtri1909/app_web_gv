@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Thêm danh mục quảng cáo</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('ad-categories.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">Tên danh mục quảng cáo</label>
                                    <input value="{{ old('name') }}" type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('create') }}</button>
                        <a href="{{ route('ad-categories.index') }}" class="btn btn-secondary">{{ __('cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
   
@endpush