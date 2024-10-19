@extends('admin.layouts.app')

@push('styles-admin')
@endpush

@section('content-auth')
    <div id="create-tuition">
        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h4 class="mb-0">{{ __('edit_content_tuition') }} :
                        {{ __('numerical_order') . ' : ' . $content->tuition->numerical_order }}</h4>
                </div>
                <div class="card-body pt-4 p-3">
                    <form action="{{ route('content-tuitions.update', $content->id) }}" method="POST" role="form text-left">
                        @csrf
                        @method('PUT')
                        @include('admin.pages.notification.success-error')

                        <div class="row mt-4">


                            @foreach ($translatedList as $key => $list)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="{{ 'list_' . $key }}" class="form-control-label">{{ __('list') }}:
                                            {{ $list }}</label>
                                        <div class="@error('list_' . $key) border border-danger rounded-3 @enderror">
                                            <input value="{{ old('list_' . $key, $list) }}" class="form-control"
                                                type="text" placeholder="{{ __('list') }}" id="{{ 'list_' . $key }}"
                                                name="{{ 'list_' . $key }}">
                                            @error('list_' . $key)
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @foreach ($translatedCost as $key => $cost)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="{{ 'cost_' . $key }}" class="form-control-label">{{ __('cost') }}:
                                            {{ $cost }}</label>
                                        <div class="@error('cost_' . $key) border border-danger rounded-3 @enderror">
                                            <input value="{{ old('cost_' . $key, $cost) }}" class="form-control"
                                                type="text" placeholder="{{ __('cost') }}" id="{{ 'cost_' . $key }}"
                                                name="{{ 'cost_' . $key }}">
                                            @error('cost_' . $key)
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @foreach ($translatedNote as $key => $note)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="{{ 'note_' . $key }}" class="form-control-label">{{ __('note') }}:
                                            {{ $note }}</label>
                                        <div class="@error('note_' . $key) border border-danger rounded-3 @enderror">
                                            <input value="{{ old('note_' . $key, $note) }}" class="form-control"
                                                type="text" placeholder="{{ __('note') }}" id="{{ 'note_' . $key }}"
                                                name="{{ 'note_' . $key }}">
                                            @error('note_' . $key)
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
