@extends('admin.layouts.app')

@push('styles-admin')
@endpush
@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ __('all_languages') }}</h5>
                        </div>
                        <a href="{{ route('languages.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button"><i class="fa-solid fa-plus"></i> {{ __('new_language') }}</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">

                    @include('admin.pages.notification.success-error')

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('id') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('flag') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('locale') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('name') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('date') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($languages as $language)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $language->id }}</p>
                                    </td>
                                    <td>
                                        <div>
                                            <img src="{{ asset($language->flag) }}" class="avatar avatar-sm me-3">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $language->locale }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $language->name }}</p>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{__('create').' : '. $language->created_at }}</span>
                                        <br>
                                        <span class="text-secondary text-xs font-weight-bold">{{__('update').' : '. $language->updated_at }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('languages.edit',$language->id) }}" class="mx-3"" title="{{ __('edit') }}">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <a href="{{ route('languages.edit-system', ['locale' => $language->locale]) }}" class="mx-3" title="{{ __('edit_language_system') }}">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        @include('admin.pages.components.delete-form', ['id' => $language->id, 'route' => route('languages.destroy', $language->id),'message' => __('confirm_delete_language')])
                                        
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
