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
                            <h5 class="mb-0">{{ __('data_component_3') }}</h5>
                        </div>
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('title') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('content') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('image') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tabs_img_content as $item)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->id }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->title }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->content }}</p>
                                        </td>

                                        <td>
                                            <img src="{{ asset($item->image) }}" alt="{{ $item->title }}"
                                                class="img-fluid">
                                        </td>
                                        <td>
                                            <a href="{{ route('tab.aboutUs.edit', $item->id) }}" class="mx-3" title="{{ __('edit') }}">
                                                <i class="fa-solid fa-pencil"></i>
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
