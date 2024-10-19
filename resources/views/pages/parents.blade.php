@extends('pages.layouts.page')
@section('title', __('title-parent'))
@section('description', 'Description for Child Page')
@section('keyword', 'child, page, keywords')
@section('title-page', __('title-page-parent'))
@section('bg-page', asset($tab->banner))


@push('child-styles')
    <style>
        #for-parent .for-parent .image-parent img {
            width: 464px;
            height: 358px;
            border-radius: 32px;
            object-position: center center;
        }

        #for-parent .for-parent .content-parent {
            border-radius: 32px;
            background-color: #f3f4ee;
            padding: 48px 32px 32px;
            line-height: 24px;
            color: #333
        }

        #for-parent .for-parent .content-parent .title-parent h2 {
            color: #b70f1b;
            text-align: center;
            word-break: break-word;
        }

        #for-parent .for-parent .content-parent .line {
            border: 1px solid #f6f5f5;
            line-height: 24px;
            padding: 20px 20px;
        }

        @media screen and (min-width: 320px) {
            #for-parent .for-parent .image-parent img {
                width: 288px;
                height: 135px;
            }
        }

        @media screen and (min-width: 375px) {
            #for-parent .for-parent .image-parent img {
                width: 343px;
                height: 135px;
            }
        }

        @media screen and (min-width: 425px) {
            #for-parent .for-parent .image-parent img {
                width: 394px;
                height: 135px;
            }
        }
        @media screen and (max-width: 426px){
            .col-mg {
                margin-top: 10px
            }
        }

        @media screen and (min-width: 768px) {
            #for-parent .for-parent .image-parent img {
                width: 275px;
                height: 255px;
            }
        }

        @media screen and (min-width: 1024px) {
            #for-parent .for-parent .image-parent img {
                width: 378px;
                height: 255px;
            }
        }

        @media (max-width: 1600px) {
            h2 {
                font-size: 24px;
            }
        }
    </style>
@endpush


@section('content-page')
    <section id="for-parent">
        <div class="for-parent my-5">
            <div class="container">
                <div class="row ">
                    @if (!$tab_img_content->isEmpty())
                        @foreach ($tab_img_content as $content)
                            <div class="col-md-5 ">
                                <div class="image-parent ">
                                    @if (isset($content->image))
                                        <img src="{{ asset($content->image) }}" alt="">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-7 col-mg">
                                <div class="content-parent">
                                    <div class="title-parent">
                                        <h2>{{ $content->title }}</h2>
                                    </div>
                                    <div class="line"></div>
                                    <div class="desc-parent">
                                        <p>{!!$content->content !!}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>

    </section>

    <section id="srial-lesson" class="sign-up-pres">
        <div class="sign-up-lesson ">
            <div class="container">
                @include('pages.components.send-admission',['content' => __('to join the admission')])
            </div>
        </div>
    </section>
@endsection


@push('child-scripts')
@endpush
