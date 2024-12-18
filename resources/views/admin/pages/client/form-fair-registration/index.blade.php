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
                            <h5 class="mb-0">{{ __('Danh sách hội chợ') }}</h5>
                        </div>
                        <a href="{{ route('fair-registrations.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2"
                            type="button"><i class="fa-solid fa-plus"></i> {{ __('Tạo hội chợ') }}</a>
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
                                    {{-- <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('content') }}
                                    </th> --}}
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('image') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('Ngày bắt đầu') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('Ngày kết thúc') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($blogs as $key => $post)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $post->title }}</p>
                                        </td>
                                        {{-- <td>
                                            <p class="text-xs font-weight-bold mb-0">{!! $post->content !!}</p>
                                        </td> --}}
                                        <td>
                                            @if (!empty($post->image))
                                                <div>
                                                    <img src="{{ asset($post->image) }}" class="img-fluid img-square"
                                                        alt="Image">
                                                </div>
                                            @else
                                                <p class="text-xs font-weight-bold mb-0">{{ __('no_image') }}</p>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $post->published_at }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $post->expired_at }}</p>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('fair-registrations.edit', $post->id) }}" class="mx-3"
                                                title="{{ __('edit') }}">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $post->id,
                                                'route' => route('fair-registrations.destroy', $post->id),
                                                'message' => __('delete_message'),
                                            ])

                                            <div class="form-check form-switch d-flex justify-content-center p-0">
                                                <input class="form-check-input digital-transformation-switch"
                                                    type="checkbox" role="switch" id="flexSwitchCheckDefault"
                                                    data-news-id="{{ $post->id }}"
                                                    @if(in_array($post->id, $newsDigitalTransformations)) checked @endif>
                                                <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                                            </div>
                                        </td>
                                    </tr>
                                @empty 
                                  
                                @endforelse
                            </tbody>
                        </table>
                        @if($blogs->hasPages())
                            <x-pagination :paginator="$blogs" />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('admin.pages.components.toggleDigitalTransformation')

@push('scripts-admin')
    
@endpush
