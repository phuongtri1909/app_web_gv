@extends('pages.layouts.page')
@section('title', __('gallery'))
@section('description', 'Description for Child Page')
@section('keyword', 'child, page, keywords,gallery')
@section('title-page', __('gallery'))
@section('bg-page', 'images/bg-dev.jpg')

@push('child-styles')
    <style>
        .position-r {
            position: relative;
        }

        .gallery-container {
            text-align: center;
        }

        .main-image {
            display: flex;
            transition: opacity 0.5s ease;
            margin-bottom: 10px;
        }

        .main-image img {
            width: 100%;
            flex-shrink: 0;
            height: auto;
            display: none;
        }

        .main-image img:first-child {
            display: block;
        }

        .thumbnail-gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        .thumbnail-gallery img {
            width: calc(100% / 6 - 10px);
            max-height: 118px;
            cursor: pointer;
            object-fit: cover;
            border: 2px solid transparent;
            transition: border-color 0.3s;
        }

        .thumbnail-gallery img:hover {
            border-color: #007BFF;
        }

        .navigation-buttons {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        .navigation-buttons.left {
            left: -5rem;
        }

        .navigation-buttons.right {
            right: -5rem;
        }

        .navigation-buttons button {
            background-color: rgba(225, 225, 225, 0.5);
            color: #80b157;
            border: none;
            padding: 15px 15px 15px 10px;
            cursor: pointer;
            height: 30px;
            width: 30px;
            font-size: 24px;
            border-radius: 50%;
            font-weight: 700;
            display: inline-flex;
            justify-items: center;
            align-items: center;
        }

        .navigation-buttons button:hover {
            background-color: rgb(227, 60, 60);
        }
    </style>
@endpush

@section('content-page')
    <div class="container-kids position-r">
        @if (!empty($project) && $project->details && $project->details->isNotEmpty())
            <div class="navigation-buttons left">
                <button onclick="prevImage()">&#10094;</button>
            </div>
            <div class="gallery-container">
                {{-- <h2>{{ __('gallery') }}</h2> --}}
                <div class="main-image" id="mainImageContainer">
                    @forelse ($project->details as $index => $detail)
                        <img id="mainDisplay-{{ $index }}" src="{{ asset($detail->image) }}"
                            alt="Main Image" style="{{ $index === 0 ? 'display:block;' : 'display:none;' }}" />
                    @empty
                        <p class="text-center">Không có dữ liệu</p>
                    @endforelse
                </div>

                <div class="thumbnail-gallery">
                    @forelse ($project->details as $index => $detail)
                        <img src="{{ asset($detail->image) }}" alt="Thumbnail"
                            onclick="changeImage({{ $index }})" />
                    @empty
                        <p class="text-center">Không có dữ liệu</p>
                    @endforelse
                </div>
            </div>
            <div class="navigation-buttons right">
                <button onclick="nextImage()">&#10095;</button>
            </div>
        @else
            <p>No images available for this album.</p>
        @endif
    </div>
@endsection

@push('child-scripts')
    <script>
        let currentImageIndex = 0;

        function changeImage(index) {
            const imageElements = document.querySelectorAll('#mainImageContainer img');

            imageElements.forEach((img) => {
                img.style.display = 'none';
            });

            if (imageElements[index]) {
                imageElements[index].style.display = 'block';
                currentImageIndex = index;
            }
        }

        function prevImage() {
            const imageElements = document.querySelectorAll('#mainImageContainer img');

            currentImageIndex--;

            if (currentImageIndex < 0) {
                currentImageIndex = imageElements.length - 1;
            }

            changeImage(currentImageIndex);
        }

        function nextImage() {
            const imageElements = document.querySelectorAll('#mainImageContainer img');

            currentImageIndex++;

            if (currentImageIndex >= imageElements.length) {
                currentImageIndex = 0;
            }

            changeImage(currentImageIndex);
        }


        function autoSlide() {
            nextImage();
        }

        setInterval(autoSlide, 10000);
    </script>
@endpush
