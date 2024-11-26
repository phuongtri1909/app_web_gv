@extends('layouts.app')
@section('title', 'Kiểm tra doanh nghiệp')
@section('description', 'Kiểm tra doanh nghiệp')
@section('keyword', 'Kiểm tra doanh nghiệp')

@section('content')
    <div class="container">
        <form action="{{ route('form.check.business') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="business_code">Mã doanh nghiệp</label>
                <input placeholder="Mã doanh nghiệp" type="text" name="business_code" id="business_code" class="form-control form-control-sm" required>
                @if ($errors->has('business_code'))
                    <span class="text-danger">{{ $errors->first('business_code') }}</span>
                @endif
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary m-2">Kiểm tra</button>
            </div>
        </form>
    </div>
@endsection