@extends('pages.client.p17.layouts.app')

@section('title', 'Kết nối tiểu thương')
@section('description', 'Kết nối tiểu thương')
@section('keyword', 'Kết nối tiểu thương')

@push('styles')
    <style>
        .section {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: #fff;
            padding: 10px;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
            transition: all 0.3s ease-in-out;
        }

        .section:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }

        .section img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            margin-bottom: 8px;
            border-radius: 5px;
        }

        .section h2 {
            font-size: 14px;
            color: #0066cc;
            margin: 0;
            line-height: 1.5;
        }


        .grid-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin: 0 auto;
            padding: 10px;
        }

        @media (min-width: 768px) {
            .grid-container {
                grid-template-columns: repeat(3, 1fr);
            }
        }
    </style>
@endpush

@section('content')
    <section id="connecting-small-business" class="mt-3 mb-5">
        <div class="container">
            <div class="grid-container">
                @forelse($categoryMarkets as $categoryMarket)
                    <a href="{{ route('p17.households.client.index', ['slug' => $categoryMarket->slug]) }}" class="section">
                        <div class="section-a">
                            <img src="{{ asset($categoryMarket->banner) }}" alt="{{ $categoryMarket->name }}" class="img-fluid"
                                loading="lazy">
                            <h2>{{ $categoryMarket->name }}</h2>
                        </div>
                    </a>
                @empty
                    <p class="text-center">Không có dữ liệu.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
