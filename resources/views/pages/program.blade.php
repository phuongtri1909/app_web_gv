@extends('pages.layouts.page')
@section('title', $tab->title)
@section('description', $tab->title . ' page, ' . $tab->title . ' Brighton Academy, ' . $tab->slug . ' Brighton
    Academy')
@section('keyword', $tab->title . ' page, ' . $tab->title . ' Brighton Academy, ' . $tab->slug . ' Brighton Academy')
@section('title-page', $tab->title)
@section('bg-page', asset($tab->banner))
@push('child-styles')
    <style>
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

        .description-program span,
        #description-about span {
            display: -webkit-box;
            -webkit-line-clamp: 7;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
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
        }
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

    <section id="study-program">
        <div class="programs mt-5">
            <div class="container">
                <div class="introduce introduce-program">
                    <div class="container">
                        <h2 class="title-introduce">
                            {{ $category_page_program->name_category }}
                        </h2>
                        <br>
                        <p class="desc-introduce desc-program text-center">{!! nl2br(e($category_page_program->desc_category)) !!}</p>
                    </div>
                </div>
                @foreach ($programs_page_program as $index => $program)
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
                                                    <a href="javascript:void(0);"
                                                        id="learnMoreBtnProgram-{{ $index }}">
                                                        <span>{{ __('learn_more') }} <i class="arrow"></i></span>
                                                    </a>
                                                </p>

                                                <a href="{{ route('detail-program', ['id' => $program->id]) }}"
                                                    class="primary-btn bg-white">
                                                    <span>{{ __('see_details') }} <i class="arrow"></i></span>
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
            </div>
        </div>
    </section>

    <section id="srial-lesson" class="sign-up-pres">
        <div class="sign-up-lesson ">
            <div class="container">
                @include('pages.components.send-admission', ['content' => __('to join the admission')])
            </div>
        </div>
    </section>
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
                speed: 100,
                auto: true,
                pause: 3000
            });
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
            var programs = @json($programs_page_program);
            initAllModalEvents(programs);
        });
    </script>
@endpush
