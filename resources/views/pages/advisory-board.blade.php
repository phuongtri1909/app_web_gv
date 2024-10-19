@extends('pages.layouts.page')
@section('title', $tab->title)
@section('description', $tab->title . ' page, ' . $tab->title . ' Brighton Academy, ' .$tab->slug . ' Brighton Academy')
@section('keyword', $tab->title . ' page, ' . $tab->title . ' Brighton Academy, ' .$tab->slug . ' Brighton Academy')
@section('title-page', $tab->title)
@section('bg-page', asset($tab->banner))
@push('child-styles')
    <link rel="stylesheet" href="{{ asset('asset/materialize/css/materialize.min.css') }}">
    <style>
        #advisory .img-inner {
            text-align: center
        }

        #advisory p {
            font-size: 15px
        }

        #advisory .img-inner img {
            height: 262px;
            width: 262px;
            padding: 25px;
        }

        #advisory .img-inner p {
            text-align: center;
        }

        #advisory .border-img-inner img {
            width: 100%;
            height: auto;
            display: block;
            /* padding-bottom: 30px */
        }

        #advisory .ask-img-inner img {
            width: 345px;
            height: 230px;
            object-fit: cover;
            margin-left: 20px
        }

        #advisory .ask-desc-inner p,
        #advisory .text-inner p {
            word-break: break-word;
            text-align: justify;
            font-size: 15px
        }

        #advisory .title-asks,
        #advisory .title-profess,
        #advisory .title-content-form {
            text-align: center
        }

        #advisory h2,h2 {
            color: #b70f1b;
        }

        #advisory .col-inner {
            display: flex;
        }

        #advisory .icon-img-asks img {
            height: 60px;
            width: 60px;
        }

        #advisory .icon-img-asks {
            padding-right: 1rem;
        }

        #advisory .reply-asks a {
            color: #b70f1b;
            text-transform: uppercase;
            font-weight: 500;
            font-size: 14px
        }

        #advisory .reply-asks:hover a {
            text-decoration: underline;
        }

        #advisory .name-profess {
            text-align: center;
        }

        #advisory .bx-default-pager .bx-pager-item a {
            display: none;
        }

        #advisory .bx-wrapper {
            border: none;
            box-shadow: none;
            margin: 0 auto;
        }

        #advisory .content-form {
            margin: auto;
            border-radius: 16px;
            background: url(images/mg.jpg) no-repeat;
            background-size: 111%;
            box-shadow: rgba(0, 0, 0, .35) 0 5px 15px;
            width: 100%;
        }

        #advisory .form-group {
            margin-bottom: 1rem;
        }

        #advisory .form-group input,
        #advisory .title-inner-content input,
        #advisory .form-group select,
        #advisory .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            margin-bottom: 1rem;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);
        }

        #advisory .title-inner-content input {
            margin-bottom: 0;
        }

        ::placeholder,
        #advisory label {
            color: #000;
            font-size: 15px;
            font-weight: 500;
        }

        #advisory .form-group input:focus,
        #advisory .title-inner-content input:focus,
        #advisory .form-group select:focus,
        #advisory .form-group textarea:focus {
            box-shadow: 0 0 5px #ccc;
            opacity: 1 !important;
            outline: none
        }

        #advisory .form-group span {
            width: 50%;
            padding-right: 5px;
        }

        #advisory .form-group textarea {
            height: 100px;
            resize: none;
        }

        #advisory .form-control-i {
            background: unset
        }

        #advisory .form-group.captcha {
            display: flex;
            align-items: center;
        }

        #advisory .form-group.captcha input[type="checkbox"] {
            margin-right: 10px;
        }

        #advisory .form-group.captcha img {
            margin-left: auto;
            height: 30px;
        }

        #advisory .btn-submit-form {
            display: grid;
            justify-content: center;
            padding: 10px 10px;
        }

        #advisory .btn-submit-form-forum button,
        #advisory .btn-submit-form button {
            /* width: 100%; */
            padding: 5px 13px;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;

        }

        #advisory .btn-submit-form-forum span:hover,
        #advisory .btn-submit-form button:hover {
            background-color: #218838;
        }

        #advisory .forum-asks .title-forum {
            border-bottom: 1px solid #ccc;
            margin-bottom: 10px;
        }

        #advisory .content-forum {
            box-sizing: border-box;
            box-shadow: rgba(0, 0, 0, .16) 0 3px 6px, rgba(0, 0, 0, .23) 0 3px 6px;
            border: 1px solid #f0f0f0;
            border-radius: 6px;
            position: relative;
            cursor: pointer;
        }

        #advisory .title-inner-content input {
            width: 81%;

        }

        #advisory .title-inner-content {
            padding: 10px 25px;
        }

        #advisory p.col-pd {
            margin: 0;
        }

        #advisory .title-questions {
            margin-top: 1rem;
        }

        #advisory .col-pd {
            padding: 0px 25px;
        }

        #advisory .col-answer {
            border: solid 2px red;
            border-radius: 6px;
            text-align: center;
            height: 53px;
            width: 120px;
            margin-top: 31px;
            margin-left: 35px;
            margin-right: 6px;
            padding-top: 13px;
        }

        #advisory .col-answer p {
            color: red;
            font-weight: 700;
            font-size: medium;
        }

        #advisory .col-list-view {
            margin-top: 30px;
            margin-left: 15px;
            background-color: #fff;
            border: 1px solid;
            border-radius: 6px;
            color: #666;
            height: auto;
            padding-bottom: 5px;
            /* padding-left: 0px; */
            padding-top: 4px;
            /* padding-right: 39px; */
            text-transform: uppercase;
        }

        #advisory .col-list-view p {
            text-align: center;
            font-size: 10px !important;
            margin: 5px;
        }

        #advisory .col-w {
            width: 100%;
        }

        #advisory .col-rem {
            /* margin-left: -5rem; */
        }

        #advisory .hover-bg:hover {
            background-color: #f5f5f5;
        }

        #advisory .answer-container {
            max-width: 1296px;
            border-radius: 8px;
            font-family: Arial, sans-serif;
            color: #555;
        }

        #advisory.answer-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        #advisory .expert-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-right: 20px;
            object-fit: cover;
            float: left;
        }

        #advisory .answer-title h3 {
            font-size: 18px;
            color: #01060c;
            font-weight: 600;
            margin: 0;
        }

        #advisory .answer-content p {
            margin: 10px 0;
            line-height: 1.6;
        }

        #advisory .bt-border {
            border-bottom: 1px solid #ccc;
            margin-bottom: 2rem;
        }

        #advisory .count-answer {
            border-bottom: 1px solid #ccc;
        }

        #advisory .hover-bg {
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
        }

        #advisory .pagination {
            margin-bottom: 0;
        }

        #advisory .pagination-content-forum {
            border-top: 1px solid #ccc;
        }

        #advisory .btn-submit-form-forum a {
            position: absolute;
            right: 0px;
        }
        #advisory .pagination-content-forum .btn-submit-form-forum a {
            position: absolute;
            right: 6.5rem;
        }
        #advisory .btn-pagi {
            /* float: right; */
            padding-top: 13px;
            padding-right: 12px;
            margin-bottom: 37px;
        }

        #advisory .box {
            float: left;
            width: 50%;
        }

        #advisory .btn-pagi button {
            background-color: rgb(71, 186, 117);
        }

        #advisory .show-content-answer {
            display: none;
            overflow: hidden;
        }

        #advisory .ask-img-inner {
            display: grid;
            place-items: center;
        }

        #advisory .page-item {
            padding-left: 10px;
            margin-top: 19px;
        }

        #advisory .page-link {
            background-color: rgb(71, 186, 117);
            border: 1px none;
            border-radius: 4px;
            cursor: pointer;
            padding: 5px 13px;
            color: #ffff;
        }

        #advisory .page-link.active {
            background-color: rgb(19, 108, 55);
        }

        #advisory .image-container {
            position: relative;
            display: inline-block;
            margin: 20px;
        }

        #advisory .image-container .star {
            position: absolute;
            top: 2px;
            left: 44%;
            transform: translateX(-50%);
            padding: 0px;
            border-radius: 50%;
            color: #db2d48;
        }

        #advisory .image-container .curve {
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

        #advisory .image-container .curve::after {
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

        @media screen and (max-width: 425px) {
            #advisory .image-container .curve {
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

            #advisory .image-container .curve::after {
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

            #advisory .image-container .star {
                top: -3px;
                left: 41%;
            }

        }

        @media (max-width: 425px) {

            #advisory .img-inner img {
                height: 156px;
                width: 156px;
                padding: 15px;
            }

            #advisory .ask-img-inner img {
                width: 143px;
                /* height: 95px; */
                margin-left: 0px;
            }
        }

        @media (max-width: 575px) {

            #advisory .asks-img-center {
                display: grid;
                justify-content: center;
                padding: 1rem 0 1rem 0;
            }

            #advisory .show-bxslider {
                display: block !important;
                margin: 0 auto;
            }

            #advisory .show-bxslider img {
                margin: 0 auto;
            }

            #advisory .show-bxslider .bx-controls-direction {
                display: none;
            }

            #advisory .col-list-view {
                border: none !important;
                box-shadow: rgba(0, 0, 0, .16) 0 3px 6px, rgba(0, 0, 0, .23) 0 3px 6px;
                border-radius: 6px !important;
                margin-top: 0px !important;
                left: 6%;
                width: 24%;
                bottom: 10px;
                position: relative;
            }

            #advisory .btn-submit-form-forum button {
                border-radius: 8px !important;
                background-color: rgb(71, 186, 117) !important;
                color: #fff !important;
                position: relative;
                left: 10px;
            }

            #advisory .title-inner-content input {
                width: 49% !important;
                border-radius: 6px !important;
                position: relative;
            }
        }

        @media (max-width: 768px) {

            #advisory .show-bxslider {
                display: none;
            }

            #advisory .col-answer {
                display: none;
            }

            #advisory .col-list-view {
                border: none !important;
                box-shadow: rgba(0, 0, 0, .16) 0 3px 6px, rgba(0, 0, 0, .23) 0 3px 6px;
                border-radius: 6px !important;
                margin-top: 0px !important;
                left: 6%;
                width: 24%;
                bottom: 0px;
                position: relative;
            }

            #advisory .ask-img-inner img {
                width: 266px;
            }
            .navigation-buttons.right {
                right: 2rem !important;
            }

        }
        @media (max-width: 991px) {
            #parent-concern .kids-row .kids-col{
                -webkit-box-flex: 0;
                -ms-flex: 0 0 100%;
                flex: 0 0 100%;
                max-width: 100%;
                padding: 0;
            }
        }
        @media (max-width: 1200px) {
            #advisory .col-list-view {
                border: none !important;
                box-shadow: rgba(0, 0, 0, .16) 0 3px 6px, rgba(0, 0, 0, .23) 0 3px 6px;
                border-radius: 6px !important;
                margin-top: 0px !important;
                left: 6%;
                width: 24%;
                position: relative;
            }

            #advisory .col-w {
                padding: 10px;
            }

            #advisory .pagination-content-forum .btn-submit-form-forum a {
                position: absolute;
                right: 11px;
            }
        }

        #advisory .carousel-custom {
            height: 600px;
        }

        #advisory .carousel-custom .carousel-item-custom {
            width: 300px;
            height: 500px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            animation: animate 2s infinite alternate;

        }

        #advisory .carousel-dots {
            text-align: center;
            margin-top: 10px;
        }

        #advisory .carousel-dots .dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            margin: 0 5px;
            background-color: #ddd;
            border-radius: 50%;
            transition: background-color 0.3s;
            cursor: pointer;
        }

        #advisory .carousel-dots .dot.active {
            background-color: #cb0e12;
        }


        .carousel-item-custom {
            position: relative;
            overflow: hidden;
        }

        #advisory .carousel-item-custom img {
            width: 100%;
            height: auto;
        }

        #advisory .overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #cb0e12;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: translateY(100%);
            transition: transform 0.3s ease-in-out;
            text-align: center;
        }

        #advisory .carousel-item-custom:hover .overlay {
            transform: translateY(0);
        }

        #advisory .overlay-content {
            padding: 20px;
            max-height: 100%;
            overflow-y: auto;
        }
        #parent-concern .kids-detail{
            margin: 0 auto;
            height: 100%;
            padding: 5px 25px;
        }
        #parent-concern p {
            margin-bottom: 0px;
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
        .position-r{
            position: relative;
            /* overflow: hidden; */
        }
        .gallery-container {
            text-align: center;
        }

        .main-image {
            display: flex;
            transition: opacity 0.5s ease;
            margin-bottom: 10px;
        }

        .main-image img {
            width: 100%;
            flex-shrink: 0;
            height: auto;
            display: none;
        }

        .main-image img:first-child {
            display: block;
        }

        .thumbnail-gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        .thumbnail-gallery img {
            width: calc(100% / 6 - 10px);
            max-height: 118px;
            cursor: pointer;
            object-fit: cover;
            border: 2px solid transparent;
            transition: border-color 0.3s;
        }

        .thumbnail-gallery img:hover {
            border-color: #007BFF;
        }

        .navigation-buttons {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        .navigation-buttons.left {
            left: -5rem;
        }

        .navigation-buttons.right {
            right:  -5rem;
        }

        .navigation-buttons button {
            background-color: rgba(225, 225, 225, 0.5);
            color: #80b157;
            border: none;
            padding:15px 15px 15px 10px;
            cursor: pointer;
            height: 30px;
            width: 30px;
            font-size: 24px;
            border-radius: 50%;
            font-weight: 700;
            display: inline-flex;
            justify-items: center;
            align-items: center;
        }

        .navigation-buttons button:hover {
            background-color: rgb(227, 60, 60);
        }
    </style>
@endpush

@section('content-page')
    <section>
        <div id="advisory">
            <div class="container">
                <div class="row my-5">
                    <div class="title-asks mb-4">
                        <h2>{{ __('scientific_advisory_board') }}</h2>
                        <br>
                        <p class="desc-introduce text-center container-kids">{{__('motacovan')}}</p>
                    </div>
                </div>
                @if(!is_null($personnel) && $personnel->isNotEmpty())
                    <div class="carousel-custom">
                        @foreach ($personnel as $item)
                            <div class="carousel-item-custom">
                                <img class="img-fluid" src="{{ asset($item->image) }}" alt="{{ $item->full_name }}">
                                <div class="overlay">
                                    <div class="overlay-content">
                                        <h5>{{ $item->full_name }}</h5>
                                        <p>{{ $item->description }}</p>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h5 class="text-center mt-1" style="color: #e65c5f">{{ $item->full_name }}</h5>
                                    <span class="text-center">{{ $item->position }}</span>
                                    <h6 class="text-center" style="color: #cb0e12">Brighton Academy</h6>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="carousel-dots">
                        @foreach ($personnel as $item)
                            <a class="dot"></a>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="container">
                <div class="row my-5">
                    <div class="title-asks mb-4">
                        <h2>{{ __('benefits_forum') }}</h2>
                    </div>
                    @if($forumsCp1->isEmpty())
                        {{-- <p>{{__('no_find_data')}}</p> --}}
                    @else
                        @foreach($forumsCp1 as $forum)
                                <div class="col-lg-4 col-md-4 col-sm-6 img-inner">
                                    <div class="image-container">
                                        <img src="{{ asset($forum->image) }}" alt="" srcset="">
                                        <div class="star">★</div>
                                        <div class="curve"></div>
                                    </div>
                                    <p>
                                        <strong>
                                            {!! $forum->title !!}
                                        </strong>
                                    </p>
                                </div>
                        @endforeach
                    @endif
                </div>

            </div>
            <div class="container">
                <div class="row">
                    <div class=" col col-lg-12  col-sm-12">
                        <div class="border-img-inner">
                            <img src="{{ asset('images/duong-cong-dien-dan.png') }}" alt="" srcset="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                @if(!$forumCp2)
                    {{-- <p>{{ __('no_find_data') }}</p> --}}
                @else
                    <div class="row my-5 put-asks">
                        <div class="col-lg-6 col-md-12 col-sm-6 order-2 ">
                            <div class="ask-desc-inner">
                                <p>{!! $forumCp2->title !!}</p>
                                <a href="#form-asks" class="btn btn-success w-100" role="button">
                                    <span>{{ __('ask_questions') }}?</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-6 asks-img-center">
                            <div class="ask-img-inner">
                                <img src="{{ asset($forumCp2->image) }}" alt="" srcset="">
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="container">
                <div class="row">
                    <div class=" col col-lg-12  col-sm-12">
                        <div class="border-img-inner ">
                            <img src="{{ asset('images/duong-cong-dien-dan.png') }}" alt="" srcset="">
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="container">
                <div class="row my-5">
                    @if(!empty($question_asks) && $question_asks->isNotEmpty() )
                        <div class="title-asks mb-4">
                            <h2>{{ __('frequently_asked') }}</h2>
                        </div>
                    @endif
                    @forEach($question_asks as $question)
                         @forelse ($question->answers as $answer)
                            <div class="col-lg-4 col-sm-12 col-md-4 py-4">
                                <div class="col-inner">
                                    <div class="icon-img-asks">
                                        <div class="icon-inner">
                                            <img src="{{ asset('images/ikon1.png') }}" alt="" srcset="">
                                        </div>
                                    </div>
                                    <div class="text-content-asks">
                                        <div class="text-inner">
                                            <p>{{$answer->title}}</p>
                                        </div>
                                        <div class="reply-by-admin" style="display: none;">
                                            {!! $answer->content !!}
                                        </div>
                                        <div class="reply-asks">
                                            <a href="#" class="toggle-reply">{{ __('answers_t') }}</a>
                                        </div>
                                        <div class="reply-asks" style="display: none;">
                                            <a href="#" class="toggle-reply">{{ __('collapsible') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="no-data">
                                <p>{{ __('No answers available for this question.') }}</p>
                            </div>
                        @endforelse
                    @endforeach
                </div>
            </div> --}}
            @if($question_asks->isNotEmpty())
                <div class="container-kids" id="parent-concern">
                    <div class="row my-5">
                        <div class="title-asks mb-4">
                            <h2>{{ __('parents_concern') }}</h2>
                        </div>
                        @foreach($question_asks as $index => $ask)
                            <div class="my-4" >
                                <div class="title-aks-concern">
                                    <p> <i class="fa-regular fa-circle-question"></i> {{__('questions_about')}} {{ $ask->category->name }}: @foreach ($ask->answers as $answer)<span style=" word-break: break-word;">{{ $answer->title }}</span>@endforeach</p>
                                    <p>{{__('expert_answers')}}:</p>
                                </div>
                                <div class="kids-content">
                                    <div class="kids-main">
                                        <div class="kids-border kids-row kids-image">
                                            <div class="order-2 kids-col">
                                                <div class="kids-img">
                                                    @foreach ($ask->answers as $answer)
                                                        <img src="{{ asset($answer->image) }}" alt="" srcset="">
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="kids-col">
                                                <div class="kids-detail answer-content " style="word-break: break-word;">
                                                    <p id="description-about">
                                                        <span id="descriptionContent-{{ $index }}">
                                                            @php
                                                                $answerContent = '';
                                                                foreach ($ask->answers as $answer) {
                                                                    $answerContent .= $answer->content;
                                                                }
                                                            @endphp
                                                            {!! Str::limit($answerContent, 1000) !!}
                                                        </span>
                                                    </p>

                                                    @if (strlen(strip_tags($answerContent)) > 1000)
                                                        <a href="javascript:void(0);" class="primary-btn bg-white" id="learnMoreBtnAbout-{{ $index }}" data-full-description="{!! e($answerContent) !!}">
                                                            <span>{{ __('learn_more') }} <i class="arrow"></i></span>
                                                        </a>
                                                    @endif

                                                    <div id="descriptionModal-{{ $index }}" class="modal descriptionModal" style="display: none;" role="dialog" aria-describedby="fullDescription-{{ $index }}">
                                                        <div class="modal-content">
                                                            <span class="close close-program" data-index="{{ $index }}">&times;</span>
                                                            <div class="modal-body">
                                                                <p id="fullDescription-{{ $index }}"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{-- @include('pages.components.pagination_2', ['question_asks' => $question_asks]) --}}
                        <x-pagination :paginator="$question_asks" />
                    </div>
                </div>
            @endif
            <div class="container">
                <div class="row">
                    <div class=" col col-lg-12  col-sm-12">
                        <div class="border-img-inner ">
                            <img src="{{ asset('images/duong-cong-dien-dan.png') }}" alt="" srcset="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="content-form col col-lg-12  col-sm-12 my-5" id="form-asks">
                        <div class="title-content-form my-4">
                            <h2>{{ __('ask_questions') }}</h2>
                        </div>
                        @include('pages.notification.success-error')
                        <div class="detail-content-form">
                            <form action="{{ route('questions.store') }}" method="post" id="form_send_asks">
                                @csrf
                                <div class="form-group col-inner">
                                    <span>
                                        <input type="text" name="name" class="form-control"
                                            placeholder="{{ __('your_name') }}" required>
                                    </span>
                                    <span>
                                        <input type="number" name="phone" class="form-control"
                                            placeholder="{{ __('phone') }}">
                                    </span>
                                </div>
                                {{-- <div class="form-group">
                                    <label for="location">Chọn cơ sở</label>
                                    <select name="location" class="form-control-i" id="location" required>
                                        <option value="">---</option>
                                        <!-- Add options here -->
                                    </select>
                                </div> --}}
                                <div class="form-group w-50">
                                    <input type="email" name="email" class="form-control"
                                        placeholder="{{ __('email') }}">
                                </div>
                                <div class="form-group">
                                    <textarea name="content" class="form-control" placeholder="{{ __('content') }}" required></textarea>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                                </div>
                                <div class="form-group btn-submit-form">
                                    <button type="submit">{{ __('send') }} <i
                                            class="fa-solid fa-paper-plane"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col col-lg-12  col-sm-12">
                        <div class="forum-asks">
                            <div class="title-forum">
                                <h2>{{ __('q_&_a') }}</h2>
                            </div>
                        </div>
                        <div class="content-forum mb-4">
                            <div class="title-inner-content col-inner">
                                <input type="text" id="myInput" placeholder="{{ __('want_to_know') }}"
                                    class="">
                                <div class=" btn-submit-form-forum">
                                    <a href="#form-asks" class="btn btn-succes" role="button">
                                        <button>{{ __('send_question') }}</button>
                                    </a>
                                </div>
                            </div>
                            {{-- <hr> --}}
                                @foreach ($questions as $question)
                                    @forelse ($question->answers as $answer)
                                        <div id="section-forum" style="display:block;">
                                            <div class="hover-bg" id="hover-bg-{{ $answer->id }}"
                                                onclick="incrementView({{ $question->id }})">
                                                <div class="row ">
                                                    <div class="col-lg-6 col-md-6 col-sm-12 ">
                                                        <div class="title-questions" style="word-break: break-word;">
                                                            <h4 class="col-pd">{{ $answer->title }}</h4>
                                                        </div>
                                                        <p class="col-pd">{{ __('guest_visits') }}</p>
                                                        <p class="col-pd mb-4">{{ $answer->created_at->format('d/m/y') }}</p>
                                                    </div>
                                                    <div class="col-lg-2 col-md-2 col-sm-12 col-re col-answer">
                                                        <div class="btn-reply-questions ">
                                                            <a role="button">
                                                                <p>{{ __('answer') }}</p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 ">
                                                        <div class="col-w ps-re">
                                                            <div class="row">
                                                                <div class="col-list-view col-md-3 col-sm-12 col-lg-3">
                                                                    <p id="view-count-{{ $question->id }}">
                                                                        {{ $question->view }}</p>
                                                                    <p>{{ __('views') }}</p>
                                                                </div>
                                                                <div class="col-list-view col-md-3 col-sm-12 col-lg-3">
                                                                    <p>{{ $question->count_answer }}</p>
                                                                    <p>{{ __('reply') }}</p>
                                                                </div>
                                                                <div class="col-list-view col-md-3 col-sm-12 col-lg-3">
                                                                    <p>{{ $question->follow }}</p>
                                                                    <p>{{ __('follow') }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <hr> --}}
                                            <div class="show-content-answer" id="show-content-answer-{{ $answer->id }}">
                                                <div class="row my-4">
                                                    <div class="answer-aks-reply">
                                                        <div class="col-sm-12 col-lg-12">
                                                            <div class="desc-questions col-pd" style="word-break: break-word;;">
                                                                <p>{{ $question->content }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-lg-12">
                                                            <div class="q-anwser col-pd">
                                                                <h3 class="bt-border">
                                                                    <span class="count-answer">{{ $question->count_answer }}
                                                                        answer</span>
                                                                </h3>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-lg-12">
                                                            <div class="answer-container col-pd">
                                                                <div class="answer-header">
                                                                    <div class="answer-title">
                                                                        <img src="{{ asset($answer->image) }}"
                                                                            alt="Expert Image" class="expert-image">
                                                                        <div class="answer-content" style="word-break: break-word;;">
                                                                            <p>{!! $answer->content !!}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="no-data">
                                            {{-- <p>{{ __('No answers available for this question.') }}</p> --}}
                                        </div>
                                    @endforelse
                                @endforeach
                            </div>
                            <div class="pagination-content-forum ">
                                <div class="container">
                                    <div class="clearfix mb-3">
                                        @include('pages.components.pagination', ['questions' => $questions])
                                        <div class=" btn-submit-form-forum btn-pagi box">
                                            <a href="#form-asks" class="btn btn-succes" role="button">
                                                <button>{{ __('send_question') }}</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-kids position-r">
                @if ($forumsCp3->isNotEmpty() && $forumsCp3->contains(function ($forum) {
                    return !empty($forum->image);
                }))
                    <div class="navigation-buttons left">
                        <button onclick="prevImage()">&#10094;</button>
                    </div>
                    <div class="gallery-container">
                        <h2>{{ __('gallery') }}</h2>
                        <div class="main-image" id="mainImageContainer">
                            @foreach ($forumsCp3 as $forum)
                                @foreach ($forum->image as $index => $imagePath)
                                    <img id="mainDisplay-{{ $forum->id }}-{{ $index }}" src="{{ asset($imagePath) }}" alt="Main Image" style="{{ $index === 0 ? '' : 'display:none;' }}" />
                                @endforeach
                            @endforeach
                        </div>

                        <div class="thumbnail-gallery">
                            @foreach ($forumsCp3 as $forum)
                                @foreach ($forum->image as $index => $imagePath)
                                    <img src="{{ asset($imagePath) }}" alt="Thumbnail" onclick="changeImage({{ $forum->id }}, {{ $index }})" />
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                    <div class="navigation-buttons right">
                        <button onclick="nextImage()">&#10095;</button>
                    </div>
                @endif
            </div>

        </div>
    </section>

@endsection

@push('child-scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="{{ asset('asset/materialize/js/materialize.min.js') }}"></script>
    <script >
        document.addEventListener('DOMContentLoaded', function() {
            const search = document.getElementById("myInput");
            const els = document.querySelectorAll("#section-forum");

            if (search) {
                search.addEventListener("keyup", function() {
                    const searchTerm = search.value.toLowerCase();

                    els.forEach(el => {
                        const textContent = el.textContent.toLowerCase();
                        if (textContent.includes(searchTerm)) {
                            el.style.display = 'block';
                        } else {
                            el.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
    {{-- <script>
        $(document).ready(function() {
            $('.toggle-reply').on('click', function(event) {
                event.preventDefault();
                var $textContent = $(this).closest('.text-content-asks');
                var $replyByAdmin = $textContent.find('.reply-by-admin');
                var $replyAsks = $textContent.find('.reply-asks');

                if ($replyByAdmin.is(':hidden')) {
                    $replyByAdmin.slideDown();
                    $replyAsks.eq(0).hide();
                    $replyAsks.eq(1).show();
                } else {
                    $replyByAdmin.slideUp();
                    $replyAsks.eq(0).show();
                    $replyAsks.eq(1).hide();
                }
            });
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            $(".hover-bg").click(function() {
                var id = $(this).attr('id').split('-').pop();
                $("#show-content-answer-" + id).slideToggle("slow");
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if (target.length) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top
                    }, 100);
                }
            });
        });
    </script>
    <script>
        var viewedQuestions = {};

        function incrementView(questionId) {
            // Kiểm tra nếu câu trả lời đã được xem chưa
            if (!viewedQuestions[questionId]) {
                $.ajax({
                    url: '{{ route('questions.incrementView', ':id') }}'.replace(':id', questionId),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Cập nhật trạng thái đã xem
                            viewedQuestions[questionId] = true;
                            // Cập nhật lượt xem
                            $('#view-count-' + questionId).text(response.view);
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('{{ __('view_error') }}');
                    }
                });
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#form_send_asks').on('submit', function() {
                localStorage.setItem('scrollPosition', $(window).scrollTop());
            });

            const scrollPosition = localStorage.getItem('scrollPosition');
            if (scrollPosition) {
                $(window).scrollTop(scrollPosition);
                localStorage.removeItem('scrollPosition');
            }
        });
    </script>
     <script>
         $(document).ready(function() {
             $('.carousel-custom').CarouselCustom({
                 padding: 300,
                 indicators: false,
                 onCycleTo: function(item) {
                     var index = Array.from(document.querySelectorAll('.carousel-item-custom')).indexOf(
                         item);
                     document.querySelectorAll('.carousel-dots .dot').forEach((dot, i) => {
                         dot.classList.toggle('active', i === index);
                     });
                 }
             });
             document.querySelector('.carousel-dots .dot').classList.add('active');
         });
     </script>
    <script>
        function openModal(index) {
            let modal = $(`#descriptionModal-${index}`);
            let fullContent = $(`#learnMoreBtnAbout-${index}`).data('full-description');
            modal.find('.modal-body p').html(fullContent); // Cập nhật nội dung trong modal
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
            let question_asks = @json($question_asks);

            if (!Array.isArray(question_asks)) {
                question_asks = Object.values(question_asks);
            }

            // Event delegation for opening modals
            $(document).on('click', '[id^="learnMoreBtnAbout-"]', function() {
                let index = $(this).attr('id').split('-')[1];
                openModal(index);
            });

            // Close modal on button click
            $(document).on('click', '.close-program', function() {
                closeModal($(`#descriptionModal-${$(this).data('index')}`));
            });

            // Close modal when clicking outside
            $(window).on('click', function(event) {
                $('[id^="descriptionModal-"]').each(function() {
                    if ($(event.target).is(this)) {
                        closeModal($(this));
                    }
                });
            });
        });
    </script>
    <script>
       let currentForumIndex = {};

        function changeImage(forumId, index) {
            const mainImageContainer = document.getElementById('mainImageContainer');

            const imageElements = mainImageContainer.querySelectorAll(`img[id^="mainDisplay-${forumId}"]`);


            imageElements.forEach((img) => {
                img.style.display = 'none';
            });

            imageElements[index].style.display = 'block';
            currentForumIndex[forumId] = index;
        }


        function prevImage() {
            for (let forumId in currentForumIndex) {
                currentForumIndex[forumId]--;
                const imageElements = document.querySelectorAll(`img[id^="mainDisplay-${forumId}"]`);

                if (currentForumIndex[forumId] < 0) {
                    currentForumIndex[forumId] = imageElements.length - 1;
                }
                changeImage(forumId, currentForumIndex[forumId]);
            }
        }

        function nextImage() {
            for (let forumId in currentForumIndex) {
                currentForumIndex[forumId]++; // Tăng chỉ số
                const imageElements = document.querySelectorAll(`img[id^="mainDisplay-${forumId}"]`);

                if (currentForumIndex[forumId] >= imageElements.length) {
                    currentForumIndex[forumId] = 0;
                }
                changeImage(forumId, currentForumIndex[forumId]);
            }
        }

        // Auto slide function
        function autoSlide() {
            for (let forumId in currentForumIndex) {
                nextImage(forumId);
            }
        }

        setInterval(autoSlide, 10000);

    </script>

@endpush
