@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        .img-square {
            width: 300px;
            height: 200px;
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
                            <h5 class="mb-0">{{ __('all_personnel') }}</h5>
                        </div>
                        <a href="{{ route('staffs.create',$campus->id) }}" class="btn bg-gradient-primary btn-sm mb-0 px-2"
                            type="button"><i class="fa-solid fa-plus"></i> {{ __('new_personnel') }}</a>
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
                                        {{ __('full_name') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('position') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('descripton') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('image') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($personnel as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->full_name }}</td>
                                        <td>{{ $item->position }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td class="text-center">
                                            <img src="{{ asset($item->image) }}" alt="{{ $item->name }}"
                                                class="img-square">
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('staffs.edit', $item->id) }}" class="mx-3"
                                                title="{{ __('edit campus') }}">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $item->id,
                                                'route' => route('staffs.destroy', $item->id),
                                                'message' => __('confirm_delete_personnel'),
                                            ])
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
