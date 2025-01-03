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
                <div class="col-md-12 mb-4">
                    @if($category != null && is_iterable($category) ? $category->pluck('slug')->contains('hoat-dong-xuc-tien') : ($category?->slug ?? ""))
                        <form method="GET" action="{{ route('list-blogs') }}">
                            <input type="hidden" name="category" value="hoat-dong-xuc-tien">
                            <div class="form-group">
                                <select id="subCategory" name="subCategory" class="form-control" onchange="this.form.submit()">
                                    <option value="all" {{ request('subCategory') === 'all' ? 'selected' : '' }}>{{ __('Tất cả') }}</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->slug }}" {{ request('subCategory') === $item->slug ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                   
                                </select>
                            </div>
                        </form>
                    @endif
                </div>
               
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
