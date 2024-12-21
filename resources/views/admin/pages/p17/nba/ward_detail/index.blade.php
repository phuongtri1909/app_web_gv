@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Chi tiết phường</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STT</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên
                                        phường</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Diện
                                        tích</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tổng số
                                        hộ</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($wardDetails as $key => $item)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->wardGovap->name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->area }} ha</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->total_households }}</p>
                                        </td>
                                        <td>
                                            <a href="{{ route('ward-detail.edit', $item->id) }}"><i
                                                    class="fa-regular fa-pen-to-square"></i></a>
                                            <a href="{{ route('ward-detail.districts', $item->id) }}" class="mx-2" title="Xem khu phố">
                                                    <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <x-pagination :paginator="$wardDetails" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
