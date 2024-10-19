@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        .img-square {
            width: 150px;
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
                            <h5 class="mb-0">{{ __('all_parent_content') }}</h5>
                        </div>
                        <a href="{{ route('content_tab_parent.create', $tab->id) }}"
                            class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button">
                            <i class="fa-solid fa-plus"></i> {{ __('new_content') }}
                        </a>
                    </div>
                </div>
                <div class="card-body pt-4 p-3">

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
                                        {{ __('content') }}
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
                                @foreach ($tab_image_content as $index => $item)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->title }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->content }}</p>
                                        </td>
                                        <td>
                                            <div>
                                                <img src="{{ asset($item->image) }}" class="img-fluid img-square">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('content_tab_parent.edit',$item->id) }}" class="mx-3"" title="{{ __('edit') }}">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>

                                            @include('admin.pages.components.delete-form', [
                                                'id' => $item->id,
                                                'route' => route('tabs-parents.destroy', $item->id),
                                                'message' => __('delete_message'),
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
