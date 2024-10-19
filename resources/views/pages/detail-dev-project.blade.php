@extends('pages.layouts.page')
@section('title', __('title_dev_mini'))
@section('description', 'Description for Child Page')
@section('keyword', 'child, page, keywords')
@section('title-page', __('title_page_dev_mini'))
@section('bg-page', 'images/bg-dev.jpg')

@push('child-styles')
    <style>
        @media (max-width: 576px) {
        #projects .grid-item {
            width: 100% !important;
            margin-left: unset !important;
        }

        #projects .grid {
            margin-left: 0 !important;
        }
    }

    #projects .grid {
        display: flex;
        flex-wrap: wrap;
        margin-left: -10px;
        width: auto;
    }

    #projects .grid-item {
        margin-left: 10px;
        margin-bottom: 10px;
        width: calc(33.333% - 10px);
    }

    #projects .grid-item img {
        display: block;
        max-width: 100%;
        height: auto;
    }
    </style>
@endpush

@section('content-page')
    <section id="projects">
        <div class="container-kids">
            <div class="container-img my-5">
                <div class="grid">
                    @forelse ($project->images as $image)
                        <div class="grid-item">
                            <a href="{{ asset($image->image) }}" data-fancybox="gallery">
                                <img loading="lazy" src="{{ asset($image->image) }}" alt="Image">
                            </a>
                        </div>
                    @empty
                        <p class="text-center">Không có dữ liệu</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
            var elem = document.querySelector('.grid');
            var msnry;

            imagesLoaded(elem, function() {
                msnry = new Masonry(elem, {
                    itemSelector: '.grid-item',
                    columnWidth: '.grid-item',

                });
            });
        });
</script>
@endpush
