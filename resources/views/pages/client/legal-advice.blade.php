@extends('layouts.app')
@section('title', 'Tư vấn pháp luật')
@section('description', 'Tư vấn pháp luật')
@section('keyword', 'Tư vấn pháp luật')
@push('styles')
    <style>
        .custom-img {
            width: 150px;
            height: 100px;
            object-fit: scale-down
        }
    </style>
@endpush

@push('scripts')
@endpush

@section('content')
    @include('pages.components.button-register', [
        'buttonTitle' => 'ĐKTV Pháp luật',
        'buttonLink' => route('show.form.legal'),
    ])

    <div class="mt-5rem container-fluid ">
        @if (!empty($contactConsultation))
            <div class="row gx-3 text-center">
                @foreach ($contactConsultation as $item)
                    <div class="col-md-3 col-6 title-f mb-4 ">
                        <a target="_blank" href="{{ $item->link }}" class="border rounded p-1 h-100" style="display: block">
                            <div class="icon-box">
                                <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="img-fluids custom-img">
                            </div>
                            <div class="mt-2">{{ $item->name }}</div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
