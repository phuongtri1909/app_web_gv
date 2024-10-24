@extends('admin.layouts.app')

@push('styles-admin')
  
@endpush

@section('content-auth')
    <div id="create-tuition">
        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h4 class="mb-0">{{ __('create_new_tuition') }}</h4>
                </div>
                <div class="card-body pt-4 p-3">
                    <form action="{{ route('tuitions.store') }}" method="POST" role="form text-left">
                        @csrf
                        @include('admin.pages.notification.success-error')
                       
                        <div class="row mt-4">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="numerical_order" class="form-control-label">{{ __('numerical_order') }}</label>
                                    <div class="@error('numerical_order')border border-danger rounded-3 @enderror">
                                        <input value="{{ old('numerical_order') }}" class="form-control" type="text"
                                            placeholder="{{ __('numerical_order') }}" id="numerical_order" name="numerical_order">
                                        @error('numerical_order')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            @foreach ($languages as $language)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="{{'title_'.$language->locale }}" class="form-control-label">{{ __('title') }}: {{ $language->name }}</label>
                                        <div class="@error('title_'.$language->locale) border border-danger rounded-3 @enderror">
                                            <input value="{{ old('title_'.$language->locale) }}" class="form-control" type="text"
                                                placeholder="{{ __('title') }}" id="{{'title_'.$language->locale }}" name="{{'title_'.$language->locale }}">
                                            @error('title_'.$language->locale)
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>    
                            @endforeach

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
    
@endpush
