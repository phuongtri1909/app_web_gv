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
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ __('all_tab_programs') }}</h5>
                        </div>
                        <a href="{{ route('create.tab','programs') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button"><i class="fa-solid fa-plus"></i> {{ __('new_tab_program') }}</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">

                    @include('admin.pages.notification.success-error')

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('stt') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('title') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('banner') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tabs_programs as $index =>$tab)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $tab->title }}</p>
                                    </td>
                                    <td>
                                        <div>
                                            <img src="{{ asset($tab->banner) }}" class="img-fluid img-square">
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('edit.tab', $tab->slug) }}" class="mx-3" title="{{ __('edit_tab') }}">
                                            <i class="fa-regular fa-pen-to-square"></i> 
                                       </a>
                                        @if ($tab->slug != 'phuong-phap-giao-duc' && $tab->slug != 'phat-trien-cac-du-an-mini')
                                            @include('admin.pages.components.delete-form', ['id' => $tab->id, 'route' => route('destroy.tab', $tab->id),'message' => __('confirm_delete_tab_program')])
                                            <a href="{{ route('content_tab_custom', $tab->slug) }}" class="mx-3" title="{{ __('view_tab') }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>   
                                        @else
                                            <a href="{{ route('tabs-programs.show', $tab->id) }}" class="mx-3" title="{{ __('view_tab') }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        @endif
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
