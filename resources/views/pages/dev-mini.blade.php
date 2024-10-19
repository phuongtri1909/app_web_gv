@extends('pages.layouts.page')
@section('title', $tab->title)
@section('description', 'page dev-mini Brighton Academy')
@section('keyword', 'child, page, dev-mini', $tab->title)
@section('title-page', $tab->title)
@section('bg-page', asset($tab->banner))


@push('child-styles')
    <style>
        .banner-video {
            height: 980px;
            /* margin-bottom: 50px; */
        }

        @media (max-width: 991px) {
            .order-2 {
                order: 2 !important;
            }

            .order-1 {
                order: 2 !important;
            }

            #kids-experience .kids-row .kids-col {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 100%;
                flex: 0 0 100%;
                max-width: 100%;
                padding: 0;
            }

            #kids-experience .kids-detail {
                padding: 20px;
            }
        }

        #list-experience .image-container {
            position: relative;
            display: inline-block;
            margin: 20px;
        }

        #list-experience .image-container .star {
            position: absolute;
            top: 2px;
            left: 44%;
            transform: translateX(-50%);
            padding: 0px;
            border-radius: 50%;
            color: #db2d48;
        }

        #list-experience .image-container .curve {
            position: absolute;
            width: 210px;
            height: 93px;
            top: 11%;
            left: 26%;
            border: dotted 5px #db2d48;
            border-color: #db2d48 transparent transparent transparent;
            border-radius: 59% / 100px 100px 0 0;
            transform: rotate(37deg);
        }

        #list-experience .image-container .curve::after {
            content: "";
            position: absolute;
            width: 207px;
            height: 92px;
            left: -3%;
            top: 164%;
            border: dotted 5px #db2d48;
            border-color: #db2d48 transparent transparent transparent;
            border-radius: 59% / 100px 100px 0 0;
            transform: rotate(181deg);
        }

        .show-img-experience img {
            height: 262px;
            width: 262px;
            padding: 25px;
            border-radius: 50%;
        }

        .kids-flex {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @media screen and (max-width: 425px) {
            #list-experience .image-container .curve {
                position: absolute;
                width: 138px;
                height: 94px;
                top: 6%;
                left: 17%;
                border: dotted 5px #db2d48;
                border-color: #db2d48 transparent transparent transparent;
                border-radius: 70% / 100px 100px 0 0;
                transform: rotate(39deg);
            }

            #list-experience .image-container .curve::after {
                content: "";
                position: absolute;
                width: 138px;
                height: 93px;
                left: -3%;
                top: 61%;
                border: dotted 5px #db2d48;
                border-color: #db2d48 transparent transparent transparent;
                border-radius: 70% / 100px 100px 0 0;
                transform: rotate(178deg);
            }

            #list-experience .image-container .star {
                top: -3px;
                left: 41%;
            }

            #list-experience img {
                height: 156px;
                width: 156px;
                padding: 15px;
            }

        }

        @media screen and (max-width: 992px) {
            #project-completed .news {
                display: block;
            }

            #project-completed .news-left {
                width: 100%;
                margin-bottom: 20px;
            }

            #project-completed .news-right {
                width: 100%;
            }
        }

        @media screen and (max-width: 650px) {
            #project-completed .news-left {
                display: none;
            }

            #project-completed .news-shape {
                display: block;
            }

            #project-completed .news-image-wrapper {
                width: 100%;
            }

            #project-completed .news-content {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content-page')
    <section id="kids-experience">
        <div class="dev-experience">
            <div class="container-kids">
                <div class="kids-content">
                    <div class="kids-main ">
                        <div class="kids-row ">
                            @if ($imgContents_dev->isNotEmpty())
                                @foreach ($imgContents_dev as $item)
                                    <div class= "order-1  kids-col">
                                        <div class="kids-detail">
                                            <h2 class="title-kids-left">{{ $item->title }}</h2>
                                            <p>
                                                <span>
                                                    {!! $item->content !!}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="kids-col">
                                        <div class="kids-img">
                                            <img src="{{ asset($item->image) }}" alt="Kids-edu">
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="list-experience">
        <div class="dev-list-experience my-5">
            <div class="container-kids">
                @if ($drops->isNotEmpty())
                    @foreach ($drops as $index => $item)
                        <div id="{{ $item->id }}" class="tab-show-experience border-show-experience">
                            <div class="header-experience">
                                <h2 class="kids-button-experience">
                                    <i class="fas fa-plus  icon-toggle"></i>
                                    <a role="button" href="#{{ $item->id }}"
                                        aria-expanded="false">{{ $item->title }}</a>
                                </h2>
                            </div>
                            <div class="show-content-experience" style="display:none;">
                                <div class="row">
                                    <div class="col-lg-4 {{ $index % 2 == 0 ? 'order-2' : 'order-1' }}">
                                        <div class="show-img-experience image-container">
                                            <img src="{{ asset($item->image) }}" alt="Kids-edu">
                                            <div class="star">★</div>
                                            <div class="curve"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 kids-flex">
                                        <div class="show-detail-experience">
                                            <p class="show-descr-experience">
                                                {!! $item->content !!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endForEach
                @endif
            </div>
        </div>
    </section>

    <section id="project-completed">
        <div class="list-project-completed  my-5">
            <div class="container-news">
                <div class="main-title">
                    <span>{{ __('implemented_projects') }}</span>
                </div>
                <div class="news">
                    <div class="news-left">
                        @if ($projectsLeft->isNotEmpty())
                            @foreach ($projectsLeft as $item)
                                <div class="news-image-wrapper-first max-width zoom-image">
                                    <a href="{{ route('detail-dev-mini', ['id' => $item->id]) }}">
                                        <img src="{{ asset($item->image) }}" class="card-img-top"
                                            alt="{{ asset($item->image) }}" width="468" height="295">
                                    </a>
                                </div>
                                <div class="news-content-first">
                                    <div class="news-title">
                                        @php
                                            $date = \Carbon\Carbon::parse($item->date);
                                            $month = $date->format('n');
                                            $monthNames = [
                                                1 => 'TH1',
                                                2 => 'TH2',
                                                3 => 'TH3',
                                                4 => 'TH4',
                                                5 => 'TH5',
                                                6 => 'TH6',
                                                7 => 'TH7',
                                                8 => 'TH8',
                                                9 => 'TH9',
                                                10 => 'TH10',
                                                11 => 'TH11',
                                                12 => 'TH12',
                                            ];
                                            $formattedMonth = $monthNames[$month] ?? 'Unknown';
                                        @endphp
                                        <div class="start-date">
                                            <span>{{ $date->format('d') }}</span>
                                            <p>{{ $formattedMonth }}</p>
                                        </div>
                                        <a href="{{ route('detail-dev-mini', ['id' => $item->id]) }}" title="Sự kiện"
                                            class="news-link">{{ $item->project_name }}</a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="news-right">
                        @if ($projectsRight->isNotEmpty())
                            @foreach ($projectsRight as $item)
                                <div class="news-shape">
                                    <div class="news-image-wrapper max-width zoom-image">
                                        <a href="{{ route('detail-dev-mini', ['id' => $item->id]) }}" title="Sự kiện">
                                            <img src="{{ asset($item->image) }}" class="card-img-top"
                                                alt="{{ asset($item->image) }}" width="270" height="210">
                                        </a>
                                    </div>
                                    <div class="news-content">
                                        <div class="news-title">
                                            @php
                                                $date = \Carbon\Carbon::parse($item->date);
                                                $month = $date->format('n');
                                                $monthNames = [
                                                    1 => 'TH1',
                                                    2 => 'TH2',
                                                    3 => 'TH3',
                                                    4 => 'TH4',
                                                    5 => 'TH5',
                                                    6 => 'TH6',
                                                    7 => 'TH7',
                                                    8 => 'TH8',
                                                    9 => 'TH9',
                                                    10 => 'TH10',
                                                    11 => 'TH11',
                                                    12 => 'TH12',
                                                ];
                                                $formattedMonth = $monthNames[$month] ?? 'Unknown';
                                            @endphp
                                            <div class="start-date">
                                                <span>{{ $date->format('d') }}</span>
                                                <p>{{ $formattedMonth }}</p>
                                            </div>
                                            <a href="{{ route('detail-dev-mini', ['id' => $item->id]) }}" title="Sự kiện"
                                                class="news-link">{{ $item->project_name }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="slider-image">
            @if ($tabProject->isNotEmpty())
                <div class="slider3">
                    @foreach ($tabProject as $item)
                        <div class="slide">
                            <a href="{{ route('detail-dev-mini', ['id' => $item->id]) }}">
                                <img src="{{ asset($item->image) }}" width="270" height="210"
                                    alt="{{ asset($item->image) }}" style="object-fit: cover">
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection

@push('child-scripts')
    <script>
        $(document).ready(function() {
            $('.kids-button-experience').click(function(event) {
                event.preventDefault(); // Ngăn chặn việc di chuyển đến phần tử khác
                var content = $(this).closest('.tab-show-experience').find('.show-content-experience');
                // content.toggle(); // Hiển thị hoặc ẩn nội dung

                if (content.is(':visible')) {
                    content.slideUp();
                } else {
                    content.slideDown();
                }
                var experienceDiv = $(this).closest('.border-show-experience');
                experienceDiv.toggleClass('show-experience-open'); // Thêm hoặc xóa class

                var icon = $(this).find('.icon-toggle');
                if (icon.hasClass('fa-plus')) {
                    icon.removeClass('fa-plus').addClass('fa-minus');
                } else {
                    icon.removeClass('fa-minus').addClass('fa-plus');
                }

                var expanded = $(this).attr('aria-expanded') === 'true';
                $(this).attr('aria-expanded', !expanded);
            });
            $('.header-experience').click(function() {
                $(this).toggleClass('active');
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            var slider = $('.slider3').bxSlider({
                slideWidth: 650,
                minSlides: 5,
                maxSlides: 5,
                slideMargin: 15
            });

            $(window).resize(function() {
                var newMinSlides = 5;
                var newMaxSlides = 5;

                if ($(window).width() < 768) {
                    newMinSlides = 2;
                    newMaxSlides = 2;
                }

                slider.reloadSlider({
                    slideWidth: 900,
                    minSlides: newMinSlides,
                    maxSlides: newMaxSlides,
                    slideMargin: 10
                });
            }).resize();
        });
    </script>
@endpush
