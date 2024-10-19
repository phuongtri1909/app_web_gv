@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        .img-square {
            width: 500px; 
            height: 100px; 
            object-fit: cover;
        }
    </style>
@endpush
@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ __('all_admission_process') }}</h5>
                        </div>
                        <a href="{{ route('admission-process.create',$tab->id) }}" class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button"><i class="fa-solid fa-plus"></i> {{ __('new_admission_process') }}</a>
                    </div>
                </div>
                <div class="card-body pt-4 p-3">

                    @include('admin.pages.notification.success-error')

                    <form action="{{ route('update-process',$tab_image_content->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            @foreach ($languages as $language)
                                <div class="form-group mb-3 col-md-6">
                                    <label for="{{ 'title_'.$language->locale }}">{{ __('title') }}:
                                        {{ $language->name }}</label>
                                    <input type="text" name="{{ 'title_'.$language->locale }}"
                                        id="{{ 'title_'.$language->locale }}"
                                        class="form-control @error('title_'.$language->locale) is-invalid @enderror"
                                        value="{{ old('title_'.$language->locale, $tab_image_content->getTranslation('title',$language->locale)) }}" required>
                                    @error('title_'.$language->locale)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3 col-md-6">
                                    <label for="content">{{ __('description') }} {{ $language->name }}</label>
                                    <textarea name="content_{{ $language->locale }}" id="content_{{ $language->locale }}"
                                        class="form-control @error('content_{{ $language->locale }}') is-invalid @enderror" rows="3"
                                        required>{{ old('content_'.$language->locale, $tab_image_content->getTranslation('content',$language->locale)) }}</textarea>
                                    @error('content_{{ $language->locale }}')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            @endforeach
                            
                        </div>
    
                        <div class="text-center">
                            <button type="submit" class="btn bg-gradient-primary">{{ __('save') }}</button>
                            <a href="{{ route('tabs-admissions.index') }}" class="btn btn-secondary">{{ __('cancel') }}</a>
                        </div>
                    </form>

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('id') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('title') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('content') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admissions_process as $item)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->id }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->title }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->content }}</p>
                                    </td>
                                    
                                    <td class="text-center">
                                            <a href="{{ route('admission-process.edit',$item->id) }}" class="mx-3"" title="{{ __('edit') }}">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                        
                                            @include('admin.pages.components.delete-form', ['id' => $item->id, 'route' => route('admission-process.destroy', $item->id),'message' => __('confirm_delete_process')])
                                            
                                            <a href="{{ route('admission-process.show', $item->id) }}" class="mx-3" title="{{ __('view_detail_process') }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>     
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts-admin')
@endpush
