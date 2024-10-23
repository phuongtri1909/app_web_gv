@extends('pages.layouts.page')
@section('title', 'Tư vấn pháp luật')
@section('description', 'Tư vấn pháp luật')
@section('keyword', 'Tư vấn pháp luật')
@push('styles')
   
@endpush

@push('scripts')
    
@endpush

@section('content')
    @include('pages.components.button-register', [
        'buttonTitle' => 'ĐkTV Pháp luật',
        'buttonLink' => route('show.form.legal')
    ])
@endsection