@extends('admin.layouts.app')

@push('styles-admin')
  
@endpush

@section('content-auth')
    <div id="create-tuition">
        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h4 class="mb-0">{{ __('create_new_content_tuition') }} : {{__('numerical_order'). ' : '. $tuition->numerical_order }}</h4>
                </div>
                <div class="card-body pt-4 p-3">
                    <form action="{{ route('content-tuitions.store',$tuition) }}" method="POST" role="form text-left">
                        @csrf
                        @include('admin.pages.notification.success-error')
                       
                        <div class="row mt-4">

                           
                        @php
                            $fields = [
                                'list' => __('list'),
                                'cost' => __('cost'),
                                'note' => __('note')
                            ];
                        @endphp
                        
                        
                        @foreach ($fields as $field => $label)
                            @foreach ($languages as $language)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="{{ $field . '_' . $language->locale }}" class="form-control-label">{{ $label }}: {{ $language->name }}</label>
                                        <div class="@error($field . '_' . $language->locale) border border-danger rounded-3 @enderror">
                                            @if ($field === 'note')
                                                <textarea class="form-control" placeholder="{{ $label }}" id="{{ $field . '_' . $language->locale }}" name="{{ $field . '_' . $language->locale }}">{{ old($field . '_' . $language->locale) }}</textarea>
                                            @else
                                                <input value="{{ old($field . '_' . $language->locale) }}" class="form-control" type="text" placeholder="{{ $label }}" id="{{ $field . '_' . $language->locale }}" name="{{ $field . '_' . $language->locale }}">
                                            @endif
                                            @error($field . '_' . $language->locale)
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
