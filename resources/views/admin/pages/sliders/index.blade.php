
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
                        <h5 class="mb-0">{{__('all_slider')}}</h5>
                    </div>
                    <a href="{{ route('sliders.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button"><i class="fa-solid fa-plus"></i> {{__('add_slider')}}</a>
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
                                    {{__('slider_title')}}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    {{__('title')}}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    {{__('subtitle')}}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    {{__('description')}}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{__('slider_image')}}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{__('learn_more_url')}}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{__('active')}}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{__('key_page_1')}}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{__('action')}}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sliders as $key => $slider)
                            <tr>
                                <td class="ps-4">
                                    <p class="text-xs font-weight-bold mb-0">{{ $key + 1}}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $slider->slider_title }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $slider->title }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $slider->subtitle }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $slider->description  }}</p>
                                </td>
                                <td>
                                    <div>
                                        <img src="{{ asset($slider->image_slider ) }}" width="100px" height="auto" alt="slider" class="me-3">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $slider->learn_more_url }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ __($slider->active) }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $slider->key_page }}</p>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('sliders.edit', $slider->id) }}" class="mx-3"" title="{{ __('edit') }}">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    @include('admin.pages.components.delete-form', ['id' => $slider->id, 'route' => route('sliders.destroy', $slider->id),'message' => __('delete_message')])
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
