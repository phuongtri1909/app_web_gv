
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
                        <h5 class="mb-0">{{__('all_about_us')}}</h5>
                    </div>
                    <a href="{{ route('aboutUs.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button">
                        <i class="fa-solid fa-plus"></i> {{__('add_about_us')}}
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
                                    {{__('title_about')}}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    {{__('subtitle_about')}}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    {{__('title_detail')}}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    {{__('subtitle_detail')}}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    {{__('description')}}
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{__('image')}}
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{__('link_url')}}
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{__('action')}}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aboutUs as $key => $aboutU)
                            <tr>
                                <td class="ps-4">
                                    <p class="text-xs font-weight-bold mb-0">{{ $key + 1}}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $aboutU->title_about }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $aboutU->subtitle_about }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $aboutU->title_detail }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $aboutU->subtitle_detail }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $aboutU->description }}</p>
                                </td>
                                <td>
                                    <div>
                                        <img src="{{ asset($aboutU->image) }}" width="100px" height="auto" alt="image" class="me-3">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $aboutU->link_url }}</p>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('aboutUs.edit', $aboutU->id) }}" class="mx-3" title="{{ __('edit') }}">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    @include('admin.pages.components.delete-form', ['id' => $aboutU->id, 'route' => route('aboutUs.destroy', $aboutU->id),'message' => __('delete_message')])
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
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        var successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(function() {
                var bsAlert = new bootstrap.Alert(successAlert);
                bsAlert.close();
            }, 3000);
        }

        var errorAlert = document.getElementById('error-alert');
        if (errorAlert) {
            setTimeout(function() {
                var bsAlert = new bootstrap.Alert(errorAlert);
                bsAlert.close();
            }, 3000);
        }
    });
    </script> --}}
@endpush
