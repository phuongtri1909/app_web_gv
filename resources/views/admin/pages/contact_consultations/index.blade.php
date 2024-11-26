@extends('admin.layouts.app')
@push('styles-admin')
    <style>
        .img-square {
            width: auto;
            height: 100px;
        }
        .text-ellipsis {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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
                            <h5 class="mb-0">{{ __('Tư vấn liên hệ') }}</h5>
                        </div>
                        <a href="{{ route('contact-consultations.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button">
                            <i class="fa-solid fa-plus"></i> {{ __('Tạo mới') }}
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
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('Tên') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('Hình ảnh') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('Liên kết') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contactConsultations as $index =>  $contactConsultation)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{  $contactConsultation->name }}</p>
                                    </td>
                                    <td class="text-center">
                                        <img src="{{ asset($contactConsultation->image) }}" class="img-fluid img-square">
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0 text-ellipsis" style="max-width: 300px">{{ $contactConsultation->link }}</p>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('contact-consultations.edit', $contactConsultation->id) }}" class="mx-3" title="{{ __('Edit') }}">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        @include('admin.pages.components.delete-form', [
                                            'id' => $contactConsultation->id,
                                            'route' => route('contact-consultations.destroy', $contactConsultation->id),
                                            'message' => __('Bạn có muốn xóa khôngt?')
                                        ])
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <x-pagination :paginator="$contactConsultations" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
