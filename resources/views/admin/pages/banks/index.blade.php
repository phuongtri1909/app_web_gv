@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        .img-square {
            width: auto;
            height: 100px;
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
                        <h5 class="mb-0">{{ __('Danh sách ngân hàng') }}</h5>
                    </div>
                    <a href="{{ route('banks.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2"
                        type="button"><i class="fa-solid fa-plus"></i> {{ __('Thêm mới') }}</a>
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
                                    {{ __('Tên ngân hàng') }}
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    {{ __('Ảnh') }}
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    {{ __('action') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banks as $key => $post)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $post->name }}</p>
                                    </td>
                                    <td>
                                        @if (!empty($post->avt_bank))
                                            <div>
                                                <img src="{{ asset($post->avt_bank) }}" class="img-fluid img-square"
                                                    alt="Image">
                                            </div>
                                        @else
                                            <p class="text-xs font-weight-bold mb-0">{{ __('no_image') }}</p>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('banks.edit', $post->id) }}" class="mx-3"
                                            title="{{ __('edit') }}">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        @include('admin.pages.components.delete-form', [
                                            'id' => $post->id,
                                            'route' => route('banks.destroy', $post->id),
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
