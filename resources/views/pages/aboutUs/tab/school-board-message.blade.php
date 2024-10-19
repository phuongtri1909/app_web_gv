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
    <link rel="stylesheet" href="{{ asset('asset/materialize/css/materialize.min.css') }}">
    <style>
        #component-2 .title-sub-page h2 {
            font-family: commerceB;
            text-align: right;
            color: transparent;
            background: url({{ asset('images/moitruonghoctap.jpg') }}) 0 0 / cover;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-attachment: fixed;
            white-space: nowrap;
            font-size: 5rem !important;
        }

        #component-2 .text-wrap {
            padding: 3rem 5rem;
            text-align: justify;
            border: 6px solid #cb0e12;
            border-left: 0;
            position: relative;
        }

        #component-2 .text-wrap::before {
            top: 0;
            content: "";
            position: absolute;
            width: 6px;
            height: 5rem;
            left: 0;
            background-color: #cb0e12;
        }

        #component-2 .text-wrap::after {
            content: "";
            position: absolute;
            width: 6px;
            height: 5rem;
            left: 0;
            bottom: 0;
            background-color: #cb0e12;
        }

        @media (max-width: 767.98px) {
            #component-2 .title-sub-page h2 {
                white-space: normal;
                text-align: center;
                line-height: 1.2;
                font-size: 3rem !important;
            }
        }


        #component-3 .carousel-custom {
            height: 600px;
        }

        #component-3 .carousel-custom .carousel-item-custom {
            width: 300px;
            height: 500px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            animation: animate 2s infinite alternate;

        }

        #component-3 .carousel-dots {
            text-align: center;
            margin-top: 10px;
        }

        #component-3 .carousel-dots .dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            margin: 0 5px;
            background-color: #ddd;
            border-radius: 50%;
            transition: background-color 0.3s;
            cursor: pointer;
        }

        #component-3 .carousel-dots .dot.active {
            background-color: #cb0e12;
        }


        .carousel-item-custom {
            position: relative;
            overflow: hidden;
        }

        #component-3 .carousel-item-custom img {
            width: 100%;
            height: auto;
        }

        #component-3 .overlay {
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

        #component-3 .carousel-item-custom:hover .overlay {
            transform: translateY(0);
        }

        #component-3 .overlay-content {
            padding: 20px;
            max-height: 100%;
            overflow-y: auto;
        }

        .title-introduce {
            color: #b70f1b;
        }

        .custom-select-container {
            position: relative;
            width: 300px;
        }

        .custom-select {
            appearance: none;
            width: 100%;
            padding: 12px;
            border: 2px solid #5d9cec;
            border-radius: 10px;
            background-color: white;
            color: #333;
            font-size: 16px;
            cursor: pointer;
            transition: border-color 0.3s ease;
        }

        .custom-select:hover,
        .custom-select:focus {
            border-color: #428bca;
            outline: none;
        }

        /* Animation container */
        .selected-item {
            position: absolute;
            left: 10px;
            top: -30px;
            color: #428bca;
            font-weight: bold;
            font-size: 14px;
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.4s, transform 0.4s;
        }

        .selected-item.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Custom Arrow */
        .custom-select-container::after {
            content: '▼';
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            font-size: 12px;
            color: #428bca;
            pointer-events: none;
        }
    </style>
@endpush

@section('content-page')
    <section class="container py-3 py-md-5" id="component-2">
        <div class="d-flex flex-column flex-md-row align-items-md-center">
            <div class="title-sub-page">
                <h2>{!! __('school-board-message-2') !!}</h2>
            </div>
            <div class="text-wrap">
                <p class="newspaper-style">
                    {{ $content_first->content }}
                </p>
            </div>
        </div>
    </section>

    @if (!empty($campus))
        <section id="component-3" class="container pt-5">
            <div class="introduce">
                <div class="text-center ">
                    <h3 class="title-introduce">
                        {{ $campus->title }}
                    </h3>

                    <p class="desc-introduce">
                        {{ $campus->description }}
                    </p>

                    <div class="d-flex justify-content-center mt-5">
                        <div class="custom-select-container text-center">
                            <div class="selected-item" id="selectedItem">{{ __('selected_campus') }}: </div>
                            <form id="selectCampusForm" action="{{ route('select-campus') }}" method="POST">
                                @csrf
                                <select class="custom-select" id="mySelect" name="campus_id">
                                    @foreach ($campuses as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $campus->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @if ($personnel->isEmpty())
            @else
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
        </section>
    @endif
    @if (!$collapses == null)
        @include('pages.components.collapse')
    @endif


@endsection
@push('scripts')
    <script src="{{ asset('asset/materialize/js/materialize.min.js') }}"></script>
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
        const selectElement = document.getElementById('mySelect');
        const selectedItemElement = document.getElementById('selectedItem');
        const formElement = document.getElementById('selectCampusForm');

        function updateSelectedItem() {
            const selectedValue = selectElement.options[selectElement.selectedIndex].text;
            selectedItemElement.innerHTML = `{{ __('selected_campus') }}: ${selectedValue}`;
            selectedItemElement.classList.add('active');

            setTimeout(() => {
                selectedItemElement.classList.remove('active');
                formElement.submit();
                localStorage.setItem('scrollPosition', window.scrollY);
            }, 1000);
        }

        selectElement.addEventListener('change', updateSelectedItem);


        const scrollPosition = localStorage.getItem('scrollPosition');
        if (scrollPosition) {
            $(window).scrollTop(scrollPosition);
            localStorage.removeItem('scrollPosition');
        }
    </script>
@endpush
