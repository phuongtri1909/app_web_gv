@extends('pages.layouts.page')
@section('title', $tab->title)
@section('description',
    $tab->title .
    ' page, ' .
    $tab->title .
    ' Brighton Academy, ' .
    $tab->slug .
    ' Brighton
    Academy')
@section('keyword', $tab->title . ' page, ' . $tab->title . ' Brighton Academy, ' . $tab->slug . ' Brighton Academy')
@section('title-page', $tab->title)
@section('bg-page', asset($tab->banner))

@push('child-styles')
    <style>
        .title-introduce {
            color: #b70f1b;
        }

        #component-2 {
            position: relative;
        }

        .logo-position {
            position: absolute;
            left: 50%;
            top: -84px;
            width: 70px;
            height: 70px;
            background-color: #fff;
            box-shadow: 0 0 12px 9px rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            transform: translateX(-50%);
        }

        .mission-text {
            font-family: commerceB;
            font-size: 5rem;
            color: transparent;
            white-space: nowrap;
            text-align: center
        }

        .content-box {
            border-bottom: 2px solid #b70f1b;
            border-right: 4px solid #b70f1b;
            border-left: 4px solid #b70f1b;
            position: relative;
        }

        .content-box::before {
            content: "";
            position: absolute;
            width: 3px;
            height: 5rem;
            left: 35px;
            top: -38.5px;
            background-color: #b70f1b;
            transform: rotate(90deg);
        }

        .content-box::after {
            content: "";
            position: absolute;
            width: 3px;
            height: 5rem;
            right: 35px;
            top: -38.5px;
            background-color: #b70f1b;
            transform: rotate(90deg);
        }

        @media (max-width: 768px) {
            .mission-text {
                font-size: 1.8rem;
            }
        }

        .text-content-box {
            padding-right: 50px;
            padding-left: 50px;
        }

        #component-3-4 .component-collapse {
            position: relative;
        }

        #component-3-4 .component-collapse .line {
            width: 40px;
            color: #fff;
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            text-align: center;
            display: flex;
            align-items: center;
            height: inherit;
            padding-top: 15px
        }

        #component-3-4 .component-collapse .content {
            position: absolute;
            color: #fff;
            bottom: 0;
            left: 40px;
            width: calc(100% - 40px);
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .collapse-wrapper {
            position: relative;
            overflow: hidden;
            transition: width 0.5s ease;
        }

        .collapse-wrapper:hover {
            width: 100% !important;
        }

        .collapse-wrapper:hover .content {
            display: block !important;
            opacity: 1 !important;
        }

        @media (min-width: 768px) {
            .collapse-wrapper {
                width: 200px !important;
            }
        }


        .hero_area {
            position: relative;
            height: 100px;
            background-color: black;
        }

        .waves-about {
            position: absolute;
            width: 100%;
            height: 15vh;
            min-height: 100px;
            max-height: 150px;
            bottom: 0;
            left: 0;
        }

        .parallax-about>use {
            animation: move-forever 25s cubic-bezier(.55, .5, .45, .5) infinite;
        }

        .parallax-about>use:nth-child(1) {
            animation-delay: -2s;
            animation-duration: 7s;
        }

        .parallax-about>use:nth-child(2) {
            animation-delay: -3s;
            animation-duration: 10s;
        }

        .parallax-about>use:nth-child(3) {
            animation-delay: -4s;
            animation-duration: 13s;
        }

        .parallax-about>use:nth-child(4) {
            animation-delay: -5s;
            animation-duration: 20s;
        }

        @keyframes move-forever {
            0% {
                transform: translate3d(-90px, 0, 0);
            }

            100% {
                transform: translate3d(85px, 0, 0);
            }
        }


        /*Shrinking for mobile*/

        @media (max-width: 768px) {
            .waves-about {
                height: 40px;
                min-height: 40px;
            }
        }

        /* Waves Animation end*/
    </style>
@endpush

@section('content-page')

    <section id="component-2" class="container my-5">
        <div class="introduce">
            <div class="text-center ">
                <h2 class="title-introduce">
                    {{ $content_first->title }}
                </h2>

                <p class="desc-introduce">
                    {!! nl2br(e($content_first->content)) !!}
                </p>
            </div>
        </div>
        <img src="{{ asset('images/favicon.ico') }}" alt="" class="logo-position">
    </section>

    @if (!$component_3 == null)
        @foreach ($component_3 as $item)
            <section id="component-3" class="my-5">
                <div class="container">
                    <div class="">
                        <div class="d-flex flex-column">
                            <h3 class="mission-text mb-0"
                                style="background: url('{{ asset($item->image) }}') 0 0 / cover; -webkit-background-clip: text;
                                -webkit-text-fill-color: transparent;
                                background-attachment: fixed;">
                                {{ $item->title }}
                            </h3>
            
                            <div class="content-box p-1 p-md-5">
                                <p class="m-0">
                                    <picture>
                                        <source type="image/webp" srcset="{{ asset( $item->image) }}">
                                        <img class="img-fluid lazyload" src="{{ asset($item->imag) }}" data-src="{{ asset($item->image) }}" alt="">
                                    </picture>
                                </p>
                            </div>
                            
                            <!-- Thêm thư viện LazyLoad -->
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>
                        </div>
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
        @endforeach
    @endif

    @if (!$philosophy == null)

        <section id="component-3-4" class="mt-5 mb-100 container">
            <div>
                <h2 class="title-introduce text-center text-md-start">
                    {{ __('Our Philosophy') }}
                </h2>
                <div class="mt-2 component-collapse d-md-flex justify-content-center">
                    @foreach ($philosophy as $item)
                        <div class="collapse-wrapper mb-5 mb-md-0 w-100"
                            style="background: url({{ asset($item->image) }}); height: 430px; background-size: cover; background-position: center;">
                            <div class="line" style="background: {{ $item->bg_color }}">
                                <h5>{{ $item->title }}</h5>
                            </div>
                            @php
                                $bgColor = $item->bg_color;
                                $r = hexdec(substr($bgColor, 1, 2));
                                $g = hexdec(substr($bgColor, 3, 2));
                                $b = hexdec(substr($bgColor, 5, 2));
                            @endphp

                            <div class="content px-3 pb-3 pt-5 w-100 w-md-200"
                                style="background: rgba({{ $r }}, {{ $g }}, {{ $b }}, 0.5); height: 300px; overflow-y: auto;">
                                {{ $item->content }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if (!$collapses == null)
        @include('pages.components.collapse', ['collapses' => $collapses])
    @endif

@endsection
@push('scripts')
@endpush
