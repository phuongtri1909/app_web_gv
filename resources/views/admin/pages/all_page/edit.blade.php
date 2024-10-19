@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">{{ __('edit_page_status') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('show.page.update', $page->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('admin.pages.notification.success-error')
                        <div class="form-group">
                            <label for="active">{{ __('status') }}</label>
                            <select class="form-control" id="active" name="active" required>
                                <option value="yes" {{ $page->active == 'yes' ? 'selected' : '' }}>{{ __('active') }}</option>
                                <option value="no" {{ $page->active == 'no' ? 'selected' : '' }}>{{ __('inactive') }}</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('update') }}</button>
                        <a href="{{ route('show.page.all') }}" class="btn btn-secondary">{{ __('cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
