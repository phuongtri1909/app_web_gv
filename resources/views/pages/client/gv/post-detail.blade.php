@extends('pages.layouts.page')
@section('title', $blog->name)

@push('child-styles')
    <style>
    .tabs-container {
        max-width: 100%;
        margin: 0 auto;
        padding: 20px;
    }

    .tabs {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .tab-button {
        background-color: #fff;
        padding: 12px 30px;
        cursor: pointer;
        margin: 10px;
        outline: none;
        font-size: 16px;
        color: #333;
        border-radius: 5px 5px 0 0;
        transition: all 0.3s ease-in-out, transform 0.2s ease;
        transform: translateY(0);
        border: 1px solid #4584e8;
    }

    .tab-button.active, .tab-button:hover {
        background-color: #4584e8;
        font-weight: bold;
        color: #fff;
        transform: translateY(-3px);
    }

    .tabs-content {
        padding: 20px;
        border-radius: 0 0 5px 5px;
        background-color: #fff;
        overflow: hidden;
    }

    .tab-content {
        display: none;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.5s ease;
    }

    .tab-content.active {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }
    @media (max-width: 768px) {
        .tab-button {
            padding: 10px 20px;
            font-size: 14px;
            margin-right: 5px;
        }

        .tabs {
            flex-direction: column;
            align-items: center;
        }
    }

    @media (max-width: 576px) {
        .tab-button {
            padding: 8px 15px;
            font-size: 12px;
            margin-right: 5px;
            width: 100%;
        }

        .tabs {
            flex-direction: column;
            align-items: stretch;
        }
    }

    .btn-success {
    background-color: #4584e8;
    color: #fff;
    transition: background-color 0.3s ease, opacity 0.3s ease, transform 0.3s ease;
    border: none;
    padding: 5px 50px;
    }

    .btn-success:hover {
        background-color: #4584e8;
        opacity: 0.8;
        transform: scale(1.05);
        box-shadow: 0px 4px 15px rgba(69, 132, 232, 0.4);
    }
    .banner {
            width: 100%;
            height: 400px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
        }

        .banner img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }
        @media (max-width: 768px) {
        .banner {
            height: auto;

        }
    }
    </style>
@endpush

@section('content-page')

    @include('pages.components.button-register', ['buttonTitle' => 'Đăng ký nhu cầu', 'buttonLink' => route('show.form',$blog->id)])
    <section id="blog-detail">
        <div class="banner">
            <img src="{{asset('images/Vayvonkinhdoanh.jpg')}}" alt="Banner Image">
        </div>
        <div class="container my-4">
            @if($blog->tabContentDetails->isNotEmpty())
                <div class="row">
                    <div class="col-md-12">
                        <div class="tabs-container">
                            <div class="tabs">
                                @foreach($blog->tabContentDetails as $key => $tabContent)
                                    <button class="tab-button {{ $key == 0 ? 'active' : '' }}" data-target="tab-{{ $key }}">
                                        {!! $tabContent->tab->name !!}
                                    </button>
                                @endforeach
                            </div>
                            <div class="tabs-content">
                                @foreach($blog->tabContentDetails as $key => $tabContent)
                                    <div class="tab-content {{ $key == 0 ? 'active' : '' }}" id="tab-{{ $key }}">
                                        <p>{!! $tabContent->content !!}</p> 
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="btn-regis text-center">
                            <a href="{{route('show.form', ['financialSupportId' => $blog->id])}}" class="btn btn-success" role="button">
                                <span>{{ __('Đăng ký ngay') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('child-scripts')
    <script>
       document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', () => {
            const tabContainer = button.closest('.tabs-container');

            tabContainer.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
            tabContainer.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

            button.classList.add('active');
            tabContainer.querySelector(`#${button.dataset.target}`).classList.add('active');
        });
    });


</script>
@endpush
