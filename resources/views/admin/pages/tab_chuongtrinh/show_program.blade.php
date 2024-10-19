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
                            <h5 class="mb-0">{{ __('all_content_pedagody') }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4 p-3">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Component
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($tab_image_content))
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">Component 1</p>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('tabs-programs.component1', [$tab->id]) }}" class="mx-3" title="{{ __('view_tab') }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="2" class="text-center text-xs font-weight-bold">{{ __('no_image_content_found') }}</td>
                                    </tr>
                                @endif

                                @if (isset($tab_drops))
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">Component 2</p>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('tabs-programs.component2', [$tab->id]) }}" class="mx-3" title="{{ __('view_tab') }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="2" class="text-center text-xs font-weight-bold">{{ __('no_drop_content_found') }}</td>
                                    </tr>
                                @endif
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
