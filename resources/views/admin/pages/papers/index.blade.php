@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        /* Add any additional styles here */
    </style>
@endpush

@section('content-auth')

<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">{{__('all_testimonials')}}</h5>
                    </div>
                    <a href="{{ route('papers.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button">
                        <i class="fa-solid fa-plus"></i> {{__('add_testimonial')}}
                    </a>
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
                                    {{__('name')}}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    {{__('short_description')}}
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{__('avatar')}}
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{__('link')}}
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{__('action')}}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($papers as $key => $paper)
                            <tr>
                                <td class="ps-4">
                                    <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $paper->name }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $paper->short_description }}</p>
                                </td>
                                <td class="text-center">
                                    <div>
                                        <img src="{{ asset($paper->avatar) }}" width="100px" height="auto" alt="avatar">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $paper->link }}</p>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('papers.edit', $paper->id) }}" class="mx-3" title="{{ __('edit') }}">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    @include('admin.pages.components.delete-form', ['id' => $paper->id, 'route' => route('papers.destroy', $paper->id),'message' => __('delete_message')])
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
    // // JavaScript for handling alert fade out (if needed)
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
