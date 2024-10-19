@extends('layouts.app')
@section('title', __('title-home'))
@section('description', 'decription', 'Home Brightton Acaddemy - Brightonsingapore - Dịch vụ Brighton')
@section('keyword', 'brightonsingapore,brighton,academy,Về Brighton Dịch vụ Brighton')
@push('styles')
    <style>
        @media (max-width: 480px) {
            #facilities .img-slider-facilities p {
                font-size: 12px;
                bottom: -12px;
                left: -100%;

            }

            #facilities .img-slider-facilities img {
                right: 100%;
            }
        }

        @media (max-width: 767px) {
            .title-slider {
                margin: 75px 0 0;
                padding: 0 15px;
            }

            .title-slider h4 {
                font-size: 18px;
            }

            #facilities .img-slider-facilities p {
                font-size: 12px;
                bottom: -12px;
                left: -56%;

            }

            #facilities .img-slider-facilities img {
                right: 56%;
            }
        }

        @media (max-width: 991px) {

            #about-us .kids-row .kids-col,
            #study-program .kids-row .kids-col {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 100%;
                flex: 0 0 100%;
                max-width: 100%;
                padding: 0;
            }

            #about-us .kids-detail,
            #study-program .kids-detail {
                padding: 20px;
            }

            .order-2 {
                order: 2 !important;
            }

            .order-1 {
                order: 2 !important;
            }
        }

        @media (max-width: 1600px) {
            .title-slider h4 {
                font-size: 20px;
            }

            #facilities .bxslider2 li {
                width: 100%;
            }

            #facilities .img-slider-facilities img {
                height: auto;
                width: 100%;
                right: 100%;

            }

            #facilities .img-slider-facilities p {
                font-size: 10px;
                /* bottom: 0; */
                left: -100%;

            }
        }

        @media (max-width: 1400px) {
            #our-parents .our-parents-slider .bx-wrapper .bx-next {
                right: 10px;
            }

            #our-parents .our-parents-slider .bx-wrapper .bx-prev {
                left: 10px;
            }

            #srial-lesson .age-group {
                display: block;
            }

            #srial-lesson table.form-table th {
                width: 26%;
            }

            #facilities .bxslider2 li {
                width: 100%;
            }

            #facilities .img-slider-facilities img {
                height: auto;
                width: 100%;
                right: 100%;
            }

            #facilities .img-slider-facilities p {
                font-size: 10px;
                /* bottom: 0; */
                left: -100%;

            }
        }

        @media (max-width: 1200px) {

            .about-us-bottom {
                padding: 0 0 70px;
            }

            .card-over-play p {
                font-size: 15px;
            }

            .card-over-play h5 {
                font-size: 15px;
            }
        }

        .banner-video {
            height: 980px;
            /* margin-bottom: 50px; */
        }

        .description-program span,
        #description-about span {
            display: -webkit-box;
            -webkit-line-clamp: 7;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow-y: scroll;
            background-color: rgba(0, 0, 0, 0.4);
            /* overflow: hidden; */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 1% auto;
            padding: 0px 10px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        #descriptionModal::-webkit-scrollbar-thumb,
        .descriptionModal::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background-color: #FFF;
            background-image: -webkit-gradient(linear,
                    40% 0%,
                    75% 84%,
                    from(#60a87e),
                    to(#60a87e),
                    color-stop(.6, #60a87e))
        }

        #descriptionModal::-webkit-scrollbar-track,
        .descriptionModal::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #F5F5F5;
            border-radius: 10px;
        }

        #descriptionModal::-webkit-scrollbar,
        .descriptionModal::-webkit-scrollbar {
            width: 10px;
            background-color: #F5F5F5;
        }
    </style>
@endpush
@section('content')

    <section id="banner-video">
        <div class="banner-video">
            <div class="container">
                @if ($banner && $banner->path || $banner && $banner->thumbnail)
                    <video width="100%" height="auto" id="video-banner" preload="metadata" playsinline muted loop poster="{{ asset($banner->thumbnail) }}">
                        <source data-src="{{ asset($banner->path) }}" type="video/mp4">
                    </video>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            let video = document.getElementById("video-banner");
                            let source = video.querySelector('source');
                            let observer = new IntersectionObserver(function(entries) {
                                if (entries[0].isIntersecting) {
                                    source.src = source.getAttribute('data-src');
                                    video.load();
                                    video.play();
                                    observer.disconnect();
                                }
                            });
                            observer.observe(video);
                        });
                    </script>
                @else
                    <p>{{ __('banner_not_found') }}</p>
                @endif
            </div>
        </div>
    </section>

    <svg class="waves random-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
            viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
            <defs>
                <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
            </defs>
            <g class="parallax">
                <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7)" />
                <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
                <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
                <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
            </g>
        </svg>
    <section id="about-us" class="caclophoc">
        @if (isset($aboutUs))
            <div class="introduce">
                <div class="container-kids">
                    <h2 class="title-introduce">
                        {{ $aboutUs->title_about }}
                    </h2>
                    <br>
                    <p class="desc-introduce">
                        {{ $aboutUs->subtitle_about }}
                    </p>
                </div>
            </div>
            <div class="about-us">
                <div class="container-kids">
                    <div class="btn-about-us">
                        <a href="{{ $aboutUs->link_url }}" class="primary-btn bg-white">
                            <span>{{ __('about_us') }} <i class="arrow"></i></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="about-us-bottom">
                <div class="container-kids">
                    <div class="kids-content">
                        <div class="kids-main">
                            <div class="kids-border kids-row kids-image">
                                <div class="bottom-right-horizontal"></div>
                                <div class="bottom-right-vertical"></div>
                                <div class="order-2 kids-col">
                                    <div class="kids-detail">
                                        <h2 class="title-kids-left" id="title-kids-left-about">
                                            {{ $aboutUs->title_detail }}
                                        </h2>
                                        @if (!empty($aboutUs->subtitle_detail))
                                            <br>
                                            <h4>
                                                {{ $aboutUs->subtitle_detail }}
                                            </h4>
                                            <br>
                                        @endif
                                        <p id="description-about">
                                            <span>
                                                {{ $aboutUs->description }}
                                            </span>
                                        </p>
                                        <a href="javascript:void(0);" class="primary-btn bg-white" id="learnMoreBtnAbout">
                                            <span>{{ __('learn_more') }} <i class="arrow"></i></span>
                                        </a>
                                        <div id="descriptionModal" class="modal">
                                            <div class="modal-content">
                                                <span class="close close-about" onclick="closeAboutModal()">&times;</span>
                                                <div class="modal-body">
                                                    <h2 class="title-kids-left" id="title-kids-about"></h2>
                                                    <p id="fullDescription"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="kids-col">
                                    <div class="kids-img">
                                        <img src="{{ asset($aboutUs->image) }}" alt="Kids-edu">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="container-kids">
                <p class ="text-center">{{ __('about_us_not_found') }}</p>
            </div>
        @endif

    </section>

    @include('pages.components.slider', ['sliders' => $sliders])


    <div class="overflow-hidden">
        {{-- <img class="max-w-none" src="{{asset('images/w6.svg')}}" width="2500" height="150" alt=""> --}}
    </div>
    @if($tabProject->isNotEmpty())
        <section id="group-activity">
            <div class="dev-mini">
                <div class="container">
                    <div class="dev-mini-content">
                        <div class="dev-mini-title">
                            <h2>
                            {{__('Các hoạt động nhóm  - Phát triển dự án mini')}}
                            </h2>
                        </div>
                    </div>

                    <div class="dev-mini-detail my-4">
                        <div class="row g-4 dev-mini-row">
                            @foreach($tabProject as $activity)
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card h-100 position-relative">
                                        <a href="{{ route('detail-dev-mini', ['id' => $activity->id]) }}">
                                            <img src="{{asset($activity->image)}}" class="card-img-top" alt="Enrollment">
                                        </a>

                                        <div class="card-body">
                                            <div class="card-over-play">
                                                <a href="#">
                                                    <h5 class="card-title">{{$activity->project_name}}</h5>
                                                </a>
                                                <p class="card-text">{{ __('date') }}: {{ \Carbon\Carbon::parse($activity->date)->format('d/m/Y') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-sm-6 col-lg-4">
                                <div class="dev-view">
                                    <a href="{{ route('programms',$tabs_mini_content->slug)  }}">
                                        <button class="learn-more">
                                            <span aria-hidden="true" class="circle">
                                            <span class="icon arrow"></span>
                                            </span>
                                            <span class="button-text">{{__('view_all')}}</span>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    @endif
    <section id="study-program">
        <div class="programs">
            <div class="container">
                <div class="introduce introduce-program">
                    <div class="container">
                        <h2 class="title-introduce">
                            {{ $category->name_category }}
                        </h2>
                        <br>
                        <p class="desc-introduce desc-program text-start">{!! nl2br(e($category->desc_category)) !!}</p>
                    </div>
                </div>
                @foreach ($programs as $index => $program)
                    <div class="programs-kids">
                        <div class="container-kids">
                            <div class="kids-content">
                                <div class="kids-main ">
                                    <div class="kids-border kids-row ">
                                        <div class="bottom-right-horizontal"></div>
                                        <div class="bottom-right-vertical"></div>
                                        <div class="{{ $index % 2 == 0 ? 'order-2' : 'order-1' }} kids-col">
                                            <div class="kids-detail">
                                                <h2 class="title-kids-left"
                                                    id="title-kids-left-program-{{ $index }}">
                                                    {{ $program->title_program }}</h2>
                                                @if (!empty($program->short_description))
                                                    <br>
                                                    <h4>{{ $program->short_description }}</h4>
                                                    <br>
                                                @endif
                                                <p id="description-program-{{ $index }}"
                                                    class="description-program">
                                                    <span>
                                                        {{ $program->long_description }}
                                                    </span>
                                                </p>
                                                <a href="javascript:void(0);" class="primary-btn bg-white"
                                                    id="learnMoreBtnProgram-{{ $index }}">
                                                    <span>{{ __('learn_more') }} <i class="arrow"></i></span>
                                                </a>
                                                <div id="descriptionModal-{{ $index }}"
                                                    class="modal descriptionModal">
                                                    <div class="modal-content">
                                                        <span class="close close-program"
                                                            data-index="{{ $index }}">&times;</span>
                                                        <div class="modal-body">
                                                            <h2 class="title-kids-left"
                                                                id="title-kids-program-{{ $index }}"></h2>
                                                            <p id="fullDescription-{{ $index }}"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="kids-col">
                                            <div class="kids-img">
                                                <img src="{{ asset($program->img_program) }}" alt="Kids-edu">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="dev-view dev-view-program">
                    <a href="{{ route('programms',$tabs_programs_content->slug)  }}">
                        <button class="learn-more">
                            <span aria-hidden="true" class="circle">
                                <span class="icon arrow"></span>
                            </span>
                            <span class="button-text">{{__('view_all')}}</span>
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <div class="overflow-hidden">
        {{-- <img class="max-w-none" src="{{asset('images/w3.svg')}}" width="" height=" " alt=""> --}}
    </div>
    <section id="our-parents">
        <div class="our-parents-slider">
            <div class="container">
                <div class="parents-title">
                    <h2 class="my-4">
                        {{ __('testimonial') }}
                    </h2>
                </div>
                @if ($testimonials->isNotEmpty())
                    <div class="bxslider">
                        @foreach ($testimonials as $testimonial)
                            <div>
                                <div class="parents-detail">
                                    <div class="avt-parents">
                                        <img src="{{ asset($testimonial->avatar) }}" alt="{{ $testimonial->name }}">
                                    </div>
                                    <div class="name-parents">
                                        <h4>{{ $testimonial->name }}</h4>
                                    </div>
                                    <p class="desc-parents">
                                        {{ $testimonial->short_description }}
                                    </p>
                                    <div class="btn-learn-more">
                                        <a href="#" class="primary-btn bg-white">
                                            <span>{{ __('read_more') }}<i class="arrow"></i></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center">{{ __('not_found') }}</p>
                @endif
            </div>
        </div>
    </section>
    <div class="overflow-hidden">
        <img class="max-w-none" src="{{ asset('images/w9.svg') }}" width="2500" height="150" alt="">
    </div>
    <section id="srial-lesson" class="sign-up-pres">
        <div class="sign-up-lesson ">
            <div class="container">
                @include('pages.components.send-admission', ['content' => __('to join the admission')])
            </div>
        </div>
    </section>

    <section id="facilities">
        <div class="kids-facilities">
            <div class="container">
                <div class="title-facilities">
                    <h3>
                        {{ __('our campus') }}
                    </h3>
                </div>
                {{-- <div class="desc-facilities">
                    <p>
                        Hệ thống trường Mầm non Quốc tế Kindy City hiện có mặt tại quận 3, quận 10, quận 11, quận Bình Thạnh, quận Bình Tân, quận Tân Bình, quận Phú Nhuận, Him Lam (Quận 7), P. Tân Quy (Quận 7), P.Thảo Điền (TP. Thủ Đức) và P.Bình Thọ (TP. Thủ Đức).
                    </p>
                </div> --}}
            </div>
            @if ($campuses->isEmpty())
               <p class="text-center fw-bold">{{ __('not_found_campus') }}</p>
            @else
                <div class="slider-facilities">
                    <div class="desc-slider-facilities">
                        <ul class="bxslider2">
                            @foreach ($campuses as $item)
                                <li>
                                    <div class="img-slider-facilities">
                                        <img src="{{ asset($item->image) }}" alt="">
                                        <p>{{ $item->name }} - {{ $item->address }} {{ $item->phone != null ? ' - '. $item->phone : '' }}</p>

                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
           @endif
        </div>
    </section>
@endsection
@push('scripts')
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
    </script>
    <script>
        $(document).ready(function() {
            var slider = $('.bxslider2').bxSlider({
                slideWidth: 300,
                minSlides: 1,
                maxSlides: 5,
                moveSlides: 1,
                slideMargin: 10,
                pager: false,
                onSliderLoad: function() {
                    centerSlides();
                },
                onSlideAfter: function(newIndex) {
                    centerSlides();
                }

            });

            function centerSlides() {
                var slideCount = $('.bxslider2 > li').length;
                if (slideCount <= 3) {
                    var totalWidth = slideCount * 310;
                    var parentWidth = $('.bxslider2').parent().width();
                    var leftMargin = (parentWidth - totalWidth) / 2;
                    $('.bxslider2').css('margin-left', leftMargin + 'px');
                } else {
                    $('.bxslider2').css('margin-left', '0');
                }
            }
        });
    </script>
    <script>
        function openModal(titleId, descriptionId, modalId, titleModalId, descriptionModalId) {
            var fullDescription = $(descriptionId + ' span').text();
            var title = $(titleId).text();
            $('#' + descriptionModalId).text(fullDescription);
            $('#' + titleModalId).text(title);
            $('#' + modalId).css('display', 'block');
        }

        function closeModal(modalId) {
            $('#' + modalId).css('display', 'none');
        }

        function closeAboutModal() {
            closeModal('descriptionModal');
        }

        function closeProgramModal(index) {
            closeModal('descriptionModal-' + index);
        }

        function initCloseModalEvents(programs) {
            $('.close-about').on('click', closeAboutModal);

            programs.forEach(function(program, index) {
                var closeProgramButton = $('.close-program[data-index="' + index + '"]');
                if (closeProgramButton.length) {
                    closeProgramButton.on('click', function() {
                        closeProgramModal(index);
                    });
                }
            });

            $(window).on('click', function(event) {
                var aboutModal = $('#descriptionModal');
                if (event.target == aboutModal[0]) {
                    closeAboutModal();
                }

                programs.forEach(function(program, index) {
                    var modal = $('#descriptionModal-' + index);
                    if (event.target == modal[0]) {
                        closeProgramModal(index);
                    }
                });
            });
        }

        function initProgramModalEvents(programs) {
            programs.forEach(function(program, index) {
                var learnMoreBtn = $('#learnMoreBtnProgram-' + index);
                if (learnMoreBtn.length) {
                    learnMoreBtn.on('click', function() {
                        openModal('#title-kids-left-program-' + index, '#description-program-' + index,
                            'descriptionModal-' + index, 'title-kids-program-' + index,
                            'fullDescription-' + index);
                    });
                }
            });
        }

        function initAboutModalEvent() {
            var learnMoreBtnAbout = $('#learnMoreBtnAbout');
            if (learnMoreBtnAbout.length) {
                learnMoreBtnAbout.on('click', function() {
                    openModal('#title-kids-left-about', '#description-about', 'descriptionModal',
                        'title-kids-about', 'fullDescription');
                });
            }
        }

        function initAllModalEvents(programs) {
            initAboutModalEvent();
            initProgramModalEvents(programs);
            initCloseModalEvents(programs);
        }

        $(document).ready(function() {
            var programs = @json($programs); // Convert Laravel variable to JavaScript
            initAllModalEvents(programs);
        });
    </script>
@endpush
