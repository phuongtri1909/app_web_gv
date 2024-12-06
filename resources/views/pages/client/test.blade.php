

@extends('layouts.app')
@section('title', 'Kết nối giao thương')
@section('description', 'Kết nối giao thương')
@section('keyword', 'Kết nối giao thương')
@push('styles')
    <style>
        .preview-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin: 5px;
        }
    </style>
@endpush

@section('content')
<input type="file" id="file-input" multiple class="form-control">
<div id="preview-container"></div>
@endsection


@push('scripts')
<script>
    document.getElementById('file-input').addEventListener('change', function(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('preview-container');
        previewContainer.innerHTML = ''; // Clear previous images

        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('preview-img');
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endpush
