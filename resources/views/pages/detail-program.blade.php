@extends('pages.layouts.page')
@section('title', $tab->title)
@section('description', $tab->title . ' page, ' . $tab->title . ' Brighton Academy, ' .$tab->slug . ' Brighton Academy')
@section('keyword', $tab->title . ' page, ' . $tab->title . ' Brighton Academy, ' . $tab->slug . ' Brighton Academy')
@section('title-page', $tab->title)
@section('bg-page', asset($tab->banner))
@push('child-styles')
    <style>
        #content-detail-programm {
            padding: 40px 0;
        }

        .content-detail-programm .title-main {
            font-size: 35px;
        }

        .related-news .title-page {
            padding-bottom: 21px;
            border-bottom: 1px solid #404040;
            font-family: Brygada-B;
        }

        .content-main {
            border: 1px solid #ccc;
            padding: 7px 10px;
        }

        .title-page {
            font-size: 24px;
        }

        .related-items {
            margin: 10px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .related-news .related-item-img img {
            width: 100%;
            border-radius: 0.5rem;
        }

        .related-titles a {
            display: inline;
            font-size: 1rem;
            margin-top: 1rem;
            color: #333;
            text-decoration: none;
        }

        .title-main,
        .title-page {
            margin-bottom: 1rem;
            font-size: 1.5rem;
            color: #333;
        }

        .content-main span {
            font-size: 1rem;
            color: #666;
            line-height: 1.5;
        }

        .content-main h2 {
            margin-top: 1.5rem;
            margin-bottom: 1rem;
        }

        .related-titles {
            width: 55%;
            overflow: hidden;
            text-align: center;
            line-height: 1.4;
        }

        @media (max-width: 767px) {

            .col-sm-9,
            .col-sm-3 {
                width: 100%;
                padding-left: 0;
                padding-right: 0;
            }

            .title-main,
            .title-page {
                font-size: 1.25rem;
            }

            .content-main span,
            .related-titles a {
                font-size: 0.875rem;
            }
        }

        .programm .container .programm-wrapper .programm-top .tag-pr-top {
            margin-top: 20px;
            padding: 0.6rem 1.2rem;
            border-radius: 100rem;
            background-color: #b70f1b;
            font-size: 1.8rem;
            font-weight: 700;
            color: #fff;
            width: fit-content;
        }

        .programm .container .programm-wrapper .programm-top .title-pr-top {
            font-size: 2.4rem;
            line-height: 140%;
            text-transform: uppercase;
            letter-spacing: -0.72px;
            text-wrap: pretty;
        }

        .programm .container .programm-wrapper .programm-top {
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flex;
            display: -o-flex;
            display: flex;
            flex-direction: column;
            margin-bottom: 1.2rem;
        }

        #programm {
            padding: 40px 0 0 0;
            color: #fff;
        }

        .programm-wrapper {
            border-radius: 10px;
            padding: 20px;
            color: #fff;
        }

        .programm-main-img img {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .tag-pr-top {
            background-color: #b70f1b;
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .title-pr-top {
            font-size: 2.5rem;
            line-height: 1.2;
            text-transform: uppercase;
            letter-spacing: -0.72px;
            margin-top: 10px;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .programm-content {
            display: -webkit-box;
            -webkit-line-clamp: 14;
            -webkit-box-orient: vertical;
            overflow: hidden;

        }

        .programm-content li {
            margin-bottom: 10px;
            font-size: 1rem;
            line-height: 1.6;
        }

        .programm-main-img {
            position: relative;
            border-radius: 10px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        @media (max-width: 767px) {
            .pr-main-1 {
                order: 2;
            }

            .pr-main-2 {
                order: 1;
            }

            .tag-pr-top {
                font-size: small;
            }

            .title-pr-top {
                font-size: 1.5rem !important;
            }

            .programm .container .programm-wrapper .programm-top .tag-pr-top {
                font-size: 1rem;
                font-weight: 700;
            }
        }

        #md1-program .tag-pr-head {
            background-color: #b70f1b;
            color: #fff;
            padding: 1rem 2rem;
            border-radius: 100rem;
            width: fit-content;
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 1.6rem;
        }

        #md1-program {}

        #md1-program .detail-program {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #md1-program .title-pr-head span {
            color: rgb(0, 0, 0);
            font-size: 1.2rem;
        }

        #md1-program .img-content img {
            max-width: 100%;
            height: auto;
        }

        #programm .programm-main-img {
            position: relative;
        }

        #programm .programm-main-img .bottom-right-vertical {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 3px;
            height: 20%;
            background-color: #b70f1b;
        }

        #programm .programm-main-img .bottom-right-horizontal {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 20%;
            height: 3px;
            background-color: #b70f1b;
        }

        #programm .programm-main-img .top-left-vertical {
            position: absolute;
            top: 0;
            left: 0;
            width: 3px;
            height: 20%;
            background-color: #b70f1b;
        }

        #programm .programm-main-img .top-left-horizontal {
            position: absolute;
            top: 0;
            left: 0;
            width: 20%;
            height: 3px;
            background-color: #b70f1b;
        }

        .is-program{
            margin-top: 60px;
        }
        /* End program page */
    </style>
