@extends('pages.layouts.page')
@section('title', 'Chỉ dẫn điểm đến')
@section('description', 'Chỉ dẫn điểm đến')
@section('keyword', 'Chỉ dẫn điểm đến')
@push('styles')
   
@endpush

@push('scripts')
    
@endpush

@section('content')
    @include('pages.components.button-register', [
        'buttonTitle' => 'ĐK Điểm đến',
        'buttonLink' => route('show.form.promotional')
    ])
    
@endsection