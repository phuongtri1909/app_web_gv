@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">{{ isset($category) ? 'Chỉnh sửa danh mục thị trường' : 'Thêm mới danh mục thị trường' }}</h5>
                </div>
                <div class="card-body px-4 pt-4 pb-2">
                    <form action="{{ isset($category) ? route('category-market.update', $category->id) : route('category-market.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($category))
                            @method('PUT')
                        @endif

                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Tên danh mục</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', isset($category) ? $category->name : '') }}" placeholder="Nhập tên danh mục" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="banner" class="form-label">Ảnh banner</label>
                            <input type="file" name="banner" id="banner" class="form-control @error('banner') is-invalid @enderror">
                            @if(isset($category) && $category->banner)
                                <img src="{{ asset( $category->banner) }}" width="100" class="my-2" alt="Banner hiện tại">
                            @endif
                            @error('banner')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <img id="image-preview" src="#" alt="Image Preview" style="display: none; max-width: 200px; max-height: 200px; margin-top: 10px;">
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('category-market.index') }}" class="btn btn-secondary me-2">Hủy</a>
                            <button type="submit" class="btn btn-primary">{{ isset($category) ? 'Cập nhật' : 'Thêm mới' }}</button>
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
            $('#banner').change(function() {
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
    </script>
@endpush