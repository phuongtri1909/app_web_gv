@extends('admin.layouts.app')

@push('styles-admin')
@endpush
@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ __('all_detail_process') }}</h5>
                        </div>
                        <a href="{{ route('admission-process-detail.create',$admissionProcess->id) }}" class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button"><i class="fa-solid fa-plus"></i> {{ __('new_detail_process') }}</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">

                    @include('admin.pages.notification.success-error')

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('id') }}
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        {{ __('title') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('content') }}
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ __('action') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admissionProcessDetail as $item)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->id }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->title }}</p>
                                    </td>
                                    <td>
                                        <div class="content">
                                            {!! $item->content !!}
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                       
                                        <a href="{{ route('admission-process-detail.edit',$item->id) }}" class="mx-3"" title="{{ __('edit') }}">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        
                                        @include('admin.pages.components.delete-form', ['id' => $item->id, 'route' => route('admission-process-detail.destroy', $item->id),'message' => __('confirm_delete_detail_process')])
                              
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
