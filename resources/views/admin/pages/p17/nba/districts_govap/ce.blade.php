@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">{{ isset($district) ? 'Chỉnh sửa Khu Phố' : 'Thêm Khu Phố' }}</h5>
                </div>
                <div class="card-body px-0 pt-0 pb-2 px-4">
                  <form action="{{ isset($district) ? route('ward-detail.districts.update', [$district->ward_detail_id, $district->id]) : route('ward-detail.districts.store', $wardDetail->id) }}"
                        method="POST">
                        @csrf
                        @if(isset($district))
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="form-group col-12 col-md-6">
                                <label for="name">Tên Khu Phố <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $district->name ?? '') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="wardDetail">Phường <span class="text-danger">*</span></label>
                                <select class="form-control @error('ward_detail_id') is-invalid @enderror"
                                    id="wardDetail" name="ward_detail_id" required>
                                    <option value="" disabled {{ isset($district) ? '' : 'selected' }}>Chọn Phường</option>
                                    @foreach ($wardDetails as $ward)
                                        <option value="{{ $ward->id }}"
                                            {{ old('ward_detail_id', $district->ward_detail_id ?? '') == $ward->id ? 'selected' : '' }}>
                                            {{ $ward->wardGovap->name }} ({{ $ward->area }} ha)
                                        </option>
                                    @endforeach
                                </select>
                                @error('ward_detail_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="area">Diện Tích (ha) <span class="text-danger">*</span></label>
                                <input type="number" step="0.001" class="form-control @error('area') is-invalid @enderror"
                                    id="area" name="area" value="{{ old('area', $district->area ?? '') }}" required>
                                @error('area')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="totalHouseholds">Tổng Số Hộ <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('total_households') is-invalid @enderror"
                                    id="totalHouseholds" name="total_households"
                                    value="{{ old('total_households', $district->total_households ?? '') }}" required>
                                @error('total_households')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="population">Dân Số <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('population') is-invalid @enderror"
                                    id="population" name="population"
                                    value="{{ old('population', $district->population ?? '') }}" required>
                                @error('population')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="secretaryName">Bí Thư</label>
                                <input type="text" class="form-control @error('secretary_name') is-invalid @enderror"
                                    id="secretaryName" name="secretary_name"
                                    value="{{ old('secretary_name', $district->secretary_name ?? '') }}">
                                @error('secretary_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="headName">Trưởng Khu Phố</label>
                                <input type="text" class="form-control @error('head_name') is-invalid @enderror"
                                    id="headName" name="head_name"
                                    value="{{ old('head_name', $district->head_name ?? '') }}">
                                @error('head_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ isset($district) ? 'Cập Nhật' : 'Thêm Khu Phố' }}
                        </button>
                        <a href="{{ isset($district) ? route('ward-detail.districts', $district->ward_detail_id) : route('ward-detail.districts', $wardDetail->id) }}" class="btn btn-secondary">{{ __('cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
