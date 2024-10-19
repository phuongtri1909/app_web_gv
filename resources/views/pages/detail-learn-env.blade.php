@extends('pages.layouts.page')
@section('title', __('title_learn_env'))
@section('description', 'Page Environment')
@section('keyword', 'Environment, environment page, environment brighton academy')
@section('title-page', __('learning_environment'))
@push('child-styles')
    <style>
        @media (max-width: 576px) {
            .grid-item {
                width: 100% !important;
                margin-left: unset !important;
            }

            .grid {
                margin-left: 0 !important;
            }
        }

        .grid {
            display: flex;
            flex-wrap: wrap;
            margin-left: -10px;
            width: auto;
        }

        .grid-item {
            margin-left: 10px;
            margin-bottom: 10px;
            width: calc(33.333% - 10px);
            box-sizing: border-box;
        }

        .grid-item img {
            display: block;
            max-width: 100%;
            height: 270px;
            object-fit: cover;
        }

        .grid-item video {
            display: block;
            max-width: 100%;
            height: 270px;
            object-fit: cover;
        }

        .grid-item video {
            position: relative;
            cursor: pointer;
        }

        .grid-item video::before {
            content: '▶️';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 2rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .fancybox-inner {

            top: 10rem;
        }

        .fancybox-thumbs__list {

            top: 6rem;
        }
    </style>
@endpush

@section('content-page')
    <section id="#projects">
        <div class="container">
            <div class="container-img my-5">
                <div class="grid">
                    @forelse ($mediaItem as $item)
                        @if ($item->type == 'image')
                            <div class="grid-item">
                                <a href="{{ asset($item->file_path) }}" data-fancybox="gallery">
                                    <img loading="lazy" src="{{ asset($item->file_path) }}" alt="Image">
                                </a>
                            </div>
                        @elseif ($item->type == 'video')
                            <div class="grid-item">
                                <a href="{{ asset($item->file_path) }}" data-fancybox="gallery">
                                    <video preload="metadata" controls>
                                        <source src="{{ asset($item->file_path) }}" type="video/mp4">
                                    </video>
                                </a>
                            </div>
                        @endif
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection

@push('child-scripts')
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3/dist/jquery.fancybox.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elem = document.querySelector('.grid');
            if (elem) {
                imagesLoaded(elem, function() {
                    new Masonry(elem, {
                        itemSelector: '.grid-item',
                        columnWidth: '.grid-item',
                    });
                });
            }

            Fancybox.bind('[data-fancybox="gallery"]', {
                buttons: [
                    "slideShow",
                    "thumbs",
                    "zoom",
                    "fullScreen",
                    "share",
                    "close"
                ],
                loop: false,
                protect: true
            });
        });
    </script>
@endpush
