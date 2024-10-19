@extends('pages.layouts.page')
@section('title', $blog->title)
@section('description', $blog->content)
@section('keyword', )
@section('title-page', __('news'))


@push('child-styles')
    <style>
        .post-detail-container {
            margin: 30px auto;
            padding: 20px;
            max-width: 1000px;
            border-radius: 10px;
        }

        .post-title {
            font-size: 2.4em;
            font-weight: bold;
            color: #b70f1b;
            margin-bottom: 15px;
        }

        .post-meta {
            font-size: 0.9em;
            color: #666;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
        }

        .post-meta span {
            margin-right: 20px;
            display: inline-block;
        }

        .post-meta .categories,
        .post-meta .tags {
            font-weight: bold;
            color: #333;
        }

        .post-meta .categories a,
        .post-meta .tags a {
            text-decoration: none;
            color: #007BFF;
            margin-right: 10px;
            transition: color 0.3s ease;
        }

        .post-meta .categories a:hover,
        .post-meta .tags a:hover {
            color: #0056b3;
        }

        .post-tags {
            margin-top: 20px;
        }

        .post-tags h4 {
            font-size: 1.2em;
            margin-bottom: 10px;
            color: #333;
        }

        .post-tags ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .post-tags ul li {
            display: inline-block;
            margin-right: 10px;
        }

        .post-tags ul li a {
            text-decoration: none;
            color: #28a745;
            font-size: 0.9em;
        }

        .post-tags ul li a:hover {
            color: #1c7430;
        }


        .post-image {
            margin-bottom: 20px;
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .post-content {
            line-height: 1.6em;
            font-size: 1.1em;
            color: #333;
        }

        .post-content img {
            max-width: 100%;
            height: auto;
            margin: 0 auto;
            display: block;
        }

        .post-content p img {
            text-align: center;
        }

        .related-posts {
            margin-top: 50px;
        }

        .related-posts h4 {
            font-size: 1.8em;
            margin-bottom: 15px;
        }

        .related-post {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .related-post img {
            /* width: 80px;
                            height: 80px; */
            border-radius: 5px;
            margin-right: 15px;
        }

        .related-post h5 {
            font-size: 1.2em;
            margin: 0;
            color: #388E3C;
        }

        .related-post h5 a {
            text-decoration: none;
            color: inherit;
        }

        .related-post h5 a:hover {
            text-decoration: underline;
        }
        .related-post ul li{
            list-style: disc;
        }
        #blog-detail {
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.8), rgba(195, 189, 189, 0.8)), url('../images/bg_bt.png') no-repeat center top / cover fixed #f3f4f6;
        }
    </style>
@endpush

@section('content-page')
    <section id="blog-detail">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="post-detail-container">
                        <h1 class="post-title text-center mb-5">{{ $blog->title }}</h1>
                        <div class="post-content">
                            {!! $blog->description !!}
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection

@push('child-scripts')
@endpush
