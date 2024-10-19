@extends('pages.layouts.page')
@section('title', $tab->title)
@section('description', 'Description for Child Page')
@section('keyword', 'child, page, keywords')
@section('title-page', $tab->title)
@section('bg-page', asset($tab->banner))

@push('child-styles')
    <style>
        .title-strategies h2 {
            color: #b70f1b;
            text-align: center;
        }

        .desc-strategies p {
            text-align: center;
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
            /* padding: 20px 15px; */
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

        .content-b {
            padding: 20px 20px;
        }
        .content-b a {
            color: #2b2b2b;
        }
        .title-approach-b h3 {
            font-size: 24px;
            font-weight: 700;
        }

        .title-approach h2 {
            text-align: center;
            margin-top: 10px;
            color: #b70f1b;
        }

        .desc-approach p {
            text-align: center;
        }

        @media (max-width: 1400px) {
            #our-parents .our-parents-slider .bx-wrapper .bx-next {
                right: 10px;
            }

            #our-parents .our-parents-slider .bx-wrapper .bx-prev {
                left: 10px;
            }

        }
    </style>
@endpush

@section('content-page')
    <div class="container">
        <div class="title-strategies">
            <h2>{{ $cp1_c->title }}</h2>
        </div>
        <div class="desc-strategies">
            <p>{!! $cp1_c->description !!}
            </p>
        </div>
    </div>
    <div class="container mt-5">
        {{-- <div class="title-approach">
            <h2>
                Chiến lược và mẹo
            </h2>
        </div>
        <div class="desc-approach">
            <p>
                Respectful parenting is rooted in the belief that children are equals and should be respected, valued, and
                heard as individuals. Some of us may want our children to have a childhood different from ours, but we may
            </p>
        </div> --}}
        <div class="row">
            @foreach ($cp2_c as $cp)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="main-approach">
                        <div class="content-approach">
                            <div class="image-approach">
                                <img src="{{ asset($cp->image) }}" alt="" width="1000" height="667"
                                    style="max-width: 100%; height: auto;">
                            </div>
                            <div class="content-b">
                                <a href="{{$cp->link}}" target="_blank">
                                    <div class="title-approach-b">
                                        <h3>{{$cp->title}}</h3>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <x-pagination :paginator="$cp2_c" />
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


    <section id="our-parents">
        <div class="our-parents-slider">
            <div class="container">
                <div class="parents-title">
                    <h2 class="my-4">
                        {{ __('paper') }}
                    </h2>
                </div>
                @if ($papers->isNotEmpty())
                    <div class="bxslider">
                        @foreach ($papers as $testimonial)
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
                                        <a href="{{ $testimonial->link }}" class="primary-btn bg-white">
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
    </script>
@endpush
