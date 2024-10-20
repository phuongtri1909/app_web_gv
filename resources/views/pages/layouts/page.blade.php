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
            background-repeat: no-repeat !important;
            background-position: center center !important;
            background-size: cover !important;
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
        <div id="page" class="mt-5rem">
            @yield('content-page')
        </div>
    </section>
@endsection
@push('scripts')
    @stack('child-scripts')
@endpush
