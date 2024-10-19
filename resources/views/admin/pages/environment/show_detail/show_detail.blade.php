@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ __('detail_of') }} {{ $tabContent->title }}</h5>
                        </div>
                        <a href="{{ route('tabs-environment.section.create.detail', $tabContent->id) }}"
                            class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button">
                            <i class="fa-solid fa-plus"></i> {{ __('add_new_media') }}
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2 pt-3">
                    @include('admin.pages.notification.success-error')
                    <div class="row">
                        @foreach ($mediaItems as $mediaItem)
                            <div class="col-md-4 mb-3">
                                @if ($mediaItem->type == 'image')
                                    <img src="{{ asset($mediaItem->file_path) }}" class="img-fluid img-square"
                                        alt="Image">
                                @elseif ($mediaItem->type == 'video')
                                    <video controls class="img-fluid img-square">
                                        <source src="{{ asset($mediaItem->file_path) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @endif
                                <div class="text-center mt-3">
                                    <a href="{{ route('tabs-environment.section.edit.detail', [$tabContent->id, $mediaItem->id]) }}"
                                       title="{{ __('edit') }}" class="mx-3"> <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    @include('admin.pages.components.delete-form', [
                                        'id' => $mediaItem->id,
                                        'route' => route('tabs-environment.section.destroy.detail', [
                                            $tabContent->id,
                                            $mediaItem->id,
                                        ]),
                                        'message' => __('delete_message'),
                                    ])
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
