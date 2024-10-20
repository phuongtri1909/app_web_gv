@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">{{ __('tabs_content_post_add') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('news_contents.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            @foreach ($languages as $language)
                                <div class="form-group mb-3 col-md-6">
                                    <label for="{{ 'content_' . $language->locale }}">{{ __('content') }}: {{ $language->name }}</label>
                                    <textarea name="{{ 'content_' . $language->locale }}"
                                              id="{{ 'content_' . $language->locale }}"
                                              class="form-control @error('content_' . $language->locale) is-invalid @enderror"
                                              required>{{ old('content_' . $language->locale) }}</textarea>
                                    @error('content_' . $language->locale)
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group mb-3">
                            <label for="financial_support_id">{{ __('select_news') }}</label>
                            <select name="financial_support_id" id="financial_support_id" class="form-control @error('financial_support_id') is-invalid @enderror" required>
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
