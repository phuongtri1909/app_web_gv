@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        .img-square{
            width: 200px;
            height: 100px;
            object-fit: cover;
        }
    </style>
@endpush

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ __('all_posts') }}</h5>
                        </div>
                        <a href="{{ route('news.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2"
                            type="button"><i class="fa-solid fa-plus"></i> {{ __('add_post') }}</a>
                    </div>
                    <div class="mt-2">
                        <form method="GET" class="d-md-flex">
                            @if (request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            <select name="search-category" class="form-control-sm me-2">
                                <option value="">Tất cả danh mục </option>
                                    @foreach ($categories as $item)
                                    <option value="{{ $item->slug }}" {{ request('search-category') == $item->slug ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                    @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm mb-0 mt-2 mt-md-0">Tìm kiếm</button>
                        </form>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">

                    @include('admin.pages.notification.success-error')

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('stt') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('title') }}
                                    </th>
                                    {{-- <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('content') }}
                                    </th> --}}
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('image') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('categories_news') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('tags') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('published_at') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($blogs->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ __('Không có kết quả nào.') }}</p>
                                    </td>
                                </tr>
                                @else
                                    @foreach ($blogs as $key => $post)
                                        <tr>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $post->title }}</p>
                                            </td>
                                            {{-- <td>
                                                <p class="text-xs font-weight-bold mb-0">{!! $post->content !!}</p>
                                            </td> --}}
                                            <td>
                                                @if (!empty($post->image))
                                                    <div>
                                                        <img src="{{ asset($post->image) }}" class="img-fluid img-square"
                                                            alt="Image">
                                                    </div>
                                                @else
                                                    <p class="text-xs font-weight-bold mb-0">{{ __('no_image') }}</p>
                                                @endif
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    @foreach ($post->categories as $category)
                                                        {{ $category->name }}
                                                        @if (!$loop->last)

                                                        @endif
                                                    @endforeach
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    @foreach ($post->tags as $tag)
                                                        {{ $tag->name }}
                                                        @if (!$loop->last)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $post->published_at }}</p>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('news.edit', $post->id) }}" class="mx-3"
                                                    title="{{ __('edit') }}">
                                                    <i class="fa-solid fa-pencil"></i>
                                                </a>
                                                @include('admin.pages.components.delete-form', [
                                                    'id' => $post->id,
                                                    'route' => route('news.destroy', $post->id),
                                                    'message' => __('delete_message'),
                                                ])
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <x-pagination :paginator="$blogs" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    <script>
        // You can add custom scripts here
    </script>
@endpush
