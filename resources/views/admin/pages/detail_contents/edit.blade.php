@extends('admin.layouts.app')

@push('styles-admin')
<!-- Thêm các style tùy chỉnh nếu cần -->
@endpush

@section('content-auth')
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 px-3">
                <h5 class="mb-0">{{ __('edit_detail_content') }}</h5>
            </div>
            <div class="card-body pt-4 p-3">

                @include('admin.pages.notification.success-error')

                <form action="{{ route('detail_contents.update', $detailContent->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <input type="hidden" name="program_id" value="{{$program_id}}">
                        @foreach ($languages as $language)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{ 'title-'.$language->locale }}">{{ __('title') }}: {{ $language->name }}</label>
                                <input type="text" name="{{ 'title-'.$language->locale }}" id="{{ 'title-'.$language->locale }}" class="form-control"
                                    value="{{ old('title-'.$language->locale,$detailContent->getTranslation('title', app()->getLocale()))}}" required>
                                @error('title-'.$language->locale)
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{ 'content-'.$language->locale }}">{{ __('content') }} : {{ $language->name }}</label>
                                <textarea name="{{ 'content-'.$language->locale }}" id="{{ 'content-'.$language->locale }}" class="form-control" rows="5"
                                    required>{{ old('content-'.$language->locale,$detailContent->getTranslation('content', app()->getLocale())) }}</textarea>
                                @error('content-'.$language->locale)
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endforeach 

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="img_detail">{{ __('img_detail') }}</label>
                                <input type="file" name="img_detail" id="img_detail" class="form-control">
                                @if ($detailContent->img_detail)
                                    <img src="{{ asset($detailContent->img_detail) }}" alt="Image" class="img-thumbnail mt-2" width="150">
                                @endif
                                @error('img_detail')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        @foreach ($languages as $language)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{ 'tag-'.$language->locale}}">{{ __('tag') }} : {{$language->name}}</label>
                                <input type="text" name="{{ 'tag-'.$language->locale}}" id="{{ 'tag-'.$language->locale}}" class="form-control"
                                    value="{{ old('tag-'.$language->locale,$detailContent->getTranslation('tag', app()->getLocale())) }} ">
                                @error('tag-'.$language->locale)
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endforeach

                        <div class="form-group mb-3">
                            <label for="key_components">{{ __('key_components') }}</label>
                            <select name="key_components" id="key_components" class="form-control">
                                <option value="" disabled selected>{{ __('key_components') }}</option>
                                @foreach ($compo as $cp => $value)
                                <option value="{{ $cp }}" {{ old('key_components', $detailContent->key_components) == $cp ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                                @endforeach
                            </select>
                            @error('key_components')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn bg-gradient-primary">{{ __('save') }}</button>
                            <a href="{{ route('detail_contents.index', ['program_id' => $detailContent->program_id]) }}" class="btn btn-secondary">{{ __('cancel') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts-admin')

@endpush
