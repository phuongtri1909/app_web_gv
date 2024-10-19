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
                        @if ($category->key_page == 'page_program')
                            <h5 class="mb-0">{{ __('all_programms') }}</h5>
                        @elseif ($category->key_page == 'page_home')
                            <h5 class="mb-0">{{ __('all_program_home') }}</h5>
                        @elseif ($category->key_page == 'key_cb2')
                            <h5 class="mb-0">{{ __('all_program_cp2') }}</h5>
                        @endif
                       
                    </div>
                    <a href="{{ route('programs.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2"
                        type="button">
                        <i class="fa-solid fa-plus"></i> {{ __('add_program') }}
                    </a>
                </div>
            </div>
            <div class="card-body  pt-4 p-3">

                @include('admin.pages.notification.success-error')

                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('id') }}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    {{ __('category_name') }}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('title') }}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('short_description') }}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('long_description') }}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('images') }}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('action') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($programs as $program)
                            <tr>
                                <td class="ps-4">
                                    <p class="text-xs font-weight-bold mb-0">{{ $program->id }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">
                                        {{ $program->category->name_category ?? 'N/A' }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $program->title_program }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $program->short_description }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $program->long_description }}</p>
                                </td>
                                <td class="text-center">
                                    @if ($program->img_program)
                                    <img src="{{ asset($program->img_program) }}" alt="{{ $program->title_program }}"
                                        style="max-width: 100px;">
                                    @else
                                    <p>{{ __('No image available') }}</p>
                                    @endif
                                </td>

                                </td>
                                <td class="text-center">
                                    <div>
                                        <a href="{{ route('programs.edit', $program->id) }}" class="mx-3"
                                            title="{{ __('edit') }}">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        @include('admin.pages.components.delete-form', ['id' => $program->id, 'route' => route('programs.destroy', $program->id)])
                                    </div>
                                    <div>
                                        <a href="{{ route('detail_contents.index', ['program_id' => $program->id]) }}" class="mx-3" title="{{ __('view_details') }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('slider_programms.index', ['program_id' => $program->id]) }}" class="mx-3" title="{{ __('component slide') }}">
                                            <i class="fa-solid fa-list"></i>
                                        </a>   
                                    </div>
                                                                                                                                                                            
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