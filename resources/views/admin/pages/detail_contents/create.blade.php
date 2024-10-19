@extends('admin.layouts.app')

@push('styles-admin')
<!-- Thêm các style tùy chỉnh nếu cần -->
@endpush

@section('content-auth')
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 px-3">
                <h5 class="mb-0">{{ __('create_detail_content') }}</h5>
            </div>
            <div class="card-body pt-4 p-3">

                @include('admin.pages.notification.success-error')

                <form action="{{ route('detail_contents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="program_id" value="{{$program_id}}">
                        @foreach ($languages as $language)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{ 'title-'.$language->locale }}">{{ __('title') }}: {{ $language->name }}</label>
                                <input type="text" name="{{ 'title-'.$language->locale }}" id="{{ 'title-'.$language->locale }}" class="form-control"
                                    value="{{ old('title-'.$language->locale ) }}" required>
                                @error('title-'.$language->locale)
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{ 'content-'.$language->locale }}">{{ __('content') }} : {{ $language->name }}</label>
                                <textarea name="{{ 'content-'.$language->locale }}" id="{{ 'content-'.$language->locale }}" class="form-control" rows="5"
                                    required>{{ old('content-'.$language->locale) }}</textarea>
                                @error('content-'.$language->locale)
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endforeach
                        <div class="form-group">
                            <label for="img_detail">{{ __('upload_img_798x799') }}</label>
                            <input type="file" name="img_detail" class="form-control" id="img_detail" accept="image/*"
                                required>
                            @error('img_detail')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        @foreach ($languages as $language)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="{{ 'tag-'.$language->locale}}">{{ __('tag') }} : {{$language->name}}</label>
                                <input type="text" name="{{ 'tag-'.$language->locale}}" id="{{ 'tag-'.$language->locale}}" class="form-control"
                                    value="{{ old('tag-'.$language->locale) }}">
                                @error('tag-'.$language->locale)
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>  
                        @endforeach
                        <div class="form-group mb-3">
                            <label for="key_components">{{ __('key_components') }}</label>
                            <select name="key_components" id="key_components"
                                class="form-control" >
                                <option value="" disabled selected>{{ __('key_components') }}</option>
                                @foreach ($compo as $cp => $value)
                                <option value="{{ $cp }}" {{ old('key_components') == $cp ? 'selected' : '' }}>
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
                            <a href="{{ route('detail_contents.index',['program_id' => $program_id]) }}" class="btn btn-secondary">{{ __('cancel') }}</a>
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
