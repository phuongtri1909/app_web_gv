@extends('admin.layouts.app')

@push('styles-admin')
<!-- Thêm các style tùy chỉnh nếu cần -->
@endpush

@section('content-auth')
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0 px-3">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">{{ __('all_categories') }}</h5>
                    </div>
                    <a href="{{ route('edit.tab', $tab->slug) }}" class="mx-3" title="{{ __('edit_tab') }}">
                        <i class="fa-regular fa-pen-to-square"></i> Tab
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
                                    {{ __('id') }}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    {{ __('key_page_1') }}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('category_name') }}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('description') }}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('action') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                            <tr>
                                <td class="ps-4">
                                    <p class="text-xs font-weight-bold mb-0">{{ $category->id }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">
                                        @if ($category->key_page === 'page_home')
                                        Trang chủ
                                        @elseif ($category->key_page === 'page_program')
                                        Tổng quan chương trình
                                        @elseif ($category->key_page === 'key_cb2')
                                        Components 2
                                        @else
                                        {{ $category->key_page }}
                                        @endif
                                    </p>
                                </td>

                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $category->name_category }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $category->desc_category }}</p>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('categories.edit', $category->id) }}" class="mx-3"
                                        title="{{ __('edit') }}">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <a href="{{ route('overviewprograms.index', $category->id) }}" class="mx-3" title="{{ __('view_programs') }}">
                                        <i class="fa-solid fa-eye"></i>
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