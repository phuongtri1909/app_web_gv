@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        #create-language .avatar {
            width: 130px;
            height: 70px;
        }
    </style>
@endpush

@section('content-auth')
    <div id="create-language">
        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h4 class="mb-0">{{ __('create_new_language') }}</h4>
                </div>
                <div class="card-body pt-4 p-3">
                    <form action="{{ route('languages.store') }}" method="POST" role="form text-left" enctype="multipart/form-data">
                        @csrf
                        @include('admin.pages.notification.success-error')
                        <div class="avatar position-relative d-block">
                            <img id="avatar-img" src="{{ asset('images/flag-default.png') }}" alt="..." class="w-100 border-radius-lg shadow-sm h-100">
                            <a href="javascript:;" id="edit-avatar-btn" class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 end-0 mb-n2 me-n2">
                                <i class="fa fa-pen top-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Image"></i>
                            </a>
                            <input type="file" id="avatar-input" style="display: none;" accept="image/*" name="flag">
                            @error('flag')
                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="row mt-4">
                            @foreach ($languages as $language)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="{{'name-'.$language->locale }}" class="form-control-label">{{ __('name') }}: {{ $language->name }}</label>
                                        <div class="@error('name-'.$language->locale) border border-danger rounded-3 @enderror">
                                            <input value="{{ old('name-'.$language->locale) }}" class="form-control" type="text"
                                                placeholder="{{ __('example') }}: {{ $language->name }}" id="{{'name-'.$language->locale }}" name="{{'name-'.$language->locale }}">
                                            @error('name-'.$language->locale)
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>    
                            @endforeach
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">{{ __('name') }}</label>
                                    <div class="@error('name') border border-danger rounded-3 @enderror">
                                        <input value="{{ old('name') }}" class="form-control" type="text"
                                            placeholder="{{ __('example') }}: Vietnames" id="name" name="name">
                                        @error('name')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="locale" class="form-control-label">{{ __('locale') }}</label>
                                    <div class="@error('locale')border border-danger rounded-3 @enderror">
                                        <input value="{{ old('locale') }}" class="form-control" type="text"
                                            placeholder="{{ __('example') }}: vi" id="locale" name="locale">
                                        @error('locale')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit"
                                class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ __('save_changes') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    <script>
        $(document).ready(function() {
        $('#edit-avatar-btn').on('click', function() {
            $('#avatar-input').click();
        });

        $('#avatar-input').on('change', function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#avatar-img').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });
    </script>
@endpush
