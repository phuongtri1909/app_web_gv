@extends('admin.layouts.app')

@push('styles-admin')
@endpush
@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div class="mb-3">
                            <h5 class="mb-0">{{ __('edit_language_system') }} : {{ $language->name }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4 p-3">

                    @include('admin.pages.notification.success-error')

                    <form action="{{ route('languages.update-system', ['locale' => $language->locale]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <textarea name="language_system" class="form-control col-12 @error('language_system') is-invalid @enderror" rows="20">{{ old('language_system', isset($jsonContent) ? $jsonContent : '{}') }}</textarea>
                        @error('language_system')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ __('save_changes') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts-admin')
@endpush
