@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        .img-square {
            width: 200px;
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
                            <h5 class="mb-0">{{ __('all_content_project') }}</h5>
                        </div>
                        <a href="{{ route('tabs-programs.component3pp.create', $tab->id) }}"
                            class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button"><i class="fa-solid fa-plus"></i>
                            {{ __('new_tab_project') }}</a>
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
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('content') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('date') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('image') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('type') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tab_projects as $index => $tab)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $tab->project_name }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $tab->date }}</p>
                                        </td>
                                        <td>
                                            @if (!empty($tab->image))
                                                <div>
                                                    <img src="{{ asset($tab->image) }}" class="img-fluid img-square"
                                                        alt="Image">
                                                </div>
                                            @else
                                                <p class="text-xs font-weight-bold mb-0">{{ __('no_image') }}</p>
                                            @endif

                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $tab->type }}</p>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('tabs-programs.component3pp.show.detail', [$tab->id]) }}" class="mx-3"
                                                title="{{ __('view_tab') }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $tab->id,
                                                'route' => route('tabs-programs.component3pp.destroy', [
                                                    $tab->tab_id,
                                                    $tab->id,
                                                ]),
                                                'message' => __('delete_message'),
                                            ])
                                            <a href="{{ route('tabs-programs.component3pp.edit', $tab->id) }}"
                                                class="mx-3"" title="{{ __('edit') }}">
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
