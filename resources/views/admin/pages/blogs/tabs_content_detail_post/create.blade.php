@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">{{ __('Tạo bài viết') }}</h5>
                </div>
                <div class="card-body">
                    @include('admin.pages.notification.success-error')
                    <form action="{{ route('news_contents.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group mb-3 col-md-12">
                                <label for="content">{{ __('content') }}</label>
                                <textarea name="content" id="content"
                                          class="form-control @error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="financial_support_id">{{ __('Chọn dịch vụ') }}</label>
                            <select name="financial_support_id" id="financial_support_id" class="form-control @error('financial_support_id') is-invalid @enderror" >
                                <option value="">{{ __('select_news_placeholder') }}</option>
                                @foreach ($news as $newsItem)
                                    <option value="{{ $newsItem->id }}">{{ $newsItem->name }}</option>
                                @endforeach
                            </select>
                            @error('financial_support_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="bank_service_id">{{ __('Chọn dịch vụ ngân hàng') }}</label>
                            <select name="bank_service_id" id="bank_service_id" class="form-control @error('bank_service_id') is-invalid @enderror" >
                                <option value="">{{ __('select_news_placeholder') }}</option>
                                @foreach ($bank_servicers as $newsItem)
                                    <option value="{{ $newsItem->id }}">{{ $newsItem->name }}</option>
                                @endforeach
                            </select>
                            @error('bank_service_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="tab_id">{{ __('select_tab') }}</label>
                            <select name="tab_id" id="tab_id" class="form-control @error('tab_id') is-invalid @enderror" required>
                                <option value="">{{ __('select_tab_placeholder') }}</option>
                                @foreach ($tabs as $tab)
                                    <option value="{{ $tab->id }}">{{ $tab->name }}</option>
                                @endforeach
                            </select>
                            @error('tab_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('create') }}</button>
                        <a href="{{ route('news_contents.index') }}" class="btn btn-secondary">{{ __('cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts-admin')
    <script>
            CKEDITOR.replace("content", {
            });
    </script>
@endpush
