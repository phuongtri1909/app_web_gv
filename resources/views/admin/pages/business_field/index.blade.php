@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        .img-square{
            width: 200px;
            height: 200px;
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
                            <h5 class="mb-0">Danh sách ngành nghề kinh doanh</h5>
                        </div>
                        <a href="{{ route('business-fields.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2"
                            type="button"><i class="fa-solid fa-plus"></i> Ngành nghề</a>
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
                                        Tên ngành nghề
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                        Icon
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($businessFields as $key => $item)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->name }}</p>
                                        </td>
                                        <td class="text-center">
                                            <img src="{{ asset($item->icon ?? 'images/icon/icon_location.png') }}" alt="{{ $item->name }}" width="45" height="45">
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('business-fields.edit', $item->id) }}" class="mx-3"
                                                title="{{ __('edit') }}">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $item->id,
                                                'route' => route('business-fields.destroy', $item->id),
                                                'message' => 'Bạn có muốn xóa ngành nghề này không?',
                                            ])
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <x-pagination :paginator="$businessFields" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
   
@endpush
