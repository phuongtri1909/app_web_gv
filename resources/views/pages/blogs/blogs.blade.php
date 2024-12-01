@extends('layouts.app')
@section('title', $category != null ? $category->pluck('name')->implode(', ') : "Tất cả")
@section('description', $category != null ? $category->pluck('name')->implode(', ') : "Tất cả")
@section('keyword', $category != null ? $category->pluck('name')->implode(', ') : "Tất cả")


@push('styles')
    <style>
        .title-news h2 {
            text-align: center;
            color: #b70f1b;
            text-transform: uppercase;
        }

        #blogs {
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.8), rgba(195, 189, 189, 0.8)), url('../images/bg_bl.jpg') no-repeat center top / cover fixed #f3f4f6;
        }

        .posts {
            /* display: flex; */
            flex-wrap: wrap;
        }

        .flex-news {
            display: flex;
            justify-content: center;
            cursor: pointer;
            font-size: 18px;
            font-weight: 500;
        }

        .flex-news li {
            padding: 0px 10px;
        }

        .flex-news li a:hover {
            color: #b70f1b;
        }

        .flex-news li a:focus {
            color: #b70f1b;
        }

        .flex-news li a.active {
            color: #b70f1b;
        }

        .flex-news li a {
            color: #000;
        }

        .image-content img {
            width: 100%;
            height: 220px !important;
            object-fit: cover;
        }

        .post-content {
            background-color: #f5f5f5;
            border-radius: 25px;
            box-shadow: 0px 1px 10px 0px rgba(0, 0, 0, .5);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .main-content {
            padding: 10px 10px;
        }

        .title-content h3 {
            text-transform: capitalize;
            font-weight: 700;
        }

        .read-more {
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            margin-top: auto;
        }

        .read-more a {
            color: #fff;
            font-size: 15px;
            background: brown;
            padding: 3px 7px;
            border-radius: 10px;
            text-align: center;
        }

        .desc-content p {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
        }

        .position-r {
            position: relative;
            /* overflow: hidden; */
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

        @media (max-width: 768px) {
            .navigation-buttons.right {
                right: 2rem !important;
            }

        }

        .main-approach {
            height: 100%;
        }

        .content-approach {
            background-color: #369948;
            transition: all .3s ease-in-out;
            flex: 0 0 100%;
            /* padding: 20px 15px; */
            border-radius: 10px;
            height: 100%;
        }

        .main-approach:hover {
            cursor: pointer;
            box-shadow: 0 8px 16px 0 rgba(246, 1, 1, 0.5);
            border-radius: 10px;
            transition: all .3s ease-in-out;
        }

        .image-approach {
            margin-bottom: 10px;
            object-fit: cover;
        }

        .image-approach img {
            max-height: 255px;
        }

        .content-b {
            padding: 20px;
        }

        .title-approach-b h3 {
            font-size: 24px;
            font-weight: 700;
            color: #fff;
        }

        .title-approach h2 {
            text-align: center;
            margin-top: 10px;
            color: #b70f1b;
        }

        .desc-approach p {
            color: #fff;
        }

        .title-ar h2 {
            color: #b70f1b;
            text-align: center;
        }

        .boder-ri {
            border: 1px solid #fff;
            width: 100px;
        }
        .image-content {
            position: relative;
        }

        .categories-content {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(233, 212, 101, 0.8);
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        .categories-content a {
            color: #fff;
            text-decoration: none;
            margin-right: 5px;
        }

        .categories-content a:hover {
            text-decoration: underline;
            color: #e0f0ff;
        }

    </style>
@endpush

@section('content')


@switch($category != null && is_iterable($category) ? $category->pluck('slug')->contains('hoat-dong-hoi') : ($category?->slug ?? ""))
    @case('hoat-dong-hoi')
        @include('pages.components.button-register', [
            'buttonTitle' => 'ĐK Thành viên',
            'buttonLink' => route('show.form.member.business')
        ])
        @break
    @default
@endswitch
    <section id="blogs">
        <div class="container">
            <div class="row">
                {{-- @if($categories->isNotEmpty())
                    <div class="category-new mb-5">
                        <div class="col-md-12">
                            <ul class="flex-news">
                                <li>
                                    <a class="{{ request('category') == '' ? 'active' : '' }}" href="{{ route('list-blogs', $tab->slug) }}">{{ __('all') }}</a>
                                </li>
                                @foreach ($categories as $item)
                                    <li>
                                        <a href="{{ route('list-blogs', ['slug' => $tab->slug, 'category' => $item->slug]) }}"
                                            class="{{ request('category') == $item->slug ? 'active' : '' }}">{{ $item->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif --}}
                @if ($noResults)
                    <div class="content-table-contact my-5 text-center">
                        <div class="alert alert-danger" role="alert">
                            {{ __('no_find_data') }}
                        </div>
                    </div>
                @else
                    @foreach ($blogs as $blog)
                        <div class="col-md-6 posts mb-4">
                            <div class="post-content">
                                <div class="image-content position-relative">
                                    <div class="categories-content position-absolute">
                                        @foreach ($blog->categories as $category)
                                            <a href="#">{{ $category->name }}</a>
                                        @endforeach
                                    </div>
                                        <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" width="1280" height="527" decoding="async" class="img-fluid">
                                </div>
                                <div class="main-content">
                                    <div class="title-content">
                                        <h3>{{ $blog->title }}</h3>
                                    </div>
                                    <div class="desc-content">
                                        <p>{!! $blog->shortContent !!}</p>
                                    </div>
                                    <div class="read-more">
                                        <a href="{{ route('detail-blog', ['slug' => $blog->slug]) }}">Xem thêm</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                <x-pagination :paginator="$blogs" />
            </div>
        </div>
    </section>
    {{-- <div class="container mt-5">
        <div class="row">
            @forEach($tabProject as $tabs)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="main-approach">
                        <div class="content-approach">
                            <div class="image-approach">
                                <img src="{{ asset($tabs->image) }}" alt="" width="1000" height="667"
                                    style="max-width: 100%; height: auto;">
                            </div>
                            <div class="content-b">
                                <a href="{{ route('detail-blog-mini', ['slug' => $tabs->slug]) }}">
                                    <div class="title-approach-b">
                                        <h3>{{$tabs->project_name}}</h3>
                                    </div>
                                    <div class="boder-ri"></div>
                                    <div class="desc-approach">
                                        <p>
                                            {!!$tabs->content!!}
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div> --}}
    {{-- <div class="container-kids position-r mt-4">
        @if (
            $forumsCp3->isNotEmpty() &&
                $forumsCp3->contains(function ($forum) {
                    return !empty($forum->image);
                }))
            <div class="navigation-buttons left">
                <button onclick="prevImage()">&#10094;</button>
            </div>
            <div class="gallery-container">
                <h2>{{ __('gallery') }}</h2>
                <div class="main-image" id="mainImageContainer">
                    @foreach ($forumsCp3 as $forum)
                        @foreach ($forum->image as $index => $imagePath)
                            <img id="mainDisplay-{{ $forum->id }}-{{ $index }}" src="{{ asset($imagePath) }}"
                                alt="Main Image" style="{{ $index === 0 ? '' : 'display:none;' }}" />
                        @endforeach
                    @endforeach
                </div>

                <div class="thumbnail-gallery">
                    @foreach ($forumsCp3 as $forum)
                        @foreach ($forum->image as $index => $imagePath)
                            <img src="{{ asset($imagePath) }}" alt="Thumbnail"
                                onclick="changeImage({{ $forum->id }}, {{ $index }})" />
                        @endforeach
                    @endforeach
                </div>
            </div>
            <div class="navigation-buttons right">
                <button onclick="nextImage()">&#10095;</button>
            </div>
        @endif
    </div> --}}
@endsection

@push('scripts')
    <script>
        let currentForumIndex = {};

        function changeImage(forumId, index) {
            const mainImageContainer = document.getElementById('mainImageContainer');

            const imageElements = mainImageContainer.querySelectorAll(`img[id^="mainDisplay-${forumId}"]`);


            imageElements.forEach((img) => {
                img.style.display = 'none';
            });

            imageElements[index].style.display = 'block';
            currentForumIndex[forumId] = index;
        }


        function prevImage() {
            for (let forumId in currentForumIndex) {
                currentForumIndex[forumId]--;
                const imageElements = document.querySelectorAll(`img[id^="mainDisplay-${forumId}"]`);

                if (currentForumIndex[forumId] < 0) {
                    currentForumIndex[forumId] = imageElements.length - 1;
                }
                changeImage(forumId, currentForumIndex[forumId]);
            }
        }

        function nextImage() {
            for (let forumId in currentForumIndex) {
                currentForumIndex[forumId]++; // Tăng chỉ số
                const imageElements = document.querySelectorAll(`img[id^="mainDisplay-${forumId}"]`);

                if (currentForumIndex[forumId] >= imageElements.length) {
                    currentForumIndex[forumId] = 0;
                }
                changeImage(forumId, currentForumIndex[forumId]);
            }
        }

        // Auto slide function
        function autoSlide() {
            for (let forumId in currentForumIndex) {
                nextImage(forumId);
            }
        }

        setInterval(autoSlide, 10000);
    </script>
@endpush
