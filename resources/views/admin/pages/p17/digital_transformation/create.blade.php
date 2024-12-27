@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Thêm 
                        @if (auth()->user()->unit->unit_code == 'P17')
                            chuyển đổi số
                        @else
                            liên kết
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('digital-transformations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="title">Tiêu đề</label>
                                    <input value="{{ old('title') }}" type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="link">Url</label>
                                    <input value="{{ old('link') }}" type="url" class="form-control @error('link') is-invalid @enderror" id="link" name="link" required>
                                    @error('link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="image">Ảnh (380x160px)</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" required>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div id="image-preview" class="mt-2">
                                        <!-- Preview image will be displayed here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('create') }}</button>
                        <a href="{{ route('digital-transformations.index') }}" class="btn btn-secondary">{{ __('cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            const input = event.target;
            const previewContainer = document.getElementById('image-preview');
            previewContainer.innerHTML = '';

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '380px';
                    img.style.height = '160px';
                    img.classList.add('img-fluid');
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
    </script>
@endpush
