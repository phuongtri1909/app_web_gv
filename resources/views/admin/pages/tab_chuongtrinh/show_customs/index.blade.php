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
                        @if (is_null($tabs_custom))
                            <a href="{{ route('tabs-customs.create',  $tab->id) }}"
                                class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button">
                                <i class="fa-solid fa-plus"></i> {{ __('new_tab_program') }}
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">

                    @include('admin.pages.notification.success-error')

                    @if (is_null($tabs_custom))
                        <p class="text-center text-xs font-weight-bold mb-0">{{ __('no_content_found') }}</p>
                    @else
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            {{ __('title') }}
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            {{ __('description') }}
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
                                    <tr>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $tabs_custom->title }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $tabs_custom->description }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{!! $tabs_custom->content !!}</p>
                                        </td>
                                        <td class="text-center">
                                            @if ($tab->slug != 'phuong-phap-giao-duc' && $tab->slug != 'phat-trien-cac-du-an-mini')
                                                <a href="{{ route('tabs-customs.edit', $tabs_custom->id) }}" class="mx-3"
                                                    title="{{ __('edit') }}">
                                                    <i class="fa-solid fa-pencil"></i>
                                                </a>

                                                @include('admin.pages.components.delete-form', [
                                                    'id' => $tabs_custom->id,
                                                    'route' => route('tabs-customs.destroy', $tabs_custom->id),
                                                    'message' => __('confirm_delete_tab_program'),
                                                ])
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
@endpush
