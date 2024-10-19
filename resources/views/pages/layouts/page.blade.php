@extends('layouts.app')
@push('styles')
    @stack('child-styles')

    <style>
        #layout-page .title-page {
            color: #fff;
            text-align: center;
            background: #000;
            position: relative;
        }

        #layout-page .title-page .bg-page {
            height: 220px;
            opacity: 0.7;
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
        }

        #layout-page .title-page .text-title-page {
            position: absolute;
            top: 0px;
            left: 0px;
            padding-top: 140px;
            width: 100%;
            margin-top: 50px;
            opacity: 0;
            animation: slideUp 1s ease-out forwards;
        }

        @keyframes slideUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @media (min-width: 400px) {
            #layout-page .title-page .bg-page {
                height: 300px !important;
            }
        }

        @media (max-width: 1000px) {
            #layout-page .title-page .text-title-page {
                padding-top: 50px;
            }
        }
    </style>
@endpush
@section('content')
    <section id=layout-page>
        <div class="title-page">
            <div class="bg-page" style="background: url('@yield('bg-page', 'images/moitruonghoctap.jpg')')"></div>
            <div class="text-title-page amination">
                <div class="container">
                    <h2 class="h2-main fw-bold">@yield('title-page', 'page')</h2>
                </div>
            </div>
        </div>
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
        <div id="page">
            @yield('content-page')
        </div>
    </section>
@endsection
@push('scripts')
    @stack('child-scripts')
@endpush
