@extends('admin.layouts.app')

@push('styles-admin')
    <style>
        .img-square {
            width: auto;
            height: 100px;
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
                            <h5 class="mb-0">{{ __('Dịch vụ tài trợ') }}</h5>
                        </div>
                        <a href="{{ route('financial-support.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button">
                            <i class="fa-solid fa-plus"></i> {{ __('Thêm dịch vụ mới') }}
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">

                    @include('admin.pages.notification.success-error')

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('stt') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('name') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('banner') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('Ngân hàng') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($financialSupports as $index => $financialSupport)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $financialSupport->name }}</p>
                                    </td>
                                    <td class="text-center">
                                        <img src="{{ asset($financialSupport->avt_financial_support) }}" class="img-fluid img-square">
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ optional($financialSupport->bank)->name ?? __('Không có ngân hàng') }}</p>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('financial-support.edit', $financialSupport->id) }}" class="mx-3" title="{{ __('Edit') }}">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        @include('admin.pages.components.delete-form', [
                                            'id' => $financialSupport->id,
                                            'route' => route('financial-support.destroy', $financialSupport->id),
                                            'message' => __('Bạn có muốn xóa khôngt?')
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

@push('scripts-admin')
@endpush