@endpush
@section('content-page')

    <div class="crumb">
        <div class="container">
            <a href="{{ route('home') }}">{{ __('home') }}</a>
            <i class="fa fa-angle-right"></i>
            <a href="{{ route('programms', $tab->slug) }}">{{ __('study program') }}</a>
        </div>
    </div>
    <div class="menu container">
        @if (empty($programs_cp2))
            <div class="menu-item hover-shadow">
                <a href="{{ route('programms', $tab->slug) }}">{{ __('all') }}</a>
            </div>
        @else
            @foreach ($programs_cp2 as $item)
                <div class="menu-item hover-shadow">
                    <a href="{{ route('detail-program', ['id' => $item->id]) }}">{{ $item->title_program }}</a>
                </div>
            @endforeach
        @endif

    </div>

    @if (!empty($detail_program))
        <section id="md1-program">
            <div class="container md-1 mt-5 d-flex detail-program">
                @if (!empty($detail_program->short_description))
                    <div class="tag-pr-head mt-5">
                        {{ $detail_program->short_description }}
                    </div>
                @endif
                <h2 class="fw-bold text-dark">{{ $detail_program->title_program }}</h2>
                <div class="title-pr-head text-dark mb-5 mt-5">
                    <span>{{ $detail_program->long_description }}</span>
                </div>
            </div>
            <div class="img-content text-center">
                <img src="{{ asset($detail_program->img_program) }}" alt="">
            </div>
        </section>
    @endif

    @if (!empty($content_programs_cp1))
        <section id="programm">
            <div class="programm">
                <div class="container">
                    <div class="programm-wrapper">

                        @foreach ($content_programs_cp1 as $index => $content)
                            <div class="row  is-program">
                                @if ($index % 2 == 0)
                                    <div class="col-sm-6 order-sm-1">
                                        <div class="programm-main-img blc-img1">
                                            <img src="{{ asset($content->img_detail) }}" class="img-fluid"
                                                alt="{{ $content->title }}" decoding="async" loading="lazy">
                                            <div class="top-left-vertical"></div>
                                            <div class="top-left-horizontal"></div>
                                            <div class="bottom-right-horizontal"></div>
                                            <div class="bottom-right-vertical"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 pr-main-1 order-sm-2">
                                        <div class="programm-top">
                                            {{-- @if (!empty($content->tag))
                                                <div class="tag-pr-top">
                                                    # {{ $content->tag }}
                                                </div>
                                            @endif --}}
                                            <h3 class="title-pr-top text-dark">
                                                {{ $content->title }}
                                            </h3>
                                            <p class="programm-content text-dark ms-3">
                                                {{ $content->content }}
                                            </p>
                                            <a href="javascript:void(0);" class="primary-btn bg-white modal-learn-more ms-3"
                                                data-title="{{ $content->title }}" data-content="{{ $content->content }}">
                                                <span>{{ __('learn_more') }} <i class="arrow"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-sm-6 pr-main-1 order-sm-1">
                                        <div class="programm-top">
                                            {{-- @if (!empty($content->tag))
                                                <div class="tag-pr-top">
                                                    # {{ $content->tag }}
                                                </div>
                                            @endif --}}
                                            <h3 class="title-pr-top text-dark">
                                                {{ $content->title }}
                                            </h3>
                                            <p class="programm-content text-dark ms-3">
                                                {{ $content->content }}
                                            </p>
                                            <a href="javascript:void(0);" class="primary-btn bg-white modal-learn-more ms-3"
                                                data-title="{{ $content->title }}" data-content="{{ $content->content }}">
                                                <span>{{ __('learn_more') }} <i class="arrow"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 order-sm-2">
                                        <div class="programm-main-img blc-img1">
                                            <img src="{{ asset($content->img_detail) }}" class="img-fluid"
                                                alt="{{ $content->title }}" decoding="async" loading="lazy">
                                            <div class="top-left-vertical"></div>
                                            <div class="top-left-horizontal"></div>
                                            <div class="bottom-right-horizontal"></div>
                                            <div class="bottom-right-vertical"></div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <div class="modal fade" id="contentModal" tabindex="-1" aria-labelledby="contentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="margin-top:150px">
                <div class="modal-content">
                    <h5 class="modal-title pt-3 text-center" id="contentModalLabel" style="color: #b70f1b"></h5>
                    <div class="modal-body" id="contentModalBody">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (!empty($content_programs_cp2))
        <section id="md1-program">
            @foreach ($content_programs_cp2 as $content)
                <div class="container md-1 mt-5 d-flex flex-column align-items-start">
                    @if (!empty($content->tag))
                        <div class="tag-pr-head mt-5">
                            {{ $content->tag }}
                        </div>
                    @endif
                    <h2 class="fw-bold text-dark">{{ $content->title }}</h2>
                    <div class="title-pr-head text-dark mb-5">
                        <span>{{ $content->content }}</span>
                    </div>
                </div>
                <div class="img-content text-center">
                    <img src="{{ asset($content->img_detail) }}" alt="">
                </div>
            @endforeach
        </section>
    @endif

    @if (count($slides_program) > 0)
        <section id="slider-program">
            <div class="container mt-5">
                <div class="slider5">
                    @foreach ($slides_program as $slide)
                        <div class="slide">
                            <img src="{{ asset($slide->img) }}">
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    

@endsection
@push('child-scripts')
    <script>
        $(document).ready(function() {
            $('.bxslider').bxSlider({
                mode: 'fade',
                moveSlides: 1,
                slideMargin: 40,
                infiniteLoop: true,
                touchEnabled: false,
                minSlides: 3,
                maxSlides: 3,
                speed: 800,
            });
        });

        $(document).ready(function() {
            $('.slider5').bxSlider({
                slideWidth: 500,
                minSlides: 3,
                maxSlides: 6,
                moveSlides: 5,
              
            });
        });


        $(document).ready(function() {
            $('.modal-learn-more').on('click', function() {
                var title = $(this).data('title');
                var content = $(this).data('content');

                $('#contentModalLabel').text(title);
                $('#contentModalBody').html(content);

                var contentModal = new bootstrap.Modal(document.getElementById('contentModal'));
                contentModal.show();
            });
        });
    </script>
@endpush
