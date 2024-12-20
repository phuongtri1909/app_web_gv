@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">{{ isset($block) ? 'Chỉnh sửa tổ dân phố' : 'Thêm tổ dân phố' }}</h5>
                </div>
                <div class="card-body px-0 pt-0 pb-2 px-4">
                    <form action="{{ isset($block) ? route('blocks.update', [ $district->id, $block->id]) : route('blocks.store', $district->id) }}" method="POST">
                        @csrf
                        @if(isset($block))
                            @method('PUT')
                        @endif
                        <div class="row">

                            <div class="form-group col-12 col-md-6">
                                <label for="name">Tên tổ dân phố <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $block->name ?? '') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="totalHouseholds">Tổng Số Hộ <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('total_households') is-invalid @enderror"
                                    id="totalHouseholds" name="total_households"
                                    value="{{ old('total_households', $block->total_households ?? '') }}" required>
                                @error('total_households')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ isset($block) ? 'Cập nhật' : 'Thêm' }}</button>
                        <a href="{{ route('blocks', $district->id) }}" class="btn btn-secondary">Hủy</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
