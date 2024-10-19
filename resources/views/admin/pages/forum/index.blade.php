@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        /* Add any specific styles for forum here */
    </style>
@endpush

@section('content-auth')
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mx-4">
            <div class="card-header pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">{{__('all_forums')}}</h5>
                    </div>
                    <a href="{{ route('forums.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button"><i class="fa-solid fa-plus"></i> {{__('add_forum')}}</a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">

                @include('admin.pages.notification.success-error')

                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{__('stt')}}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('title')}}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('image')}}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('key_page_1')}}</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{__('active')}}</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{__('action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($forums as $key => $forum)
                            <tr>
                                <td class="ps-4">
                                    <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{!! $forum->title !!}</p>
                                <td class="text-center">
                                    @if ($forum->key_page === 'key_forum_cp3')
                                        @php
                                            $images = json_decode($forum->image, true);
                                            $firstImage = is_array($images) && !empty($images) ? $images[0] : null;
                                        @endphp
                                        @if ($firstImage)
                                            <img src="{{ asset($firstImage) }}" width="100px" height="auto" alt="forum image" class="me-3">
                                        @endif
                                    @else
                                        <img src="{{ asset($forum->image) }}" width="100px" height="auto" alt="forum image" class="me-3">
                                    @endif
                                </td>

                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $forum->key_page }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ __($forum->active) }}</p>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('forums.edit', $forum->id) }}" class="mx-3" title="{{ __('edit') }}">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    @include('admin.pages.components.delete-form', ['id' => $forum->id, 'route' => route('forums.destroy', $forum->id),'message' => __('delete_message')])
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
    // Any specific JS related to forum management can go here
</script>
@endpush
