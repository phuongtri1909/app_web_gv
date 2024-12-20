@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Chỉnh sửa chi tiết phường</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('ward-detail.update', $wardDetail->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="ward_govap_id">Tên phường</label>
                                    <select name="ward_govap_id" id="ward_govap_id" class="form-control @error('ward_govap_id') is-invalid @enderror" required>
                                        <option value="">Chọn phường</option>
                                        @foreach($wardGovaps as $wardGovap)
                                            <option value="{{ $wardGovap->id }}" {{ old('ward_govap_id', $wardDetail->ward_govap_id) == $wardGovap->id ? 'selected' : '' }}>{{ $wardGovap->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('ward_govap_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="area">Diện tích</label>
                                    <input value="{{ old('area', $wardDetail->area) }}" type="text" class="form-control @error('area') is-invalid @enderror" id="area" name="area" required>
                                    @error('area')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="total_households">Tổng số hộ</label>
                                    <input value="{{ old('total_households', $wardDetail->total_households) }}" type="text" class="form-control @error('total_households') is-invalid @enderror" id="total_households" name="total_households" required>
                                    @error('total_households')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('update') }}</button>
                        <a href="{{ route('ward-detail.index') }}" class="btn btn-secondary">{{ __('cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
