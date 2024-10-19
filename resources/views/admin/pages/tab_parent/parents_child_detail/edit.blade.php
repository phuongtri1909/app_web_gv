@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">{{ __('edit_media') }}</h5>
                </div>
                <div class="card-body">
                    <form
                        action="{{ route('ParentChildDetail.update.detail', [$mediaItem->tab_project_id, $mediaItem->id]) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3 col-md-12">
                            <label for="file" class="form-label">{{ __('upload_new_media') }}</label>
                            <input type="file" name="file" id="file"
                                class="form-control @error('file') is-invalid @enderror">
                            @error('file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @if (session('error'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ session('error') }}</strong>
                                </span>
                            @endif
                        </div>

                        @if ($mediaItem->image)
                            <div class="form-group mb-3 col-md-12">
                                <label>{{ __('current_media') }}</label>
                                <div>
                                    <img src="{{ asset($mediaItem->image) }}" class="img-fluid img-square"
                                        alt="Image" width="200px" height="150px">
                                </div>
                            </div>
                        @endif

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">{{ __('update_media') }}</button>
                            <a href="{{ route('tabs-programs.component3pp.show.detail', $mediaItem->tab_project_id) }}"
                                class="btn btn-secondary">{{ __('cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
