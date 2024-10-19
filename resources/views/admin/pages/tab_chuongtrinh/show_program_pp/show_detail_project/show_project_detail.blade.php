@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ __('detail_of') }} {{ $tab_projects->project_name }}</h5>
                        </div>
                        <a href="{{ route('tabs-programs.component3pp.create.detail', $tab_projects->id) }}"
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
                                <img src="{{ asset($mediaItem->image) }}" class="img-fluid img-square" alt="Image">

                                <div class="text-center mt-3">
                                    <a href="{{ route('tabs-programs.component3pp.edit.detail', [$tab_projects->id, $mediaItem->id]) }}"
                                        title="{{ __('edit') }}" class="mx-3"> <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    @include('admin.pages.components.delete-form', [
                                        'id' => $mediaItem->id,
                                        'route' => route('tabs-programs.component3pp.destroy.detail', [
                                            $tab_projects->id,
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
