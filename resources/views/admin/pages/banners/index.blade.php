@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        /* .alert.fade {
            opacity: 0;
            transition: opacity 0.5s ease-out;
        }
        .alert.show {
            opacity: 1;
        } */

    </style>
@endpush
@section('content-auth')
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">{{__('all_banners')}}</h5>
                    </div>
                    <a href="{{ route('banners.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button"><i class="fa-solid fa-plus"></i> {{__('add_banner')}}</a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">

                @include('admin.pages.notification.success-error')

                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{__('stt')}}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    {{__('thumbnail')}}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{__('key_page_1')}}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{__('active')}}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{__('action')}}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banners as $key => $banner)
                            <tr>
                                <td class="ps-4">
                                    <p class="text-xs font-weight-bold mb-0">{{ $key + 1}}</p>
                                </td>
                                <td>
                                    <div>
                                        <img src="{{ asset($banner->thumbnail) }}" width="100px" height="auto" alt="Thumbnail" class="me-3">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $banner->key_page }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ __($banner->active) }}</p>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('banners.edit', $banner->id) }}" class="mx-3"" title="{{ __('edit') }}">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    @include('admin.pages.components.delete-form', ['id' => $banner->id, 'route' => route('banners.destroy', $banner->id),'message' => __('delete_message')])
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
<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     var successAlert = document.getElementById('success-alert');
    //     if (successAlert) {
    //         setTimeout(function() {
    //             var bsAlert = new bootstrap.Alert(successAlert);
    //             bsAlert.close();
    //         }, 3000);
    //     }

    //     var errorAlert = document.getElementById('error-alert');
    //     if (errorAlert) {
    //         setTimeout(function() {
    //             var bsAlert = new bootstrap.Alert(errorAlert);
    //             bsAlert.close();
    //         }, 3000);
    //     }
    // });
    </script>
@endpush
