@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Thêm hộ kinh doanh</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('business-households.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="license_number">Số giấy phép</label>
                                    <input value="{{ old('license_number') }}" type="text" class="form-control @error('license_number') is-invalid @enderror" id="license_number" name="license_number" required>
                                    @error('license_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="date_issued">Ngày cấp</label>
                                    <input value="{{ old('date_issued') }}" type="date" class="form-control @error('date_issued') is-invalid @enderror" id="date_issued" name="date_issued" required>
                                    @error('date_issued')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="business_owner_full_name">Tên chủ hộ kinh doanh</label>
                                    <input value="{{ old('business_owner_full_name') }}" type="text" class="form-control @error('business_owner_full_name') is-invalid @enderror" id="business_owner_full_name" name="business_owner_full_name" required>
                                    @error('business_owner_full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="business_dob">Ngày sinh chủ hộ</label>
                                    <input value="{{ old('business_dob') }}" type="date" class="form-control @error('business_dob') is-invalid @enderror" id="business_dob" name="business_dob" required>
                                    @error('business_dob')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="house_number">Số nhà</label>
                                    <input value="{{ old('house_number') }}" type="text" class="form-control @error('house_number') is-invalid @enderror" id="house_number" name="house_number" required>
                                    @error('house_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="road_id">Đường</label>
                                    <select name="road_id" id="road_id" class="form-control @error('road_id') is-invalid @enderror" required>
                                        <option value="">Chọn đường</option>
                                        @foreach($roads as $road)
                                            <option value="{{ $road->id }}" {{ old('road_id') == $road->id ? 'selected' : '' }}>{{ $road->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('road_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="category_market_id">Chọn loại chợ</label>
                                    <select name="category_market_id" id="category_market_id" class="form-control">
                                        <option value="">Chọn loại chợ</option>
                                        @foreach($categoryMarkets as $category)
                                            <option value="{{ $category->id }}" {{ old('category_market_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="signboard">Biển hiệu</label>
                                    <input value="{{ old('signboard') }}" type="text" class="form-control @error('signboard') is-invalid @enderror" id="signboard" name="signboard">
                                    @error('signboard')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="business_field">Lĩnh vực</label>
                                    <input value="{{ old('business_field') }}" type="text" class="form-control @error('business_field') is-invalid @enderror" id="business_field" name="business_field" required>
                                    @error('business_field')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="phone">Số điện thoại</label>
                                    <input value="{{ old('phone') }}" type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="cccd">Số CCCD</label>
                                    <input value="{{ old('cccd') }}" type="text" class="form-control @error('cccd') is-invalid @enderror" id="cccd" name="cccd" required>
                                    @error('cccd')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="address">Địa chỉ</label>
                                    <input value="{{ old('address') }}" type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" required>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="status">Trạng thái</label>
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Lưu</button>
                                <a href="{{ route('business-households.index') }}" class="btn btn-secondary">Hủy</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
