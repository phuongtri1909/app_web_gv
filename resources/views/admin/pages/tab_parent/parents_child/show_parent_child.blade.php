@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        .img-square {
            width: 150px;
            height: 100px;
            object-fit: cover;
        }

        .table-responsive .elips p {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
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
                            <h5 class="mb-0">{{ __('all_parent_content') }}</h5>
                        </div>
                        <a href="{{ route('parents-children.create', $tab->id) }}"
                            class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button"><i class="fa-solid fa-plus"></i>
                            {{ __('new_content') }}</a>
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
                                        {{ __('description') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('image') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('link') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('component') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($parentsChildren as $index => $parentsChild)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $parentsChild->title }}</p>
                                        </td>
                                        <td class="text-center elips">
                                            <p class="text-xs font-weight-bold mb-0">{!! Str::limit($parentsChild->description, 100) !!}</p>
                                        </td>
                                        <td>
                                            <div>
                                                @if ($parentsChild->image)
                                                    <img src="{{ asset($parentsChild->image) }}"
                                                        class="img-fluid img-square">
                                                @endif
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $parentsChild->link }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $parentsChild->component_type }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('parents-children.edit', $parentsChild->id) }}"
                                                class="mx-3" title="{{ __('edit') }}">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>

                                            @include('admin.pages.components.delete-form', [
                                                'id' => $parentsChild->id,
                                                'route' => route('parents-child.destroy', $parentsChild->id),
                                                'message' => __('delete_message'),
                                            ])

                                            @if ($tab->slug === 'cac-hoat-dong-va-su-kien-chung-toi' && $parentsChild->component_type === 'type_cp3')
                                                <a href="{{ route('ParentChildDetail.index.detail', $parentsChild->id) }}"
                                                    class="mx-3" title="{{ __('view_tab') }}">
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
