@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Chi tiết khu phố của {{ $wardDetail->wardGovap->name }}</h5>
                        </div>
                        <div>
                            <a href="{{ route('ward-detail.districts.create', $wardDetail->id) }}" class="btn bg-gradient-primary">Thêm mới</a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STT</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên khu
                                        phố</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Diện
                                        tích</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tổng số
                                        hộ</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dân số
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bí thư
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trưởng
                                        KP
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($wardDetail->districts as $key => $district)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $district->name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $district->area }} ha</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $district->total_households }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $district->population }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $district->secretary_name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $district->head_name }}</p>
                                        </td>
                                        <td>
                                            <a href="{{ route('ward-detail.districts.edit', [$wardDetail->id, $district->id]) }}">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <a href="{{ route('blocks', $district->id) }}" class="mx-2" title="Xem tổ dân phố">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
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
