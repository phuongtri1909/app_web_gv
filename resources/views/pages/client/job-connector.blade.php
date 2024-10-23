@extends('pages.layouts.page')
@section('title', 'Kết nối việc làm')
@section('description', 'Kết nối việc làm')
@section('keyword', 'Kết nối việc làm')
@push('styles')
   
@endpush

@push('scripts')
    
@endpush

@section('content')
    @include('pages.components.button-register', ['buttonPosition'=>'left:15px','buttonTitle' => 'Tuyển dụng', 'buttonLink' => route('recruitment.registration')])
    @include('pages.components.button-register', ['buttonTitle' => 'Tìm Việc ngay', 'buttonLink' => route('job.application')])
    
@endsection