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
                        action="{{ route('tabs-environment.section.update.detail', [$mediaItem->tabs_img_content_id, $mediaItem->id]) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="type" class="form-label">{{ __('media_type') }}</label>
                            <select name="type" class="form-control" required>
                                <option value="image" {{ $mediaItem->type == 'image' ? 'selected' : '' }}>
                                    {{ __('image') }}</option>
                                <option value="video" {{ $mediaItem->type == 'video' ? 'selected' : '' }}>
                                    {{ __('video') }}</option>
                            </select>
                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
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

                        @if ($mediaItem->file_path)
                            <div class="form-group mb-3 col-md-12">
                                <label>{{ __('current_media') }}</label>
                                <div>
                                    @if ($mediaItem->type === 'image')
                                        <img src="{{ asset($mediaItem->file_path) }}" class="img-fluid img-square"
                                            alt="Image" width="200px" height="150px">
                                    @elseif ($mediaItem->type === 'video')
                                        <video width="320" height="240" controls>
                                            <source src="{{ asset($mediaItem->file_path) }}" type="video/mp4">
                                            {{ __('Your browser does not support the video tag.') }}
                                        </video>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">{{ __('update_media') }}</button>
                            <a href="{{ route('tabs-environment.section.show.detail', $mediaItem->tabs_img_content_id) }}"
                                class="btn btn-secondary">{{ __('cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
