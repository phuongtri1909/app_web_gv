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
                            <h5 class="mb-0">{{ __('list_all_component') }}</h5>
                        </div>
                        <a href="{{ route('edit.tab', 'school-board-message') }}" class="mx-3" title="{{ __('edit_tab') }}">
                            <i class="fa-solid fa-pencil"></i> Tab
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
                                        {{ __('name_component') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        {{ __('school-board-message') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('tab.aboutUs.edit', $tab->imgContents->first()->id) }}" class="mx-3" title="{{ __('edit') }}">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        Component collapse
                                    </td>
                                    <td>
                                        <a href="{{ route('all.data.component.collapse', $tab->slug) }}" class="mx-3" title="{{ __('view_data_component') }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </a> 
                                    </td>
                                </tr>
                                
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
