@extends('pages.layouts.page')
@section('title', __('title_method'))
@section('description', 'Description for Child Page')
@section('keyword', 'child, page, keywords')
@section('title-page', __('title_page_method'))
@section('bg-page', asset($tab->banner))


@push('child-styles')
    <style>
        #pedagogy .img-pedagogy img {
            width: 70%;
        }

        @media screen and (max-width: 1024px) {
            #pedagogy .img-pedagogy img {
                width: 100%;
            }
        }


        #pedagogy .img-pedagogy {
            text-align: center;
        }

        #pedagogy .title-introduce {
            color: #b70f1b;
        }

        .show-img-pedagogy img {
            height: 262px;
            width: 262px;
            padding: 25px;
            border-radius: 50%;
        }

        #pedagogy .image-container {
            position: relative;
            display: inline-block;
            margin: 20px;
        }

        #pedagogy .image-container .star {
            position: absolute;
            top: 2px;
            left: 44%;
            transform: translateX(-50%);
            padding: 0px;
            border-radius: 50%;
            color: #db2d48;
        }

        #pedagogy .image-container .curve {
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

        #pedagogy .image-container .curve::after {
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

        .kids-flex {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @media screen and (max-width: 425px) {
            #pedagogy .image-container .curve {
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

            #pedagogy .image-container .curve::after {
                content: "";
                position: absolute;
                width: 138px;
                height: 93px;
                left: -3%;
                top: 61%;
                border: dotted 5px #db2d48 5px #db2d48;
                border-color: #db2d48 transparent transparent transparent;
                border-radius: 70% / 100px 100px 0 0;
                transform: rotate(178deg);
            }

            #pedagogy .image-container .star {
                top: -3px;
                left: 41%;
            }

            #pedagogy .show-content-pedagogy img {
                height: 156px;
                width: 156px;
                padding: 15px;
            }

        }

        .flex-kids {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
@endpush

@section('content-page')
    <section id="pedagogy">
        <div class="pedagogy-kids my-5">
            <div class="container-kids">
                <div class="row">
                    @if ($imgContents->isNotEmpty())
                        @foreach ($imgContents as $item)
                            <div class="mb-5 mt-5">
                                <div class="col-md-12">
                                    <h2 class="title-introduce mb-4">{{ $item->title }}</h2>
                                    <p>{!! $item->content !!}</p>
                                </div>

                                <div class="col-md-12">
                                    @if (!empty($item->image))
                                        <div class="img-pedagogy">
                                            <img src="{{ asset($item->image) }}" alt="img-pedagogy">
                                        </div>
                                    @endif
                                </div>
                            </div>
                          
                                        <div class="border-img-inner">
                                            <img class="img-fluid" src="/images/duong-cong-dien-dan.png" alt="" srcset="">
                                        </div>
                                   
                        @endforeach
                        <div>
                            <svg class="waves random-waves"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                                <defs>
                                    <path id="gentle-wave"
                                        d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                                </defs>
                                <g class="parallax">
                                    <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7)" />
                                    <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
                                    <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
                                    <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
                                </g>
                            </svg>
                        </div>
                    @endif

                    <div class="col-md-12 mt-5">
                        <section id="list-pedagogy">
                            <div class="dev-list-pedagogy my-5">
                                <div class="container-kids">
                                    @if ($drops->isNotEmpty())
                                        @foreach ($drops as $index => $item)
                                            <div id="{{ $item->id }}" class="tab-show-pedagogy ">
                                                <div class="header-pedagogy  pedagogy-flex"
                                                    style="background-color: {{ $item->bg_color }}">
                                                    <span class="kids-button-pedagogy">
                                                        <span class="pedagogy-icon">
                                                            @if (!empty($item->icon))
                                                                {!! $item->icon !!}
                                                            @endif
                                                            <a role="button" href="#{{ $item->id }}"
                                                                aria-expanded="false">{{ $item->title }}</a>
                                                        </span>
                                                    </span>
                                                    <div class="toggle-icon">
                                                        <i class="fas fa-plus  icon-toggle "></i>
                                                    </div>
                                                </div>
                                                <div class="show-content-pedagogy" style="display:none;">
                                                    <div class="row">
                                                        <div
                                                            class="col-lg-4 {{ $index % 2 == 0 ? 'order-2' : 'order-1' }} flex-kids">
                                                            <div class="show-img-pedagogy image-container">
                                                                <img src="{{ asset($item->image) }}" alt="Kids-edu">
                                                                <div class="star">★</div>
                                                                <div class="curve"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 kids-flex">
                                                            <div class="show-detail-pedagogy">
                                                                <p class="show-descr-pedagogy">
                                                                    {!! $item->content !!}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('child-scripts')
    <script>
        $(document).ready(function() {
            $('.header-pedagogy').click(function(event) {
                event.preventDefault(); // Ngăn chặn việc di chuyển đến phần tử khác
                var content = $(this).closest('.tab-show-pedagogy').find('.show-content-pedagogy');
                // content.toggle(); // Hiển thị hoặc ẩn nội dung

                if (content.is(':visible')) {
                    content.slideUp();
                } else {
                    content.slideDown();
                }

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
@endpush
