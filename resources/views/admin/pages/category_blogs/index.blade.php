@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        .img-square{
            width: 200px;
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
                            <h5 class="mb-0">{{ __('all_category') }}</h5>
                        </div>
                        <a href="{{ route('categories-news.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2"
                            type="button"><i class="fa-solid fa-plus"></i> {{ __('categories_add') }}</a>
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
                                        {{ __('name_category') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $key => $post)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $post->name }}</p>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('categories-news.edit', $post->id) }}" class="mx-3"
                                                title="{{ __('edit') }}">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $post->id,
                                                'route' => route('categories-news.destroy', $post->id),
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
    <script>
        // You can add custom scripts here
    </script>
@endpush
