@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Chỉnh sửa ngành nghề</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('business-fields.update', $businessField->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Tên ngành nghề</label>
                                    <input value="{{ old('name', $businessField->name) }}" type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="icon">Icon (Lưu ý: Xóa backgroud trước ghi tải lên)</label>
                                    <input type="file" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" accept="image/*">
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div id="icon-preview" class="mt-2">
                                        @if($businessField->icon)
                                            <img src="{{ asset($businessField->icon) }}" style="width: 45px; height: 45px;" class="img-fluid rounded">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('update') }}</button>
                        <a href="{{ route('business-fields.index') }}" class="btn btn-secondary">{{ __('cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    <script>
        document.getElementById('icon').addEventListener('change', function(event) {
            const input = event.target;
            const previewContainer = document.getElementById('icon-preview');
            previewContainer.innerHTML = '';

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '45px';
                    img.style.height = '45px';
                    img.classList.add('img-fluid', 'rounded');
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
    </script>
@endpush