@extends('pages.layouts.page')
@section('title', $tab->title)
@section('description', 'Description for Child Page')
@section('keyword', 'child, page, keywords')
@section('title-page', $tab->title)
@section('bg-page', asset($tab->banner))


@push('child-styles')
    <style>
        @media (max-width: 991px) {
            #parent-concern .kids-row .kids-col {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 100%;
                flex: 0 0 100%;
                max-width: 100%;
                padding: 0;
            }
        }

        .kids-detail {
            margin: 0 auto;
            height: 100%;
            padding: 5px 25px;
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

        .kids-border {
            border: 1px solid #8a8a8a;
            box-shadow: 0 80px 70px -10px rgba(0, 0, 0, .2);
            transition: box-shadow .3s ease;
            will-change: transform;
            border-radius: 5px;
            overflow: hidden;
            position: relative;
        }

        .primary-btn {
            display: block;
            color: #2b2b2b;
            font-size: 18px;
            border: 1px solid #707070;
            position: relative;
            max-width: 330px;
            padding: 10px 20px;
            font-weight: 300;
            border-radius: 5px;
            transition: .3s;
            box-shadow: 0 0 0 0 rgba(0, 0, 0, .5);
        }

        .primary-btn.bg-white:hover {
            background: #b70f1b !important;
        }

        .primary-btn:hover {
            background: rgba(250, 61, 4, 0.975);
            border: 1px solid #ed4f59e2;
            color: #fff;
            box-shadow: 0 25px 20px -12px rgba(0, 0, 0, .7);
        }

        .primary-btn span i.arrow {
            position: absolute;
            content: "";
            right: 10px;
            width: 14px;
            height: 21px;
            background: url(../images/btn-arrow2.svg) 0 50% no-repeat;
            top: 50%;
            transform: translate(-50%, -50%);
            -webkit-transform: translate(-50%, -50%);
            transition: .3s;
        }

        .kids-content {
            position: relative;
        }

        .kids-row {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
        }

        .kids-col {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
            max-width: 50%;
        }

        .order-2 {
            order: inherit !important;
        }


        .kids-detail h2 {
            color: #b70f1b;
            padding: 0 0 10px;
        }

        .title-approach h2 {
            text-align: center;
            margin-top: 10px;
            color: #b70f1b;
        }

        .desc-approach p {
            text-align: center;
        }

        .kids-img {
            height: 100%;
            overflow: hidden;
        }

        .kids-img img {
            width: 100%;
            height: 100%;
            min-height: 482px;
            object-fit: cover;
            border-radius: 5px;
        }

        .main-approach {
            height: 100%;
        }

        .content-approach {
            background-color: rgba(153, 153, 153, 20%);
            transition: all .3s ease-in-out;
            flex: 0 0 100%;
            padding: 20px 15px;
            border-radius: 10px;
            height: 100%;
        }

        .main-approach:hover {
            cursor: pointer;
            box-shadow: 0 8px 16px 0 rgba(153, 1, 0, 50%);
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

        .title-approach-b h3 {
            font-size: 24px;
            font-weight: 700;
        }
    </style>
@endpush
@section('content-page')
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
        @else
            <div class="container-kids">
                <p class ="text-center">{{ __('about_us_not_found') }}</p>
            </div>
        @endif

    </section>
    @if (!empty($cp1->description) || !empty($cp1->image))
        <div class="container-kids">
            <div class="my-4">
                <div class="kids-content">
                    <div class="kids-main">
                        <div class="kids-border kids-row kids-image">
                            @if (!empty($cp1->image))
                                <div class="order-2 kids-col">
                                    <div class="kids-img">
                                        {{-- @foreach ($ask->answers as $answer) --}}
                                        <img src="{{ asset($cp1->image) }}" alt="" srcset="">
                                        {{-- @endforeach --}}
                                    </div>
                                </div>
                            @endif
                            @if (!empty($cp1->description))
                                <div class="kids-col">
                                    <div class="kids-detail answer-content " style="word-break: break-word;">
                                        <p id="description-about">
                                            <span id="descriptionContent-1">
                                                {!! Str::limit($cp1->description, 1000) !!}
                                            </span>
                                        </p>
                                        @if (strlen(strip_tags($cp1->description)) > 1000)
                                            <a href="javascript:void(0);" class="primary-btn bg-white"
                                                id="learnMoreBtnAbout-1" data-full-description="{!! e($cp1->description) !!}">
                                                <span>{{ __('learn_more') }} <i class="arrow"></i></span>
                                            </a>
                                        @endif
                                        <div id="descriptionModal-1" class="modal descriptionModal" style="display: none;"
                                            role="dialog" aria-describedby="fullDescription">
                                            <div class="modal-content">
                                                <span class="close close-program" data-index="1">&times;</span>
                                                <div class="modal-body">
                                                    <p id="fullDescription"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (!empty($cp2->title) || !empty($cp2->description) || $cp3->isNotEmpty())
        <div class="container mt-5">
            @if (!empty($cp2->title))
                <div class="title-approach">
                    <h2>
                        {{ $cp2->title }}
                    </h2>
                </div>
            @endif

            @if (!empty($cp2->description))
                <div class="desc-approach">
                    <p>
                        {!! $cp2->description !!}
                    </p>
                </div>
            @endif

            @if ($cp3->isNotEmpty())
                <div class="row">
                    @foreach ($cp3 as $cp)
                        @if (!empty($cp->title) || !empty($cp->description) || !empty($cp->image) || !empty($cp->link))
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="main-approach">
                                    <div class="content-approach">
                                        @if (!empty($cp->image))
                                            <div class="image-approach">
                                                <img src="{{ asset($cp->image) }}" alt="" width="1000"
                                                    height="667" style="max-width: 100%; height: auto;">
                                            </div>
                                        @endif

                                        @if (!empty($cp->title))
                                            <div class="title-approach-b">
                                                <h3>{{ $cp->title }}</h3>
                                            </div>
                                        @endif

                                        @if (!empty($cp->description))
                                            <div class="desc-approach-b">
                                                <p>{!! $cp->description !!}</p>
                                            </div>
                                        @endif

                                        @if (!empty($cp->link))
                                            <div class="view-mins">
                                                <a href="{{ $cp->link }}" target="_blank">{{ $cp->duration }}</a>
                                            </div>
                                        @else
                                            <div class="view-mins">
                                                <a
                                                    href="{{ route('detail.parent', ['slug' => $cp->slug]) }}">{{ $cp->duration }}
                                                </a>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <x-pagination :paginator="$cp3" />
            @endif
        </div>
    @endif

@endsection

@push('child-scripts')
    <script>
        function openModal(index) {
            let modal = $(`#descriptionModal-${index}`);
            let fullContent = $(`#learnMoreBtnAbout-${index}`).data('full-description');
            modal.find('.modal-body p').html(fullContent);
            modal.show().attr('aria-hidden', 'false');


            $(document).one('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeModal(modal);
                }
            });
        }

        function closeModal(modal) {
            modal.hide().attr('aria-hidden', 'true');
        }

        $(document).ready(function() {

            $(document).on('click', '[id^="learnMoreBtnAbout-"]', function() {
                let index = $(this).attr('id').split('-')[1];
                openModal(index);
            });


            $(document).on('click', '.close-program', function() {
                let index = $(this).data('index');
                closeModal($(`#descriptionModal-${index}`));
            });

            $(window).on('click', function(event) {
                $('[id^="descriptionModal-"]').each(function() {
                    if ($(event.target).is(this)) {
                        closeModal($(this));
                    }
                });
            });
        });
    </script>
@endpush
