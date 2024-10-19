@extends('admin.layouts.app')

@push('styles-admin')
    <!-- Thêm các style tùy chỉnh nếu cần -->
@endpush

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ __('edit_program') }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body  pt-4 p-3">
                    @include('admin.pages.notification.success-error')

                    <form action="{{ route('programs.update', $programs->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="category_id">{{ __('category_name') }}</label>
                                    <select id="category_id" name="category_id" class="form-control">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $programs->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name_category }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @foreach ($languages as $language)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="{{ 'title-' . $language->locale }}">{{ __('title') }} :
                                            {{ $language->name }}</label>
                                        <input type="text" id="title_program"
                                            name="{{ 'title_program-' . $language->locale }}" class="form-control"
                                            value="{{ old('title_program-' . $language->locale, $programs->getTranslation('title_program', app()->getLocale())) }}">
                                        @error('title_program-' . $language->locale)
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            for="{{ 'short_description-' . $language->locale }}">{{ __('short_description') }}
                                            : {{ $language->name }}</label>
                                        <textarea id="{{ 'short_description-' . $language->locale }}" name="{{ 'short_description-' . $language->locale }}"
                                            class="form-control">{{ old('short_description-' . $language->locale, $programs->getTranslation('short_description', app()->getLocale())) }}</textarea>
                                        @error('short_description-' . $language->locale)
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label
                                            for="{{ 'long_description-' . $language->locale }}">{{ __('long_description') }}
                                            :
                                            {{ $language->name }}</label>
                                        <textarea id="{{ 'long_description-' . $language->locale }}" name="{{ 'long_description-' . $language->locale }}"
                                            class="form-control">{{ old('long_description-' . $language->locale, $programs->getTranslation('long_description', app()->getLocale())) }}</textarea>
                                        @error('long_description-' . $language->locale)
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="img_program">{{ __('upload_img_798x799') }}</label>
                                    <input type="file" name="img_program" class="form-control" id="img_program"
                                        accept="image/*">
                                    @error('img_program')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                    @if ($programs->img_program)
                                        <div class="mt-2">
                                            <img src="{{ asset($programs->img_program) }}" alt="Current Image"
                                                class="img-fluid" style="max-width: 200px;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rank">{{ __('rank') }}</label>
                                    <input type="number" id="rank" name="rank" class="form-control"
                                        value="{{ old('rank',$programs->rank) }}">
                                    @error('rank')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn bg-gradient-primary">{{ __('save_changes') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    <!-- Thêm các script tùy chỉnh nếu cần -->
@endpush
