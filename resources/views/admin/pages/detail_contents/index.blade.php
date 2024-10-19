@extends('admin.layouts.app')

@push('styles-admin')
<!-- Thêm các style tùy chỉnh nếu cần -->
@endpush

@section('content-auth')
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">{{ __('detail_content_list') }}</h5>
                    </div>
                    <a href="{{ route('detail_content.create',['program_id' => $program_id] )}}" class="btn bg-gradient-primary btn-sm mb-0 px-2"
                        type="button">
                        <i class="fa-solid fa-plus"></i> {{ __('add_detail_content') }}
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
                                    {{ __('id') }}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    {{ __('program_id') }}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('title') }}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('content') }}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('img') }}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('tag') }}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('key_components') }}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('action') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detailContents as $detailContent)
                            <tr>
                                <td class="ps-4">
                                    <p class="text-xs font-weight-bold mb-0">{{ $detailContent->id }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $detailContent->program_id }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $detailContent->title }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ Str::limit($detailContent->content, 50) }}</p>
                                </td>
                                <td class="text-center">
                                    @if ($detailContent->img_detail)
                                    <img src="{{ asset($detailContent->img_detail) }}" alt="{{ $detailContent->title }}"
                                        style="max-width: 100px;">
                                    @else
                                    <p>{{ __('No image available') }}</p>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $detailContent->tag }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $detailContent->key_components }}</p>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('details_content.edit', $detailContent->id) }}" class="mx-3"
                                        title="{{ __('edit') }}">
                                        <i class="fa-solid fa-pencil"></i>
                                     </a>                                     
                                   
                                    @include('admin.pages.components.delete-form', ['id' =>  $detailContent->id, 'route' => route('detail_contents.destroy', $detailContent->id)])
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
<!-- Thêm các script tùy chỉnh nếu cần -->
@endpush
