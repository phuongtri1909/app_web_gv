@extends('pages.layouts.page')
@section('title', __('admission-process'))
@section('description', 'Tab admissions process')
@section('keyword', 'tab admissions process, tab admissions process brighton academy')
@section('title-page', __('admission-process'))
@section('bg-page', asset($tab->banner))
@push('child-styles')
    <style>
        .example-header {
            background: #3D4351;
            color: #FFF;
            font-weight: 300;
            padding: 3em 1em;
            text-align: center;
        }

        .example-header h1 {
            color: #FFF;
            font-weight: 300;
            margin-bottom: 20px;
        }

        .example-header p {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-weight: 700;
        }

        .container-fluid .row {
            padding: 0 0 4em 0;
        }

        .container-fluid .row:nth-child(even) {
            background: #F1F4F5;
        }

        .example-title {
            text-align: center;
            margin-bottom: 60px;
            padding: 3em 0;
        }

        .timeline {
            line-height: 1.4em;
            list-style: none;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .timeline-item {
            padding-left: 40px;
            position: relative;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        /*----- TIMELINE INFO -----*/

        .timeline-info {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 3px;
            margin: 0 0 .5em 0;
            text-transform: uppercase;
            white-space: nowrap;
        }

        /*----- TIMELINE MARKER -----*/

        .timeline-marker {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            width: 15px;
        }

        .timeline-marker:before {
            background: #FF6B6B;
            border: 3px solid transparent;
            border-radius: 100%;
            content: "";
            display: block;
            height: 15px;
            position: absolute;
            top: 4px;
            left: 0;
            width: 15px;
            transition: background 0.3s ease-in-out, border 0.3s ease-in-out;
        }

        .timeline-marker:after {
            content: "";
            width: 3px;
            background: #CCD5DB;
            display: block;
            position: absolute;
            top: 24px;
            bottom: 0;
            left: 6px;
        }

        .timeline-item:last-child .timeline-marker:after {
            content: none;
        }

        .timeline-item:not(.period):hover .timeline-marker:before {
            background: transparent;
            border: 3px solid #FF6B6B;
        }

        /*----- TIMELINE CONTENT -----*/

        .timeline-content {
            padding-bottom: 40px;
        }

        .timeline-content p:last-child {
            margin-bottom: 0;
        }

        .period {
            padding: 0;
        }

        .period .timeline-info {
            display: none;
        }

        .period .timeline-marker:before {
            background: transparent;
            content: "";
            width: 15px;
            height: auto;
            border: none;
            border-radius: 0;
            top: 0;
            bottom: 30px;
            position: absolute;
            border-top: 3px solid #CCD5DB;
            border-bottom: 3px solid #CCD5DB;
        }

        .period .timeline-marker:after {
            content: "";
            height: 32px;
            top: auto;
        }

        .period .timeline-content {
            padding: 40px 0 70px;
        }

        .period .timeline-title {
            margin: 0;
        }


        @media (min-width: 768px) {
            .timeline-split .timeline {
                display: table;
            }

            .timeline-split .timeline-item {
                display: table-row;
                padding: 0;
            }

            .timeline-split .timeline-info,
            .timeline-split .timeline-marker,
            .timeline-split .timeline-content,
            .timeline-split .period .timeline-info {
                display: table-cell;
                vertical-align: top;
            }

            .timeline-split .timeline-marker {
                position: relative;
            }

            .timeline-split .timeline-content {
                padding-left: 30px;
            }

            .timeline-split .timeline-info {
                padding-right: 30px;
            }

            .timeline-split .period .timeline-title {
                position: relative;
                left: -45px;
            }
        }

        @media (min-width: 992px) {

            .timeline-centered,
            .timeline-centered .timeline-item,
            .timeline-centered .timeline-info,
            .timeline-centered .timeline-marker,
            .timeline-centered .timeline-content {
                display: block;
                margin: 0;
                padding: 0;
            }

            .timeline-centered .timeline-item {
                padding-bottom: 40px;
                overflow: hidden;
            }

            .timeline-centered .timeline-marker {
                position: absolute;
                left: 50%;
                margin-left: -7.5px;
            }

            .timeline-centered .timeline-info,
            .timeline-centered .timeline-content {
                width: 50%;
            }

            .timeline-centered>.timeline-item:nth-child(odd) .timeline-info {
                float: left;
                text-align: right;
                padding-right: 30px;
            }

            .timeline-centered>.timeline-item:nth-child(odd) .timeline-content {
                float: right;
                text-align: left;
                padding-left: 30px;
            }

            .timeline-centered>.timeline-item:nth-child(even) .timeline-info {
                float: right;
                text-align: left;
                padding-left: 30px;
            }

            .timeline-centered>.timeline-item:nth-child(even) .timeline-content {
                float: left;
                text-align: right;
                padding-right: 30px;
            }

            .timeline-centered>.timeline-item.period .timeline-content {
                float: none;
                padding: 0;
                width: 100%;
                text-align: center;
            }

            .timeline-centered .timeline-item.period {
                padding: 50px 0 90px;
            }

            .timeline-centered .period .timeline-marker:after {
                height: 30px;
                bottom: 0;
                top: auto;
            }

            .timeline-centered .period .timeline-title {
                left: auto;
            }
        }

        .marker-outline .timeline-marker:before {
            background: transparent;
            border-color: #FF6B6B;
        }

        .marker-outline .timeline-item:hover .timeline-marker:before {
            background: #FF6B6B;
        }
    </style>
@endpush
@section('content-page')
    <div class="admission-process container">

        <div class="row example-centered">
            <div class="col-md-12 example-title">
                <h3 style="color:#b70f1b" class="fw-bold">{{ $tab_img_content->title }}</h3>
                <p class="mt-5">{{ $tab_img_content->content }}</p>
            </div>
            <div class="border-img-inner">
                <img class="img-fluid w-100" src="/images/duong-cong-dien-dan.png" alt="" srcset="">
            </div>
            <div class="col-xs-offset-1 col-12 col-sm-offset-2">
                <ul class="timeline timeline-centered">
                    @foreach ($process as $item)
                        <li class="timeline-item period">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h4 style="color:#b70f1b">{{ $item->title }}</h4>
                                <p class="mt-5">{{ $item->content }}</p>
                            </div>
                        </li>
                        @foreach ($item->process_detail as $item_detail)
                        <li class="timeline-item">
                            <div class="timeline-info">
                                <span>BrightonAcademy - Singapore</span>
                            </div>
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h5 class="timeline-title" style="color:#b70f1b">{{ $item_detail->title }}</h5>
                                <p class="mt-4">{!! $item_detail->content !!}</p>
                            </div>
                        </li>
                            
                        @endforeach
                        
                       
                    @endforeach
                </ul>
            </div>
        </div>

    </div>
@endsection
@push('child-scripts')

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tables = document.querySelectorAll('table');
    
        tables.forEach(function(table) {
            const wrapper = document.createElement('div');
            wrapper.classList.add('table-responsive');
            table.parentNode.insertBefore(wrapper, table);
            wrapper.appendChild(table);
        });
    });
    </script>
    
@endpush
