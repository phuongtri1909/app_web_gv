@extends('pages.layouts.page')
@section('title', __('title_learn_env'))
@section('description', 'Page Environment')
@section('keyword', 'Environment, environment page, environment brighton academy')
@section('title-page', __('learning_environment'))
@section('bg-page', asset($tab->banner))

@push('child-styles')
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" /> --}}

    <style>
        .section-title {
            color: #b70f1b;
            text-align: center;
            margin-bottom: 15px;
        }

        .card {
            background-color: #ffffff;
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.4s, box-shadow 0.4s;
            cursor: grab;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
        }

        .card img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            transition: transform 0.4s ease, filter 0.4s ease;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        .card:hover img {
            transform: scale(1.1);
            filter: grayscale(0%);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
        }

        .nav-tabs .nav-link.active {
            background-color: #007bff;
            color: white;
            border-radius: 8px;
        }

        .tab-content .p-3 {
            font-size: 18px;
            color: #333;
            border-radius: 8px;
        }



        @media (min-width: 1200px) {
            .grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        .gallery-item img {
            border-radius: 10px;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .gallery-row-item {
            display: flex;
            align-items: center;
        }

        .gallery-row-item {
            margin-bottom: 30px;
        }

        .gallery-row-item .gallery-item:nth-child(1) {
            width: 70% !important;
            padding: 40px 40px 40px 40px;
            background: #f1f1f1;
            margin-right: 30px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
        }

        .gallery-row-item .gallery-item {
            margin: 0;
        }

        .gallery-item {
            width: calc(100% / 3 - 0px);
            margin: 0 10px 20px;
            cursor: pointer;
            overflow: hidden;
            border-radius: 10px;
        }

        .gallery-row-item .gallery-item:nth-child(1)>* {
            width: 100%;
        }

        .interactive-section ul li {
            list-style-type: disc !important;
            color: #000 !important;
        }

        @media screen and (max-width: 480px) {
            .gallery-row-item {
                display: block !important;
            }

            .gallery-item {
                height: 150px;
            }

            .gallery-row-item .gallery-item:nth-child(1) {
                padding: 20px !important;
                margin-right: 0 !important;
                border-radius: 10px 10px 0 0;
            }

            .gallery-row-item>*,
            .gallery-row-item .gallery-item:nth-child(1) {
                width: 100% !important;
                height: auto;
            }

            .gallery-row-item .gallery-item:nth-child(2),
            .gallery-row-item .gallery-item:nth-child(2) img {
                border-radius: 0 0 10px 10px;
            }
        }

        @media screen and (max-width: 768px) {
            .section-title {
                font-size: 20px;
            }

            .card {
                margin-bottom: 20px;
            }

            .gallery-item img {
                display: block;
            }

        }

        .dragging {
            opacity: 0.8;
            transform: rotate(-3deg) scale(1.05);
        }

        .sortable-placeholder {
            background-color: #f0f0f0;
            border: 2px dashed #ddd;
            height: 100px;
            visibility: visible !important;
        }

        /* Thêm hiệu ứng lượn sóng */
        .wave {
            position: relative;
            width: 100%;
            height: 150px;
            margin-bottom: -7px;
        }

        .wave::before {
            content: "";
            position: absolute;
            top: -46px;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('/images/w9.svg') repeat-x;
            background-size: cover;
            animation: wave 4s backwards linear infinite;
        }

        @keyframes wave {
            0% {
                background-position-x: 0;
            }

            100% {
                background-position-x: 1600px;
            }
        }

        .card-body {
            padding: 2em 1rem;
        }
        .card-body p {
            color: #000 !important;
        }
    </style>
@endpush

@section('content-page')
    <section id="learn_env">
        @if(empty($section_1) && $section_2->isEmpty() && $section_3->isEmpty())
        <div class="content-table-contact my-5 text-center">
            <div class="alert alert-danger" role="alert">
                {{ __('Not yet',['tab' => $tab->title])  }}
            </div>
        </div>
        @else
            <div class="container py-5">
                @if(!empty($section_1))
                    <div class="enviroment-title">
                        <h2 class="section-title" data-aos="fade-up">{{ $section_1->title }}</h2>
                        <span>
                            <p>
                                {!! $section_1->content !!}
                            </p>
                        </span>
                    </div>
                @endif
                    <!-- New Interactive Section -->
                    <div class="interactive-section">
                        @forelse ($section_2 as $item)
                            <div class="gallery-row-item" data-aos="fade-up">
                                <div class="gallery-item">
                                    <div class="gallery-text">
                                        <ul>
                                            <li style="text-align:justify;">
                                                <p>
                                                    {!! $item->content !!}
                                                </p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="gallery-item">
                                    <img src="{{ asset($item->image) }}" alt="Interactive Activity 1">
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                    <div class="wave"></div>


                    <!-- Lecture Section -->
                    <div class="lecture-section mb-5">
                        @if(!empty($section_3) && $section_3->isNotEmpty())
                            <h2 class="section-title" data-aos="fade-up">Hoạt động</h2>
                        @endif

                        <div class="row">
                                @forelse ($section_3 as $item)
                                    <div class="col-md-4" data-aos="fade-up">
                                        <a href="{{ route('tab.environment.show.detail', $item->id) }}">
                                            <div class="card draggable h-100" draggable="true ">
                                                <img src="{{ asset($item->image) }}" class="card-img-top" alt="ABCs">
                                                <div class="card-body">
                                                    <h5 class="card-title" style="color: #b70f1b">{{ $item->title }}</h5>
                                                    <p class="card-text">{!! $item->content !!}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @empty
                                    {{-- <p>{{__('no_find_data')}}</p> --}}
                                @endforelse

                        </div>
                    </div>


            </div>
        @endif
    </section>
    <div class="overflow-hidden srial-lesson-waves">
        <img class="max-w-none" src="{{ asset('images/w7.svg') }}" width="2500" height="150" alt="">
    </div>
@endsection

@push('child-scripts')
    {{-- <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script> --}}
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function() {
            $(".draggable").draggable({
                cursor: "move",
                revert: true,
                start: function() {
                    $(this).addClass('dragging');
                },
                stop: function() {
                    $(this).removeClass('dragging');
                }
            });
            // AOS.init();
        });
    </script>
@endpush
