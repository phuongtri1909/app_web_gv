@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Danh sách danh mục</h5>
                        </div>
                        <div>
                            <a href="{{ route('category-market.create') }}" class="btn bg-gradient-primary">Thêm mới</a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STT</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tên</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Banner</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $key => $item)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->name }}</p>
                                        </td>
                                        <td>
                                            @if ($item->banner)
                                                <img src="{{ asset($item->banner) }}" alt="banner" width="100">
                                            @else
                                                <p class="text-xs text-secondary mb-0">Không có</p>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('category-market.edit', $item->id) }}" class="text-primary">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>

                                            @include('admin.pages.components.delete-form', [
                                                'id' => $item->id,
                                                'route' => route('category-market.destroy', $item->id),
                                                'message' => __('Bạn có chắc chắn muốn xóa?'),
                                            ])
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
